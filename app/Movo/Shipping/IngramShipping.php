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

    public function ship(array $data)
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
                    'detail' => $this->createOrderList()
                ]
            ],
        ];
        $xml = $this->convertToXML($array);
        $xml = $this->replaceItemNodeNames($xml);
        $this->sendToFulfillment($xml);

    }

    public function convertToXML(array $data)
    {
        $formatter = Formatter::make($data, Formatter::ARR);
        $xml = $formatter->toXml();
        return $xml;
    }

    private function createOrderList()
    {
        $items = [];
        for ($i = 0; $i < Input::get("quantity"); $i++) {
            array_push($items,
                [
                    'line-no' => '1',
                    'item-code' => Input::get("unit" . ($i + 1)),
                    'quantity' => '1.0',
                    'unit-of-measure' => 'EA',
                ]);
        }
        return $items;
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


}