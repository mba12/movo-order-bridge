<?php

namespace Movo\Receipts;


use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Movo\Helpers\Format;
use stdClass;

class MailgunReceipts implements ReceiptsInterface
{

    public function send(array $data)
    {
        $emailData['items'] = [];
        for ($i = 0; $i < Input::get("quantity"); $i++) {
            array_push($emailData['items'], new Item(Input::get("unit" . ($i + 1)), 1, Format::FormatUSD($data['unit-price'])));
        }
        $emailData['total'] = Format::FormatStripeMoney($data['result']['amount']);
        $emailData['shipping-rate'] = Format::FormatUSD($data['shipping-rate']);
        $emailData['shipping-type'] = $data['shipping-type'];

        Mail::send('emails.receipt', array('data' => $emailData), function ($message) {
            $message->to(Input::get("email"), Input::get("billing-first-name") . ' ' . Input::get("billing-last-name"))->subject('Your Movo Order!')->from("orders@orders.getmovo.com");
        });
    }
}

class Item extends stdClass
{
    public $title;
    public $quantity;
    public $price;

    public function  __construct($title, $quantity, $price)
    {
        $this->title = $title;
        $this->quantity = $quantity;
        $this->price = $price;
    }
}