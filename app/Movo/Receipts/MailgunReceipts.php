<?php

namespace Movo\Receipts;

use Illuminate\Support\Facades\Mail;
use stdClass;

class MailgunReceipts implements ReceiptsInterface
{

    public function send(array $result)
    {
        $data['items']=[
            new Item("widget 1", 4, "$10.00"),
            new Item("widget 2", 3,  "$10.00")
        ];
        $data['total']=$result['result']['amount'];

        Mail::send('emails.receipt', array('data' => $data), function($message)
        {
            $message->to('alex@jumpkick.pro', 'John Smith')->subject('Welcome!')->from("orders@getmovo.com");
        });
    }
}

class Item extends stdClass{
    public $title;
    public $quantity;
    public $price;
    public function  __construct($title,$quantity, $price) {
        $this->title = $title;
        $this->quantity = $quantity;
        $this->price = $price;
    }
}