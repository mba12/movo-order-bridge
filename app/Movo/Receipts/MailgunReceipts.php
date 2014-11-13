<?php

namespace Movo\Receipts;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
class MailgunReceipts extends Receipt implements ReceiptsInterface
{
    public function send(array $data)
    {
       $emailData=$this->createEmailData($data);
        Mail::send('emails.receipt', array('data' => $emailData), function ($message) {
            $message->to(Input::get("email"), Input::get("billing-first-name") . ' ' . Input::get("billing-last-name"))->subject('Your Movo Order!')->from("orders@getmovo.com");
        });
    }


}

