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
        $data['address4']=$data["shipping-city"] . ", " . $data["shipping-state"] . " " . $data["shipping-zip"];
        $data['quantity']=$data["quantity"];

        //TODO: fix displayed price in email  ???

        $data['items']=(new Order)->combineAndCountItems($data['items']);
        $emailData = $this->createEmailData($data);

        Mail::send('emails.receipt', array('data' => $emailData), function ($message) use ($data) {
            $message->to($data["email"], $data["billing-first-name"] . ' ' . $data["billing-last-name"])->subject('Movo Order Confirmation')->from("orders@getmovo.com");
        });
        if(count(Mail::failures()) > 0){
            throw new OrderException("There was a problem with mailing a receipt. Please try again.");
        }
    }


    // TODO: This can likely be combined with the method above instead of having two functions
    public function sendOffline(array $data)
    {
        $data['name']=$data["shipping-first-name"]." ".$data["shipping-last-name"];
        $data['address1']=$data["shipping-address"];
        $data['address2']=(isset($data['shipping-address2']) && strlen($data['shipping-address2']) > 0)?$data['shipping-address2']:'';
        $data['address3']=(isset($data['shipping-address3']) && strlen($data['shipping-address3']) > 0)?$data['shipping-address3']:'';
        $data['address4']=$data["shipping-city"] . ", " . $data["shipping-state"] . " " . $data["shipping-zip"];
        $data['quantity']=$data["quantity"];

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

