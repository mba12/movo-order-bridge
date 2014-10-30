<?php

namespace Movo\Billing;


use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Order;
use Product;
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
            $quantity=3;
            $amount=$this->calculateTotal($quantity);
            $result = Stripe_Charge::create([
                'amount' => $amount,
                'currency' => 'usd',
                'description' => $data['email'],
                'card' => $data['token']
            ]);

            $order = new Order();
            $order->amount = $amount;
            $order->quantity = Input::get("quantity");
            $order->first_name = Input::get("first_name");
            $order->last_name = Input::get("last_name");
            $order->shipping_address_1 = Input::get("shipping_address_1");
            $order->shipping_address_2 = Input::get("shipping_address_2");
            $order->shipping_city = Input::get("shipping_city");
            $order->shipping_state = Input::get("shipping_state");
            $order->shipping_zip = Input::get("shipping_zip");
            $order->shipping_country = Input::get("shipping_country");
            $order->phone = Input::get("phone");
            $order->email = Input::get("email");
            $order->shipping_service = "";
            $order->stripe_charge_id = $result['id'];
            $order->ingram_order_id = "";
            $order->status = 1;
            $order->tracking_code = "";
            $order->error_flag = "";
            $order->save();
            return 1;
        } catch (\Stripe_InvalidRequestError $e) {
            //card was declined
            return 2;

        }catch (\Stripe_CardError $e) {
            //card was declined
            return 3;
        }
    }

    private function calculateTotal($quantity)
    {
        $product= DB::table('products')->where('quantity',">=", $quantity)->first();
        dd($product->price*$quantity);
        return $product->price;
    }
}