<?php namespace Movo\Orders;


use Coupon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

use Movo\Errors\OrderException;
use Movo\Handlers\DonationHandler;
use Movo\Handlers\InputLogHandler;
use Movo\Handlers\OrderErrorLogHandler;
use Movo\Handlers\OrderHandler;
use Movo\Handlers\OrderLogHandler;
use Movo\Handlers\PusherHandler;
use Movo\Handlers\ReceiptHandler;
use Movo\Handlers\ShippingHandler;
use Movo\Observer\Subject;
use Movo\SalesTax\SalesTax;
use Order;
use Product;
use SebastianBergmann\Exporter\Exception;
use Shipping;

class ProcessOrder
{

    public function process()
    {

        $data = [];
        $data = OrderInput::convertInputToData($data);

        if(!OrderValidate::validate($data)){
            (new OrderErrorLogHandler)->handleNotification($data);

            return Response::json(array('status' => '503', 'error_code'=>2000,'message' => 'Error 2000: There was a critical error submitting your order. Please refresh the page and try again.'));
        }
        $billing = App::make('Movo\Billing\BillingInterface');
        $salesTax = App::make('Movo\SalesTax\SalesTaxInterface');
        $couponInstance = Coupon::getValidCouponInstance();
        $shippingState = Input::get("shipping-state");
        try {
            $salesTaxRate = $salesTax->getRate(Input::get("shipping-zip"), $shippingState);
        } catch (Exception $e) {
            return Response::json(array('status' => '400', 'error_code'=>1001,'message' => 'Error 1001: There was an error submitting your order. Please try again.'));
        }
        if (!isset($salesTaxRate)) {
            return Response::json(array('status' => '400', 'error_code'=>1002,'message' => 'Error 1002: There was an error submitting your order. Your state and zip code do not match'));
        }

        try {
            $products=Product::getAll();
            $totalUnitPrices=0;
            $totalDiscount=0;
            for ($i = 0; $i < sizeof($data['items']); $i++) {
              foreach($products as $product){
                    if($product->sku==$data['items'][$i]['sku']){
                        if(!isset($data['items'][$i]['quantity'])){
                            $data['items'][$i]['quantity']=1;
                        }
                        $data['items'][$i]['price']=$product->price;

                        $data['items'][$i]['line-no']=$i+1;
                        $data['items'][$i]['item-code']=$product->sku;
                        $data['items'][$i]['Unit-of-measure']='EA';


                        $data['items'][$i]['discount'] = $this->getDiscount($couponInstance, $product->price*$data['items'][$i]['quantity']);
                        $totalUnitPrices+=$product->price*$data['items'][$i]['quantity'];
                        $totalDiscount+=$data['items'][$i]['discount'];
                    }
                }
            }

            $shippingMethod = Shipping::getShippingMethod(Input::get("shipping-type"));

        } catch (Exception $e) {
            return Response::json(array('status' => '400', 'error_code'=>1003,'message' => 'Error 1003: There was an error submitting your order. Please try again.'));
        }


        $orderTotal = $this->getOrderTotal($totalUnitPrices, $totalDiscount, $shippingMethod, $salesTaxRate, $shippingState);
        $data = $this->populateDataWithOrderAmounts($data, $totalUnitPrices,  $totalDiscount, $shippingMethod, $salesTaxRate, $shippingState, $couponInstance);
        (new InputLogHandler)->handleNotification($data);
        try {
            $order = (new OrderHandler)->handleNotification($data);
            //(new DonationHandler)->handleNotification(["order"=>$order,"data"=>$data]);
            $data['order_id'] = $order->id;
        } catch (ErrorException $e) {
            return Response::json(array('status' => '400', 'error_code'=>1004,'message' => 'Error 1004: There was an error submitting your order. Please try again.'));
        }
        try {
            $result = $this->attemptCharge($billing, $orderTotal, $data);
        } catch (Exception $e) {
            $this->flagOrderAsCriticalError($order);
            return Response::json(array('status' => '400', 'error_code'=>2001,'message' => 'Error 2001: There was an error submitting your order.'));
        }
        if ($result) {
            $result['_apiKey']=null;
            $data = $this->updateDataWithChargeInfo($result, $data);
            $this->updateOrderWithChargeId($result, $order);

            (new OrderLogHandler)->handleNotification($data);
            (new ShippingHandler)->handleNotification($data); // This notifies Ingram of an incoming order
            // (new ShippingHandler)->handleNotificationWithSettings($this->env, $this->url, $data); // This notifies Ingram of an incoming order

            (new ReceiptHandler)->handleNotification($data); // This sends the email to the customer
            return Response::json(array('status' => '200', 'message' => 'Your order has been submitted!', 'data' => $data));

        }  else {
            $this->updateOrderWithDeclinedCardErrorFlag($order);
            return Response::json(array('status' => '400','error_code'=>1005, 'message' => 'Error 1005: There was a problem processing your credit card.'));

        }
    }

