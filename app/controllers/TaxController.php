<?php

use Httpful\Request;

class TaxController extends \BaseController
{

    public function getSalesTax($zipcode)
    {
        $url = "http://api.zip-tax.com/request/v20?key=T92W84L&postalcode=" . $zipcode . "&state=CA&format=JSON";
        $jsonObject = file_get_contents($url);
        $jsonObject=json_decode($jsonObject, true);

        return $jsonObject['results'][0]['taxSales'];

        /*$response = Request::get($url)
            ->withXTrivialHeader('Just as a demo')
            ->body('<xml><name>Value</name></xml>')
            ->sendsXml()
            ->expects("JSON")
            ->send();

        //return $zipcode;
        //$result=json_decode($response);
        return $response->body->{'results'};*/
    }

}