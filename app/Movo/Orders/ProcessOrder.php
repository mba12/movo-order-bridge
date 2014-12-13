<?php        namespace Movo\Orders;


use Coupon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Movo\Errors\OrderException;
use Movo\Handlers\OrderHandler;
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
        $billing = App::make('Movo\Billing\BillingInterface');
        $salesTax = App::make('Movo\SalesTax\SalesTaxInterface');
        $couponInstance = Coupon::getValidCouponInstance();
        $quantity=Input::get("quantity");
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
        $orderTotal=$this->getOrderTotal($unitPrice, $quantity, $discount, $shippingMethod, $salesTaxRate, $shippingState);
        try {
            $result = $billing->charge([
                'token' => Input::get("token"),
                'amount' => $orderTotal,
                'email' => Input::get("email")
            ]);
        } catch (Exception $e) {
            return Response::json(array('status' => '400', 'message' => 'There was an error submitting your order. Please try again.'));
        }

        if ($result) {
            $data = [
                'result' => $result,
                'unit-price' => $unitPrice,
                'tax' => SalesTax::calculateTotalTax($unitPrice * $quantity - $discount,$shippingMethod->rate,$salesTaxRate,$shippingState),
                'discount' => $discount,
                'couponInstance' => $couponInstance,
                'shipping-rate' => $shippingMethod->rate,
                'shipping-type' => $shippingMethod->type,
                'shipping-code' => $shippingMethod->scac_code,
                'charge-id'=>$result['id'],
                'order-total'=>$orderTotal
            ];
            $data=OrderInput::convertInputToData($data);
            (new OrderHandler)->handleNotification($data);
            (new ShippingHandler)->handleNotification($data);
            (new ReceiptHandler)->handleNotification($data);
            (new PusherHandler)->handleNotification($data);
            return Response::json(array('status' => '200', 'message' => 'Your order has been submitted!', 'data'=>$data));

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





