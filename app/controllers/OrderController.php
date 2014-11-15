<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class OrderController extends BaseController
{
    public function showForm()
    {

        $unitPrice = $this->getUnitPrice();
        $shippingInfo = Shipping::all();
        $shippingDropdownData = $this->createShippingDropdownData($shippingInfo);
        $sizeInfo = Size::all();
        $taxRates = Tax::all();
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
            'taxRates' => $taxRates,
        ]);
    }

    private function  createShippingDropdownData($shippingInfo)
    {
        $shippingTypes = "";
        $shippingIds = "";
        $shippingRates = "";
        $i = 0;
        foreach ($shippingInfo as $info) {
            if ($i > 0) {
                $shippingTypes .= '|';
                $shippingIds .= '|';
                $shippingRates .= '|';
            }
            $shippingTypes .= $info->type;
            $shippingIds .= $info->id;
            $shippingRates .= $info->rate;
            $i++;
        }
        $dropdownData = [
            'shippingTypes' => $shippingTypes,
            'shippingIds' => $shippingIds,
            'shippingRates' => $shippingRates,
        ];
        return $dropdownData;
    }

    public function buy()
    {

        $billing = App::make('Movo\Billing\BillingInterface');
        $shipping = App::make('Movo\Shipping\ShippingInterface');
        $receipt = App::make('Movo\Receipts\ReceiptsInterface');

        $couponData = $this->validateCouponCode();

        $unitPrice = $this->getUnitPrice();
        $shippingMethod = $this->getShippingRate();

        //dd(Input::all());
        $result = $billing->charge([
            'token' => Input::get("token"),
            'unit-price' => $unitPrice,
            'couponData' => $couponData,
            'shipping-rate' => $shippingMethod->rate,
            'shipping-type' => $shippingMethod->type,
        ]);

        if ($result) {
            $shipping->ship([
                'result' => $result,
                'unit-price' => $unitPrice,
                'couponData'=>$couponData,
                'shipping-rate' => $shippingMethod->rate,
                'shipping-type' => $shippingMethod->type,
            ]);
            $this->saveOrder($result);
            $receipt->send([
                "result" => $result,
                'unit-price' => $unitPrice,
                'couponData'=>$couponData,
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

        $product = DB::table('products')->first();
        return $product->price;
    }

    private function getShippingRate()
    {
        $shipping = Shipping::find(Input::get("shipping-type"));
        return $shipping;

    }

    private function validateCouponCode()
    {
        if (Input::has("code")&& Input::has("coupon_instance")) {
            $validCoupon = CouponInstance::where("code", "=", Input::get("code"))
                ->where("token", "=", Input::get("coupon_instance"))
                ->where("used", "=", 0);
            if ($validCoupon) {
                $couponData = Coupon::where("code", "=", Input::get("code"))->first();
                if ($couponData) {
                     if ($couponData->min_units == 0 || $couponData->min_units <= Input::get("quantity")) {
                         return $couponData;
                    }
                }
            }

        }
        return null;
    }
}
