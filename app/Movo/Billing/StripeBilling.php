<?php

namespace Movo\Billing;


use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
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
            $quantity=1;
            $amount=$this->calculateTotal($quantity);
            $result = Stripe_Charge::create([
                'amount' => $amount,
                'currency' => 'usd',
                'description' => $data['email'],
                'card' => $data['token']
            ]);

            return $result;
        } catch (\Stripe_InvalidRequestError $e) {
            //card was declined
            return null;

        }catch (\Stripe_CardError $e) {
            //card was declined
            return null;
        }
    }

    private function calculateTotal($quantity)
    {
        $product= DB::table('products')->where('quantity',"<=", $quantity)->orderBy("quantity", "DESC")->first();
        return $product->price*$quantity;
    }
}