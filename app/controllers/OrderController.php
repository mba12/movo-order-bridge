<?php

use Illuminate\Support\Facades\Input;
use Movo\Shipping\ShippingDropdown;

class OrderController extends BaseController
{
    public function showForm()
    {

        $unitPrice = Product::getUnitPrice();
        $shippingInfo = Shipping::getShippingMethodsAndPrices();
        $shippingDropdownData = ShippingDropdown::createData($shippingInfo);
        $sizeInfo = Size::getUnitSizes();
        $stateTaxMethods = Tax::getStateTaxMethods();
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
            'stateTaxMethods' => $stateTaxMethods
        ]);
    }

    public function buy()
    {
        $processor=new Movo\Orders\ProcessOrder();
        return $processor->process();
    }
}
