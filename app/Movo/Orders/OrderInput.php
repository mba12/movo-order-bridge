<?php
/**
 * Created by IntelliJ IDEA.
 * User: Alex
 * Date: 12/1/2014
 * Time: 10:16 AM
 */

namespace Movo\Orders;


use Illuminate\Support\Facades\Input;
 use GuzzleHttp;
class OrderInput
{

    public static function convertInputToData($data)
    {
        $data['quantity'] = Input::get("quantity");
        $data['charity'] = Input::get("charity");
        $data['shipping-type'] = Input::get("shipping-type");
        $data['shipping-first-name'] = Input::get("shipping-first-name");
        $data['shipping-last-name'] = Input::get("shipping-last-name");
        $data['shipping-address'] = Input::get("shipping-address");
        $data['shipping-city'] = Input::get("shipping-city");
        $data['shipping-state'] = Input::get("shipping-state");
        $data['shipping-zip'] = Input::get("shipping-zip");
        $data['shipping-country'] = Input::get("shipping-country");
        $data['shipping-phone'] = Input::get("shipping-phone");

        $data['billing-first-name'] = Input::get("billing-first-name");
        $data['billing-last-name'] = Input::get("billing-last-name");
        $data['billing-address'] = Input::get("billing-address");
        $data['billing-city'] = Input::get("billing-city");
        $data['billing-state'] = Input::get("billing-state");
        $data['billing-zip'] = Input::get("billing-zip");
        $data['billing-country'] = Input::get("billing-country");
        $data['billing-phone'] = Input::get("billing-phone");
        $data['email'] = Input::get("email");
        $data['coupon'] = Input::has("code") ? Input::get("code") : "";
        $items=[];
        for ($i = 0; $i < Input::get("quantity"); $i++) {
            $items[]=[
                "sku"=>Input::get("unit" . ($i + 1)) ,
                "description"=>Input::get("unit" . ($i + 1)."Name"),
            ];
        }
        $loops=json_decode(Input::get("loops"));

        for ($i = 0; $i < sizeof($loops); $i++) {
            $item=$loops[$i];
            $items[]=[
                "sku"=>$item->sku ,
                "description"=>$item->name,
                "quantity"=>$item->quantity,
            ];
        }
        $data['items']= $items;

        return $data;
    }
}