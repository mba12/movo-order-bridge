<?php

namespace Movo\Receipts;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Movo\Errors\OrderException;
use Movo\Helpers\Format;
use Order;

class MailgunReceipts extends Receipt implements ReceiptsInterface
{
    public function send(array $data)
    {
        $data['name']=$data["shipping-first-name"]." ".$data["shipping-last-name"];
        $data['address1']=$data["shipping-address"];
        $data['address2']=$data["shipping-address2"];
        $data['address3']=$data["shipping-address3"];
        $data['address4']=$data["shipping-city"].", ".$data["shipping-state"]." ".$data["shipping-zip"];
        $data['quantity']=Input::get("quantity");
        /*$data['items'] = [];

        for ($i = 0; $i < $data['quantity']; $i++) {
            $data['items'][]=[
                "description"=>Input::get("unit" . ($i + 1)."Name"),
                "sku"=>Input::get("unit" . ($i + 1)),
                "quantity"=>1,
                "price"=>Format::FormatUSD($data['total-unit-prices'])
                //TODO fix displayed price in email
            ];
        }
        $data['items']=(new Order)->combineAndCountItems($data['items']);*/
        $data['items']=(new Order)->combineAndCountItems($data['items']);
        $emailData = $this->createEmailData($data);

        Mail::send('emails.receipt', array('data' => $emailData), function ($message) use ($data) {
            $message->to($data["email"], $data["billing-first-name"] . ' ' . $data["billing-last-name"])->subject('Movo Order Confirmation')->from("orders@getmovo.com");
        });
        if(count(Mail::failures()) > 0){
            throw new OrderException("There was a problem with mailing a receipt. Please try again.");
        }
    }


    public function sendOffline(array $data)
    {
        $data['name']=$data["shipping-first-name"]." ".$data["shipping-last-name"];
        $data['address1']=$data["shipping-address"];
        $data['address2']=$data["shipping-city"].", ".$data["shipping-state"]." ".$data["shipping-zip"];

        /*$data['items'] = [];

        for ($i = 0; $i < $data['quantity']; $i++) {
            $data['items'][]=[
                "description"=>Input::get("unit" . ($i + 1)."Name"),
                "sku"=>Input::get("unit" . ($i + 1)),
                "quantity"=>1,
                "price"=>Format::FormatUSD($data['total-unit-prices'])
                //TODO fix displayed price in email
            ];
        }
        $data['items']=(new Order)->combineAndCountItems($data['items']);*/
        $data['items']=(new Order)->combineAndCountItems($data['items']);
        $emailData = $this->createEmailData($data);

        Mail::send('emails.receipt', array('data' => $emailData), function ($message) use ($data) {
            $message->to($data["email"], $data["billing-first-name"] . ' ' . $data["billing-last-name"])->subject('Movo Order Confirmation')->from("orders@getmovo.com");
        });
        if(count(Mail::failures()) > 0){
            throw new OrderException("There was a problem with mailing a receipt. Please try again.");
        }
    }


}

