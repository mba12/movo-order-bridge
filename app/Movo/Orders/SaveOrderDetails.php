<?php
/**
 * Created by IntelliJ IDEA.
 * User: Alex
 * Date: 11/23/2014
 * Time: 12:22 PM
 */

namespace Movo\Orders;


use Illuminate\Support\Facades\Input;
use Order;

class SaveOrderDetails
{
    public static function save(Order $order, $amount, $chargeID)
    {
        $order->amount = $amount;
        $order->quantity = Input::get("quantity");
        $order->shipping_type = Input::get("shipping-type");
        $strSizes = "";
        for ($i = 0; $i < Input::get("quantity"); $i++) {
            if ($i > 0) {
                $strSizes .= "|";
            }
            $strSizes .= Input::get("unit" . ($i + 1));

        }
        $order->sizes = $strSizes;

        $order->shipping_first_name = Input::get("shipping-first-name");
        $order->shipping_last_name = Input::get("shipping-last-name");
        $order->shipping_address = Input::get("shipping-address");
        $order->shipping_city = Input::get("shipping-city");
        $order->shipping_state = Input::get("shipping-state");
        $order->shipping_zip = Input::get("shipping-zip");
        $order->shipping_country = Input::get("shipping-country");
        $order->shipping_phone = Input::get("shipping-phone");

        $order->billing_first_name = Input::get("billing-first-name");
        $order->billing_last_name = Input::get("billing-last-name");
        $order->billing_address = Input::get("billing-address");
        $order->billing_city = Input::get("billing-city");
        $order->billing_state = Input::get("billing-state");
        $order->billing_zip = Input::get("billing-zip");
        $order->billing_country = Input::get("billing-country");
        $order->billing_phone = Input::get("billing-phone");

        $order->email = Input::get("email");
        $order->stripe_charge_id = $chargeID;
        $order->ingram_order_id = "";
        $order->status = 1;
        $order->tracking_code = "";
        $order->error_flag = "";
        $order->coupon = Input::has("code") ? Input::get("code") : "";


        $order->save();
    }

}