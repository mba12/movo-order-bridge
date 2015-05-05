<?php namespace Movo\Receipts;

use stdClass;

interface VerifyInterface {
     public function send(array $data);
}