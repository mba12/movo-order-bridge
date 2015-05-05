<?php

namespace Movo\Receipts;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Movo\Errors\OrderException;
use Movo\Helpers\Format;
use Order;

class MailgunSendVerificationRequest extends Verification implements VerifyInterface
{
    public function send(array $data)
    {
        // $emailData = $this->createEmailData($data);

        $data['link'] = 'https://' . $data['env'] . 'verify/user-confirm?action=verify&tracking=' . $data['key'] . '&id=' . $data['id'];

        Mail::send('emails.sendverification', array('data' => $data), function ($message) use ($data) {
            $message->to($data['email'], $data['fullName'])->subject('Movo Email Verification')->from("no-reply@getmovo.com");
        });
        if(count(Mail::failures()) > 0){
            throw new OrderException("There was a problem with mailing a receipt. Please try again.");
        }
    }
}

