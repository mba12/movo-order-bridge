<?php
/**
 * Created by IntelliJ IDEA.
 * User: Alex
 * Date: 11/16/2014
 * Time: 5:45 PM
 */

namespace Movo\SalesTax;


use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class ZipTax implements SalesTaxInterface
{

    public function getRate($zipcode, $state)
    {

        if(Cache::has("zip-code-".$zipcode.$state)){
            return Cache::get("zip-code-".$zipcode.$state);
        }

        $url = "http://api.zip-tax.com/request/v20?key=" . Config::get("services.zip-tax.key") . "&postalcode=" . $zipcode . "&state=" . $state . "&format=JSON";
        $jsonObject = file_get_contents($url);
        $jsonObject = json_decode($jsonObject, true);
        if (sizeof($jsonObject['results'])==0) {
            //state and zip code are not valid
            return null;
        }

        //cache results
        Cache::put("zip-code-".$zipcode.$state, $jsonObject['results'][0]['taxSales'], 1440);

        return $jsonObject['results'][0]['taxSales'];
    }
}