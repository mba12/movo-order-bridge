<?php

namespace Movo\Billing;


use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Shipping;
use Stripe;
use Stripe_Charge;

class StripeBilling implements BillingInterface
{
    public function __construct()
    {
        Stripe::setApiKey(Config::get("services.stripe.secret"));
    }

    public function charge(array $data)
    {
        try {
            $quantity = Input::get("quantity");
            $discount = $data['couponInstance'] ? $data['couponInstance']->calculateCouponDiscount($data['unit-price'], Input::get("quantity")) : 0;
            $amount = $data['unit-price'] * $quantity - $discount;
            $amount += $data['shipping-rate'];
            $amount *= 100;
            $result = Stripe_Charge::create([
                'amount' => $amount,
                'currency' => 'usd',
                'description' => Input::get("email"),
                'card' => $data['token']
            ]);

            return $result;
        } catch (\Stripe_InvalidRequestError $e) {
            //card was declined
            return null;

        } catch (\Stripe_CardError $e) {
            //card was declined
            return null;
        }
    }


}