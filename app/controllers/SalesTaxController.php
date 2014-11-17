<?php

use Httpful\Request;

class SalesTaxController extends \BaseController
{

    public function getSalesTax($zipcode, $state)
    {

        $salesTax = App::make('Movo\SalesTax\SalesTaxInterface');
        return $salesTax->getRate($zipcode,$state);


    }

}