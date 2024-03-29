<?php

namespace Movo\Billing;


use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Shipping;
use Stripe;
use Stripe_Charge;
use Stripe_Transfer;

class StripeBilling implements BillingInterface
{
    public function __construct()
    {
        Stripe::setApiKey(Config::get("services.stripe.secret"));
    }

    public function charge(array $data)
    {
        try {
            $amount = StripeBilling::convertAmountToCents($data['amount']);
            $result = Stripe_Charge::create([
                'amount' => $amount,
                'currency' => 'usd',
                'description' =>  $data['email'],
                'card' => $data['token'],
                'metadata'=>$data['metadata']
            ]);
            return $result;
        } catch (\Stripe_InvalidRequestError $e) {
            return null;

        } catch (\Stripe_CardError $e) {
            //card was declined
            return null;
        }
    }

    public static function convertAmountToCents($amount){
        return  round($amount*100);
    }

}