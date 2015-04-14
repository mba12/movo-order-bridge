<?php

namespace Movo\Receipts;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Movo\Errors\OrderException;
use Movo\Helpers\Format;
use Order;

class MailgunShipNotification extends Receipt implements ShipNotificationInterface
{
    public function send(array $data)
    {
        // $emailData = $this->createEmailData($data);
        $data['link'] = 'https://www.fedex.com/apps/fedextrack/?action=track&trackingnumber=' . $data['tracking_code'] . '&cntry_code=us';

        Mail::send('emails.shipnotification', array('data' => $data), function ($message) use ($data) {
            $message->to($data['ship-email'], $data['name'])->subject('Movo Shipping Notification')->from("orders@getmovo.com");
        });
        if(count(Mail::failures()) > 0){
            throw new OrderException("There was a problem with mailing a receipt. Please try again.");
        }
    }
}