    public function processMultipleOffline($masterOrderList) {

        $orderLog = new OrderErrorLogHandler();
        $response = '';
        foreach($masterOrderList as $key => $order) {
            $data = $order->asArray();
            $response = $this->processOffline($data);

            $orderLog ->handleNotification(['response' => $response]);
            // if one of the orders throws an error
            // return immediately
            /*
            $jsonArray = json_decode($response, true);
            if( intval($jsonArray['status']) != 200 ) {
                return $response;
            }
            */

        }

        return $response;
    }



    public function processOffline($data)
    {


        if(!OrderValidate::validateCsvOrder($data)){
            (new OrderErrorLogHandler)->handleNotification($data);

            return Response::json(array('status' => '503', 'error_code'=>2000,'message' => 'Error 2000: There was a critical error submitting your order. Please refresh the page and try again.'));
        }

        $couponInstance = Coupon::getValidCouponInstanceCSV($data);
        $shippingState = $data["shipping-state"];
        try {
            $salesTaxRate = 0.00;
        } catch (Exception $e) {
            return Response::json(array('status' => '400', 'error_code'=>1001,'message' => 'Error 1001: There was an error submitting your order. Please try again.'));
        }
        if (!isset($salesTaxRate)) {
            return Response::json(array('status' => '400', 'error_code'=>1002,'message' => 'Error 1002: There was an error submitting your order. Your state and zip code do not match'));
        }

        try {
            $products=Product::getAll();
            $totalUnitPrices=0;
            $totalDiscount=0;
            for ($i = 0; $i < sizeof($data['items']); $i++) {

                foreach($products as $product){
                    if($product->sku==$data['items'][$i]['sku']){

                        if(!isset($data['items'][$i]['quantity'])){
                            $data['items'][$i]['quantity']=1;
                        }
                        $data['items'][$i]['price']=$product->price;

                        $data['items'][$i]['line-no']=$i+1;
                        $data['items'][$i]['item-code']=$product->sku;
                        $data['items'][$i]['Unit-of-measure']='EA';

                        $data['items'][$i]['discount'] = $this->getDiscount($couponInstance, $product->price*$data['items'][$i]['quantity']);
                        $totalUnitPrices+=$product->price*$data['items'][$i]['quantity'];
                        $totalDiscount+=$data['items'][$i]['discount'];
                    }
                }
            }

            $shippingMethod = Shipping::getShippingMethod($data["shipping-type"]);

        } catch (Exception $e) {
            return Response::json(array('status' => '400', 'error_code'=>1003,'message' => 'Error 1003: There was an error submitting your order. Please try again.'));
        }
        $saveEmail = $data['email'];

        $orderTotal = $this->getOrderTotal($totalUnitPrices, $totalDiscount, $shippingMethod, $salesTaxRate, $shippingState);
        $data = $this->populateDataWithOrderAmounts($data, $totalUnitPrices,  $totalDiscount, $shippingMethod, $salesTaxRate, $shippingState, $couponInstance);

        // NOTE: this is a hack to get around the fact that populateDataWithOrderAmounts over writes the email value.
        $data['email'] = $saveEmail;

        (new InputLogHandler)->handleNotification($data);
        try {
            $order = (new OrderHandler)->handleNotification($data);
            $data['order_id'] = $order->id;
            //(new DonationHandler)->handleNotification(["order"=>$order,"data"=>$data]);
        } catch (ErrorException $e) {
            return Response::json(array('status' => '400', 'error_code'=>1004,'message' => 'Error 1004: There was an error submitting your order. Please try again.'));
        }

        try {
            $result = $this->fakeCharge($orderTotal, $data);
        } catch (Exception $e) {
            $this->flagOrderAsCriticalError($order);
            return Response::json(array('status' => '400', 'error_code'=>2001,'message' => 'Error 2001: There was an error submitting your order.'));
        }

        $result['id'] = "no stripe charge";

        if ($result) {
            $result['_apiKey']=null;
            $data = $this->updateDataWithChargeInfo($result, $data);
            $this->updateOrderWithChargeId($result, $order);
            (new OrderLogHandler)->handleNotification($data);

            (new ShippingHandler)->handleNotification($data); // This notifies Ingram of an incoming order
            // (new ShippingHandler)->handleNotificationWithSettings($this->env, $this->url, $data); // This notifies Ingram of an incoming order

            $data['email'] = 'michael@getmovo.com';
            $data['email'] = getenv('ingram.receipt-email'); // highjack the email address so customers don't get an email
            (new ReceiptHandler)->handleOfflineNotification($data); // This sends the email to the customer

            return Response::json(array('status' => '200', 'message' => 'Your order has been submitted!', 'data' => $data));

        }  else {
            $this->updateOrderWithDeclinedCardErrorFlag($order);
            return Response::json(array('status' => '400','error_code'=>1005, 'message' => 'Error 1005: There was a problem processing your credit card.'));
        }
    }



