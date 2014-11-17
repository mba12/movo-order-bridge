<?php
/**
 * Created by IntelliJ IDEA.
 * User: Alex
 * Date: 11/16/2014
 * Time: 5:45 PM
 */

namespace Movo\SalesTax;


use Illuminate\Support\Facades\Config;

class ZipTax implements SalesTaxInterface
{

    public function getRate($zipcode, $state)
    {
        $url = "http://api.zip-tax.com/request/v20?key=" . Config::get("services.zip-tax.key") . "&postalcode=" . $zipcode . "&state=" . $state . "&format=JSON";
        $jsonObject = file_get_contents($url);
        $jsonObject = json_decode($jsonObject, true);

        return $jsonObject['results'][0]['taxSales'];
    }
}