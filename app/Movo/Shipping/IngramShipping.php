<?php namespace Movo\Shipping;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Movo\Errors\OrderException;
use SoapBox\Formatter\Formatter;
use GuzzleHttp;
use GuzzleHttp\Client;

class IngramShipping implements ShippingInterface
{
    public static function retryFailedOrders()
    {
        //TODO retry Ingram SOAP and mark order as complete
        Log::info("attempting to retry orders");
    }

    public static function encryptXML($xml){
        $fp=fopen(base_path()."/cert/messagehub_TEST.cer","r");
        $pub_key=fread($fp,8192);
        fclose($fp);
        openssl_public_encrypt($xml,$crypttext, $pub_key );
        return(base64_encode($crypttext));
    }

    public static function generateTestOrder()
    {

        $data['quantity'] = 1;
        $data['shipping-type'] = 1;
        $data['shipping-code'] = "FXSP";
        $data['shipping-first-name'] = "Test";
        $data['shipping-last-name'] = "User";
        $data['shipping-address'] = "123 Oak";
        $data['shipping-city'] = "Anytown";
        $data['shipping-state'] = "NY";
        $data['shipping-zip'] = "10007";
        $data['shipping-country'] = "US";
        $data['shipping-phone'] = "222-555-5555";

        $data['billing-first-name'] = "Test";
        $data['billing-last-name'] = "User";
        $data['billing-address'] = "123 Oak";
        $data['billing-city'] = "Anytown";
        $data['billing-state'] = "NY";
        $data['billing-zip'] = "10007";
        $data['billing-country'] = "US";
        $data['billing-phone'] =  "222-555-5555";
        $data['email'] =  "info@getmovo.com";
        $data['coupon'] =  "";
        $data['result'] =  [
            "id"=>"test_stripe_id"
        ];
        $items=[];
        for ($i = 0; $i < 1; $i++) {
            $items[]=[
                "sku"=>"857458005008" ,
                "description"=>"Extra small (5.7\" -- Youth / Young Adult)",
            ];
        }
        $data['items']= $items;
        $xml = (new IngramShipping)->generateXMLFromData($data);
        return $xml;
    }

    public function ship(array $data)
    {

        $xml = $this->generateXMLFromData($data);
        $this->sendToFulfillment($xml);

    }

    public function convertToXML(array $data)
    {
        $formatter = Formatter::make($data, Formatter::ARR);
        $xml = $formatter->toXml();
        return $xml;
    }



    private function sendToFulfillment($xml)
    {


      /* $fp=fopen(base_path()."/cert/messagehub_TEST.cer","r");
        $pub_key=fread($fp,8192);
        fclose($fp);
        $plaintext = "String to encrypt";
        openssl_public_encrypt($plaintext,$crypttext, $pub_key );

        $client = new GuzzleHttp\Client();
        $response = $client->post('http://messagehub-dev.brightpoint.com:9135/HttpPost', [
            'body' => [
                'data' => $crypttext
            ]
        ]);*/

    }

    /**
     * @param $xml
     * @return mixed
     */
    private function replaceItemNodeNames($xml)
    {
        $xml = str_replace("<xml>", "", $xml);
        $xml = str_replace("</xml>", "", $xml);
        $xml = str_replace("<item>", "<line-item>", $xml);
        $xml = str_replace("</item>", "</line-item>", $xml);
        return $xml;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function generateXMLFromData(array $data)
    {
        $date = new \DateTime;
        $array = [
            'message' => [
                'message-header' => [
                    'message-id' => '12345',
                    'transaction-name' => 'sales-order-submission',
                    'partner-name' => Config::get('services.ingram.partner-name'),
                    'source-url' => Config::get('services.ingram.source-url'),
                    'create-timestamp' => $date->getTimestamp(),
                    'response-request' => '1',
                ],
                'sales-order-submission' => [
                    'header' => [
                        'customer-id' => Config::get('services.ingram.customer-id'),
                        'business-name' => 'movo',
                        'carrier-name' => $data['shipping-code'],
                        'shipment-information' => [
                            'ship-first-name' => $data['shipping-first-name'],
                            'ship-last-name' => $data['shipping-last-name'],
                            'ship-address1' => $data['shipping-address'],
                            'ship-address2' => '',
                            'ship-address3' => '',
                            'ship-city' => $data['shipping-city'],
                            'ship-state' => $data['shipping-state'],
                            'ship-post-code' => $data['shipping-zip'],
                            'ship-country-code' => $data['shipping-country'],
                            'ship-phone1' => $data['shipping-phone'],
                            'ship-email' => $data['email'],
                            'ship-via' => $data['shipping-code'],
                            'ship-request-date' => $date->getTimestamp(),
                            'ship-no-later' => '',
                            'no-ship-before' => '',
                        ],
                        'purchase-order-information' => [
                            'purchase-order-number' => '',
                            'comments' => '',
                        ],
                        'order-header' => [
                            'customer-order-number' => $data['result']['id'],
                            'customer-order-date' => $date->getTimestamp(),
                            'order-type' => 'WEB-SALES',
                        ]
                    ],
                    'detail' => $data['items'],
                ]
            ],
        ];
        $xml = $this->convertToXML($array);
        $xml = $this->replaceItemNodeNames($xml);
        return $xml;
    }


}