    private function getOrderTotal($totalUnitPrices, $discount, $shippingMethod, $salesTaxRate, $state)
    {
        $orderTotal = CalculateOrderTotal::calculateTotal([
            "tax-rate" => $salesTaxRate,
            "total-unit-prices" => $totalUnitPrices,
            "state" => $state,
            "shipping-rate" => $shippingMethod->rate,
            "discount" => $discount,
        ]);
        return $orderTotal;
    }

    /**
     * @param $data
     * @param $totalUnitPrices
     * @param $quantity
     * @param $discount
     * @param $shippingMethod
     * @param $salesTaxRate
     * @param $shippingState
     * @param $couponInstance
     * @return mixed
     */
    public function populateDataWithOrderAmounts($data,  $totalUnitPrices, $discount, $shippingMethod, $salesTaxRate, $shippingState, $couponInstance)
    {

        $tax=SalesTax::calculateTotalTax($totalUnitPrices  - $discount, $shippingMethod->rate, $salesTaxRate, $shippingState);
        $data['token'] = Input::get("token");
        $orderTotal=  round($totalUnitPrices  - $discount+ $shippingMethod->rate+$tax,2);
        $data['email'] = Input::get("email");
        $data ['total-unit-prices'] = $totalUnitPrices;
        $data ['tax'] = $tax;
        $data ['discount'] = $discount;
        $data ['couponInstance'] = $couponInstance;
        $data ['shipping-rate'] = $shippingMethod->rate;
        $data ['shipping-code'] = $shippingMethod->scac_code;
        $data['amount'] = $orderTotal;
        $data ['order-total'] = $orderTotal;
        return $data;
    }

    /**
     * @param $billing
     * @param $orderTotal
     * @param $data
     * @return mixed
     */
    private function attemptCharge($billing, $orderTotal,$data)
    {
        $result = $billing->charge([
            'token' => Input::get("token"),
            'amount' => $orderTotal,
            'email' => Input::get("email"),
            'metadata'=>[
                "first_name"=>  $data['billing-first-name'],
                "last_name"=>  $data['billing-last-name'],
                "phone"=>  $data['billing-phone']
            ]
        ]);
        return $result;
    }


    /**
     * @param $billing
     * @param $orderTotal
     * @param $data
     * @return mixed
     */
    private function fakeCharge($orderTotal,$data)
    {
        $result = array();
        $result['token'] = 'no token';
        $result['amount'] = intval(round($orderTotal * 100));
        $result['email'] = $data['email'];
        $result['metadata'] = [
                "first_name"=>  $data['billing-first-name'],
                "last_name"=>  $data['billing-last-name'],
                "phone"=>  $data['billing-phone']
            ];

        return $result;
    }


    /**
     * @param $order
     */
    private function flagOrderAsCriticalError($order)
    {
        $order->error_flag = 2;
        $order->save();
    }

    /**
     * @param $result
     * @param $order
     */
    private function updateOrderWithChargeId($result, $order)
    {
        $order->stripe_charge_id = $result['id'];
        $order->save();
    }

    /**
     * @param $couponInstance
     * @param $unitPrice
     * @return int
     */
    private function getDiscount(Coupon $couponInstance=null, $unitPrice)
    {
        $discount = $couponInstance ? $couponInstance->calculateCouponDiscount($unitPrice, 1) : 0;
        return $discount;
    }

    /**
     * @param $result
     * @param $data
     * @return mixed
     */
    private function updateDataWithChargeInfo($result, $data)
    {
        $data ['result'] = $result;
        $data ['charge-id'] = $result['id'];
        return $data;
    }

    /**
     * @param $order
     */
    private function updateOrderWithDeclinedCardErrorFlag($order)
    {
        $order->error_flag = -1;
        $order->save();
    }

}
