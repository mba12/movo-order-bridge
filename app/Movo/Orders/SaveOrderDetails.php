<?php
/**
 * Created by IntelliJ IDEA.
 * User: Alex
 * Date: 11/23/2014
 * Time: 12:22 PM
 */

namespace Movo\Orders;


use Illuminate\Support\Facades\Input;
use Movo\Errors\OrderException;
use Movo\Helpers\Format;
use Order;

class SaveOrderDetails
{
    public static function save(Order $order, $data)
    {

        $order->amount = $data['amount'];
        $order->tax = $data['tax'];
        $order->discount = $data['discount'];
        $order->unit_price = $data['unit-price'];
        $order->quantity = $data['quantity'];
        $order->shipping_type = $data['shipping-type'];
        $order->shipping_first_name = $data['shipping-first-name'];
        $order->shipping_last_name = $data['shipping-last-name'];
        $order->shipping_address = $data['shipping-address'];
        $order->shipping_city = $data['shipping-city'];
        $order->shipping_state = $data['shipping-state'];
        $order->shipping_zip = $data['shipping-zip'];
        $order->shipping_country = $data['shipping-country'];
        $order->shipping_phone = Format::ReducePhoneNumberToDigits($data['shipping-phone']);
        $order->billing_first_name = $data['billing-first-name'];
        $order->billing_last_name = $data['billing-last-name'];
        $order->billing_address = $data['billing-address'];
        $order->billing_city = $data['billing-city'];
        $order->billing_state = $data['billing-state'];
        $order->billing_zip = $data['billing-zip'];
        $order->billing_country = $data['billing-country'];
        $order->billing_phone = Format::ReducePhoneNumberToDigits($data['billing-phone']);
        $order->email = $data['email'];
        $order->stripe_charge_id = "";
        $order->ingram_order_id = "";
        $order->status = 1;
        $order->tracking_code = "";
        $order->error_flag = "";
        $order->coupon = $data['coupon'];
        $order->save();

        foreach($data['items'] as $item){
            $orderItem=new \Item(
                [
                    "sku"=>$item['sku'],
                    "description"=>$item['description'],
                ]
            );

            $order->items()->save($orderItem);
        }
        return $order;
    }

}