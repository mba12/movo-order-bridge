<?php namespace Movo\Orders;


use Coupon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Movo\Errors\OrderException;
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
            return Response::json(array('status' => '503', 'message' => 'There was a critical error submitting your order. Please refresh the page and try again.'));
        }
        $billing = App::make('Movo\Billing\BillingInterface');
        $salesTax = App::make('Movo\SalesTax\SalesTaxInterface');
        $couponInstance = Coupon::getValidCouponInstance();
        $quantity = Input::get("quantity");
        $shippingState = Input::get("shipping-state");
        try {
            $salesTaxRate = $salesTax->getRate(Input::get("shipping-zip"), $shippingState);
        } catch (Exception $e) {
            return Response::json(array('status' => '400', 'message' => 'There was an error submitting your order. Please try again.'));
        }
        if (!isset($salesTaxRate)) {
            return Response::json(array('status' => '400', 'message' => 'There was an error submitting your order. Your state and zip code do not match'));
        }

        try {
            $unitPrice = Product::getUnitPrice();
            $shippingMethod = Shipping::getShippingMethod(Input::get("shipping-type"));
            $discount = $couponInstance ? $couponInstance->calculateCouponDiscount($unitPrice, Input::get("quantity")) : 0;
        } catch (Exception $e) {
            return Response::json(array('status' => '400', 'message' => 'There was an error submitting your order. Please try again.'));
        }
        $orderTotal = $this->getOrderTotal($unitPrice, $quantity, $discount, $shippingMethod, $salesTaxRate, $shippingState);

        $data['token'] = Input::get("token");
        $data['amount'] = $orderTotal;
        $data['email'] = Input::get("email");
        (new InputLogHandler)->handleNotification($data);

        try {
            $result = $billing->charge($data);
        } catch (Exception $e) {
            return Response::json(array('status' => '400', 'message' => 'There was an error submitting your order. Please try again.'));
        }
        if ($result) {
            $data ['result'] = $result;
            $data ['unit-price'] = $unitPrice;
            $data ['tax'] = SalesTax::calculateTotalTax($unitPrice * $quantity - $discount, $shippingMethod->rate, $salesTaxRate, $shippingState);
            $data ['discount'] = $discount;
            $data ['couponInstance'] = $couponInstance;
            $data ['shipping-rate'] = $shippingMethod->rate;
            $data ['shipping-type'] = $shippingMethod->type;
            $data ['shipping-code'] = $shippingMethod->scac_code;
            $data ['charge-id'] = $result['id'];
            $data ['order-total'] = $orderTotal;

            (new OrderLogHandler)->handleNotification($data);
            (new OrderHandler)->handleNotification($data);
            (new ShippingHandler)->handleNotification($data);
            (new ReceiptHandler)->handleNotification($data);
            return Response::json(array('status' => '200', 'message' => 'Your order has been submitted!', 'data' => $data));

        } else {
            return Response::json(array('status' => '400', 'message' => 'There was an error submitting your order'));

        }
    }


    private function getOrderTotal($unitPrice, $quantity, $discount, $shippingMethod, $salesTaxRate, $state)
    {
        $orderTotal = CalculateOrderTotal::calculateTotal([
            "quantity" => $quantity,
            "tax-rate" => $salesTaxRate,
            "unit-price" => $unitPrice,
            "state" => $state,
            "shipping-rate" => $shippingMethod->rate,
            "discount" => $discount,
        ]);
        return $orderTotal;
    }

}





