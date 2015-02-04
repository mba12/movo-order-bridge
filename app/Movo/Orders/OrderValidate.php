<?php
/**
 * Created by IntelliJ IDEA.
 * User: Alex
 * Date: 12/17/2014
 * Time: 3:51 PM
 */

namespace Movo\Orders;


use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class OrderValidate
{
    public static function validate($data)
    {

        $validation = Validator::make(
            $data,
            array(
                'shipping-first-name' => array('required'),
                'shipping-last-name' => array('required'),
                'shipping-address' => array('required'),
                'shipping-city' => array('required'),
                'shipping-zip' => array('required'),
                'shipping-state' => array('required'),
                'shipping-country' => array('required'),
                'shipping-phone' => array('required'),
                'billing-first-name' => array('required'),
                'billing-last-name' => array('required'),
                'billing-address' => array('required'),
                'billing-city' => array('required'),
                'billing-zip' => array('required'),
                'billing-state' => array('required'),
                'billing-country' => array('required'),
                'billing-phone' => array('required'),
                'quantity' => array('required', 'integer'),
                'email' => array('required', 'email'),
                'shipping-type' => array('required', 'integer'),

            )
        );
        $itemCount = 0;
        for ($i = 0; $i < sizeof($data['items']); $i++) {
            if (!isset($data['items'][$i]['quantity'])) {
                $itemCount++;
            } else {
                $itemCount += $data['items'][$i]['quantity'];
            }
        }
        if($itemCount == 0) {
            return false;
        }
        if ($itemCount != $data['quantity']) {
            return false;
        }
        for ($i = 0; $i < sizeof($data['items']); $i++) {
            if (!isset($data['items'][$i])) {
                 return false;
            }
            if (!isset($data['items'][$i]['sku'])) {
                return false;
            }
            if (!isset($data['items'][$i]['description'])) {
                return false;
            }
        }
        return !$validation->fails();
    }
}