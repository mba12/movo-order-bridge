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

        /*$orderStatus=1;
        if($data['quantity']>3){
            $orderStatus=2;
        }*/

        $order->amount = round($data['amount']*100);
        $order->tax = $data['tax'];
        $order->discount = $data['discount'];
        $order->unit_price = $data['total-unit-prices'];
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

        $order->partner_id = isset($data['partner_id'])?$data['partner_id']:"";
        $order->partner_order_id = isset($data['partner_order_id'])?$data['partner_order_id']:"";

        if (isset($data['partner_id']) && strcasecmp($data['partner_id'] , "RETAIL") === 0 ) {
            $order->ship_to_code = $data['ship-to-code'];
            $order->ship_no_later = $data['ship-no-later'];
            $order->dock_date = $data['dock-date'];
        }

        $order->save();
        $combinedItems = $order->combineAndCountItems($data['items']);

        foreach ($combinedItems as $item) {
           $order->items()->save(self::saveOrderItemPercentages($item, $data));
        }

        return $order;
    }

    /**
     * @param $item
     * @param $data
     * @return \Item
     */
    public static function saveOrderItemPercentages($item, $data)
    {

        $itemPercentageOfTotal = $item['price'] / $data['total-unit-prices'];
        $orderItem = new \Item(
            [

                "sku" => $item['sku'],
                "description" => $item['description'],
                "amount" => $item['price'] * $item['quantity'],
                "tax" => $data['tax'] * $itemPercentageOfTotal * $item['quantity'],
                "quantity" => $item['quantity'],
                "shipping" => $data ['shipping-rate']* $itemPercentageOfTotal * $item['quantity'],
                "discount" => $data['discount'] * $itemPercentageOfTotal * $item['quantity'],
            ]
        );
        return $orderItem;
    }
}