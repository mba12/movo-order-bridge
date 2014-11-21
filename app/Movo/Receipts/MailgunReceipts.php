<?php

namespace Movo\Receipts;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Movo\Helpers\Format;

class MailgunReceipts extends Receipt implements ReceiptsInterface
{
    public function send(array $data)
    {
        $data['quantity']=Input::get("quantity");
        $data['shippingAddress']=Input::get("shipping-address"). " ". Input::get("shipping-city").", ".Input::get("shipping-state")." ".Input::get("shipping-zip");
        $data['quantity']=Input::get("quantity");
        $data['items'] = [];
        for ($i = 0; $i < $data['quantity']; $i++) {
            array_push($data['items'], new Item(Input::get("unit" . ($i + 1)."Name"), 1, Format::FormatUSD($data['unit-price'])));
        }
        $emailData = $this->createEmailData($data);
        Mail::send('emails.receipt', array('data' => $emailData), function ($message) {
            $message->to(Input::get("email"), Input::get("billing-first-name") . ' ' . Input::get("billing-last-name"))->subject('Movo Order Confirmation')->from("orders@getmovo.com");
        });
    }


}

