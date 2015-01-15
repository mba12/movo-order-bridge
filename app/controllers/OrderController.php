<?php

use Illuminate\Support\Facades\Input;
use Movo\Shipping\ShippingDropdown;

class OrderController extends BaseController
{
    public function showForm()
    {
        $waves=Product::waves();
        $loops=Product::loops();
        $charities=Charity::getList();
        $unitPrice = $waves[0]->price;
        $shippingInfo = Shipping::getShippingMethodsAndPrices();
        $shippingDropdownData = ShippingDropdown::createData($shippingInfo);
        $sizeInfo = $waves;
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
            'stateTaxMethods' => $stateTaxMethods,
            'after3pm' => strtotime("03:00 pm") - time() < 0,
            'loops'=>$loops,
            'charities'=>$charities,
            'waves'=>$waves
        ]);
    }

    public function buy()
    {
        $processor=new Movo\Orders\ProcessOrder();
        return $processor->process();
    }
}
