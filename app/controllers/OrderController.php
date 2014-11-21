<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Movo\Helpers\Format;

class OrderController extends BaseController
{
    public function showForm()
    {

        $unitPrice = $this->getUnitPrice();
        $shippingInfo = $this->getShippingInfo();
        $shippingDropdownData = Shipping::createShippingDropdownData($shippingInfo);
        $sizeInfo = $this->getUnitSizes();
        $coupon = null;
        $code = Input::get("code");
        if ($code) {
            $coupon = Coupon::where("code", "=", $code)->first();
        }
        return View::make('order-form', [
            'shippingDropdownData' => $shippingDropdownData,
            'unitPrice' => $unitPrice,
            'sizeInfo' => $sizeInfo,
            'coupon' => $coupon,
        ]);
    }

    public function buy()
    {
        $billing = App::make('Movo\Billing\BillingInterface');
        $shipping = App::make('Movo\Shipping\ShippingInterface');
        $receipt = App::make('Movo\Receipts\ReceiptsInterface');
        $salesTax = App::make('Movo\SalesTax\SalesTaxInterface');

        $couponInstance = Coupon::getValidCouponInstance();

        $salesTaxRate = $salesTax->getRate(Input::get("shipping-zip"), Input::get("shipping-state"));
        if (!isset($salesTaxRate)) {
            return Response::json(array('status' => '400', 'message' => 'There was an error submitting your order. Your state and zip code do not match'));
        }

        $unitPrice = $this->getUnitPrice();
        $shippingMethod = $this->getShippingMethod();
        $discount = $couponInstance ? $couponInstance->calculateCouponDiscount($unitPrice, Input::get("quantity")) : 0;

        $result = $billing->charge([
            'token' => Input::get("token"),
            'amount' => $this->getOrderTotal($unitPrice,Input::get("quantity"),$discount,$shippingMethod,$salesTaxRate,Input::get("shipping_state")),
            'email'=>Input::get("email")
        ]);

        if ($result) {
            $shipping->ship([
                'result' => $result,
                'unit-price' => $unitPrice,
                'couponInstance' => $couponInstance,
                'shipping-rate' => $shippingMethod->rate,
                'shipping-type' => $shippingMethod->type,
            ]);
            $this->saveOrder($result);
            $receipt->send([
                "result" => $result,
                'unit-price' => $unitPrice,
                'couponInstance' => $couponInstance,
                'shipping-rate' => $shippingMethod->rate,
                'shipping-type' => $shippingMethod->type,
            ]);
            $pusher = App::make("Pusher");
            $pusher->trigger("orderChannel", "completedOrder", []);
            return Response::json(array('status' => '200', 'message' => 'Your order has been submitted!'));

        } else {
            return Response::json(array('status' => '400', 'message' => 'There was an error submitting your order'));

        }
    }

    private function saveOrder($result)
    {
        $order = new Order();
        $order->saveOrder($result['amount'], $result['id']);
    }

    private function getUnitPrice()
    {
        if (Cache::has("unit-price")) {
            return Cache::get("unit-price");
        }
        $product = DB::table('products')->first();
        Cache::put("unit-price", $product->price, 1440);
        return $product->price;
    }

    private function getShippingMethod()
    {
        $shipping = Shipping::find(Input::get("shipping-type"));
        return $shipping;
    }

    private function getShippingInfo()
    {
        if (Cache::has("shipping-info")) {
            return Cache::get("shipping-info");
        }
        $shippingInfo = Shipping::all();
        Cache::put("shipping-info", $shippingInfo, 1440);
        return $shippingInfo;
    }

    private function getUnitSizes()
    {
        if (Cache::has("unit-sizes")) {
            return Cache::get("unit-sizes");
        }
        $unitSizes = Size::all();
        Cache::put("unit-sizes", $unitSizes, 1440);
        return $unitSizes;

    }

    private function getOrderTotal($unitPrice,$quantity, $discount,$shippingMethod,$salesTaxRate,$state)
    {
        $orderTotal = Order::calculateTotal([
            "quantity"=>$quantity = $quantity,
            "tax-rate"=>$salesTaxRate,
            "unit-price"=>$unitPrice,
            "state"=>$state,
            "shipping-rate"=>$shippingMethod->rate,
            "discount"=>$discount,
        ]);
        return $orderTotal;
    }
}
