<?php

use Movo\SalesTax\SalesTax;

class Order extends \Eloquent
{
    protected $fillable = [
        'amount',
        'quantity',
        'sizes',
        'shipping_type',
        'shipping_first_name',
        'shipping_last_name',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_zip',
        'shipping_country',
        'shipping_phone',

        'billing_first_name',
        'billing_last_name',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_zip',
        'billing_country',
        'billing_phone',
        'email',

        'stripe_charge_id',
        'coupon',
        'ingram_order_id',
        'status',
        'tracking_code',
        'error_flag',
    ];

    public function saveOrder($amount, $chargeID)
    {
        $this->amount = $amount;
        $this->quantity = Input::get("quantity");
        $this->shipping_type = Input::get("shipping-type");
        $strSizes = "";
        for ($i = 0; $i < Input::get("quantity"); $i++) {
            if ($i > 0) {
                $strSizes .= "|";
            }
            $strSizes .= Input::get("unit" . ($i + 1));

        }
        $this->sizes = $strSizes;

        $this->shipping_first_name = Input::get("shipping-first-name");
        $this->shipping_last_name = Input::get("shipping-last-name");
        $this->shipping_address = Input::get("shipping-address");
        $this->shipping_city = Input::get("shipping-city");
        $this->shipping_state = Input::get("shipping-state");
        $this->shipping_zip = Input::get("shipping-zip");
        $this->shipping_country = Input::get("shipping-country");
        $this->shipping_phone = Input::get("shipping-phone");

        $this->billing_first_name = Input::get("billing-first-name");
        $this->billing_last_name = Input::get("billing-last-name");
        $this->billing_address = Input::get("billing-address");
        $this->billing_city = Input::get("billing-city");
        $this->billing_state = Input::get("billing-state");
        $this->billing_zip = Input::get("billing-zip");
        $this->billing_country = Input::get("billing-country");
        $this->billing_phone = Input::get("billing-phone");

        $this->email = Input::get("email");
        $this->stripe_charge_id = $chargeID;
        $this->ingram_order_id = "";
        $this->status = 1;
        $this->tracking_code = "";
        $this->error_flag = "";
        $this->coupon = Input::has("code")?Input::get("code"):"";


        $this->save();
    }

    public static function calculateTotal($data)
    {
        $quantity = $data['quantity'];
        $discount = $data['discount'];
        $subtotal = $data['unit-price'] * $quantity - $discount;
        $shippingRate=$data['shipping-rate'];
        $salesTax=new SalesTax();
        $totalSalesTax=$salesTax->calculateTotalTax($subtotal,$shippingRate,$data['tax-rate'],$data['state']);
        $amount = $subtotal+$totalSalesTax+$shippingRate;
        return $amount;
    }
}
