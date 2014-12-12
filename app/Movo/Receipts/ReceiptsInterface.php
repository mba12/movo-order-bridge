<?php namespace Movo\Receipts;

use stdClass;

interface ReceiptsInterface {
     public function send(array $data);
}

class Item extends stdClass
{
     public $description;
     public $sku;
     public $quantity;
     public $price;

     public function  __construct($description, $sku, $quantity, $price)
     {
          $this->description = $description;
          $this->sku = $sku;
          $this->quantity = $quantity;
          $this->price = $price;
     }
}