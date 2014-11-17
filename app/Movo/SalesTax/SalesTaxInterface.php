<?php namespace Movo\SalesTax;

interface SalesTaxInterface {
     public function getRate($zipcode, $state);
}