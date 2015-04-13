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
        $data['quantity']=2;
        $data['name']='Michael'." ".'Ahern';
        $data['address1']='520 West 218th Street';
        $data['address2']='New York, NY 10034';

        /*$data['items'] = [];

        // Track your package example
        // https://www.fedex.com/apps/fedextrack/?action=track&trackingnumber=074347380360313&cntry_code=us

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
        $emailData['link'] = 'https://www.fedex.com/apps/fedextrack/?action=track&trackingnumber=074347380360313&cntry_code=us';

        Mail::send('emails.shipnotification', array('data' => $emailData), function ($message) {
            $message->to("michael@getmovo.com", "Michael" . ' ' . "Ahern")->subject('Movo Shipping Notification')->from("orders@getmovo.com");
        });
        if(count(Mail::failures()) > 0){
            throw new OrderException("There was a problem with mailing a receipt. Please try again.");
        }
    }
}

