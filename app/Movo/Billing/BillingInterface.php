<?php namespace Movo\Billing;

interface BillingInterface {
     public function charge(array $data);
}