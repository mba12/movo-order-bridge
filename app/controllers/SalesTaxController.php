<?php

use Httpful\Request;

class SalesTaxController extends \BaseController
{

    public function getSalesTax($zipcode, $state)
    {

        $salesTax = App::make('Movo\SalesTax\SalesTaxInterface');
        $rate = $salesTax->getRate($zipcode, $state);

        if (!isset($rate)) {
            return Response::json(array('error' => 'There is no match for zip code '.$zipcode . " in ".$state));
        }

        return Response::json(array('rate' => $rate));


    }

}