<?php namespace Movo\Receipts;

use stdClass;

interface ReceiptsInterface {
     public function send(array $data);
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