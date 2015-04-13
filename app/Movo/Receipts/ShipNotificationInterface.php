<?php namespace Movo\Receipts;

use stdClass;

interface ShipNotificationInterface {
     public function send(array $data);
}

