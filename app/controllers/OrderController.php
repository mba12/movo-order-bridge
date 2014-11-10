<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;


class OrderController extends BaseController
{
    public function showForm()
    {
        $pusher=App::make("Pusher");
        $pusher->trigger("orderChannel", "userStartedOrder",[]);
        $unitPrice=$this->getUnitPrice();
        $shippingInfo=Shipping::all();
        return View::make('order-form', [
            'shippingInfo'=> $shippingInfo,
            'unitPrice'=> $unitPrice,

        ]);
    }

    public function buy()
    {
         $unitPrice=$this->getUnitPrice();
        $shippingMethod=$this->getShippingRate();


        $billing = App::make('Movo\Billing\BillingInterface');
        $shipping = App::make('Movo\Shipping\ShippingInterface');
        $receipt = App::make('Movo\Receipts\ReceiptsInterface');
        //dd(Input::all());
        $result = $billing->charge([
            'token' => Input::get("token"),
            'unit-price'=>$unitPrice,
            'shipping-rate'=>$shippingMethod->rate,
            'shipping-type'=>$shippingMethod->type,
        ]);

        if ($result) {
            $shipping->ship([
                'result' => $result,
                'unit-price'=>$unitPrice,
                'shipping-rate'=>$shippingMethod->rate,
                'shipping-type'=>$shippingMethod->type,
            ]);
            $this->saveOrder($result);
            $receipt->send([
                "result" => $result,
                'unit-price'=>$unitPrice,
                'shipping-rate'=>$shippingMethod->rate,
                'shipping-type'=>$shippingMethod->type,
            ]);
            return Response::json(array('status' => '200',  'message' =>  'Your order has been submitted!'));

        } else {
            return Response::json(array('status' => '400',  'message' =>  'There was an error submitting your order'));

        }
    }

    private function saveOrder($result)
    {
        $order = new Order();
        $order->saveOrder($result['amount'], $result['id']);
    }

    private function getUnitPrice()
    {

        $product= DB::table('products')->first();
        return $product->price;
    }

    private function getShippingRate()
    {
        $shipping=Shipping::find(Input::get("shipping-type"));
        return $shipping;

    }
}
