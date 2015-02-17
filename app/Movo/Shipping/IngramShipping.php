<?php namespace Movo\Shipping;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Movo\Errors\OrderException;
use Order;
use Shipping;
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

    public static function encryptXML($xml)
    {
        $fp = fopen(base_path() . "/cert/messagehub_TEST.cer", "r");
        $pub_key = fread($fp, 8192);
        fclose($fp);
        openssl_public_encrypt($xml, $crypttext, $pub_key);
        return ($crypttext);
    }

    public static function generateTestOrder()
    {
        $order = Order::orderByRaw("RAND()")->with("items")->first();
        $data['shipping-code'] = Shipping::find($order->shipping_type)->scac_code;
        $data['shipping-first-name'] = $order->shipping_first_name;
        $data['shipping-last-name'] = $order->shipping_last_name;
        $data['shipping-address'] = $order->shipping_address;
        $data['shipping-city'] = $order->shipping_city;
        $data['shipping-state'] = $order->shipping_state;
        $data['shipping-zip'] = $order->shipping_zip;
        $data['shipping-country'] = $order->shipping_country;
        $data['shipping-phone'] = $order->shipping_phone;;

        $data['billing-first-name'] = $order->billing_first_name;
        $data['billing-last-name'] = $order->billing_last_name;
        $data['billing-address'] = $order->billing_address;
        $data['billing-city'] = $order->billing_city;
        $data['billing-state'] = $order->billing_state;
        $data['billing-zip'] = $order->billing_zip;
        $data['billing-country'] = $order->billing_country;
        $data['billing-phone'] = $order->billing_phone;
        $data['email'] = $order->email;
        $data['coupon'] = "";
        $data['result'] = [
            "id" => $order->stripe_charge_id
        ];

        $items = [];
        foreach ($order->items as $item) {
            $items[] = [
                "item-code" => $item->sku,
                "product-name" => 'CDATA[[' . $item->description . ']]',
                "quantity" => $item->quantity,
                "line-status" => "IN STOCK",
                "unit-of-measure" => "EA",
                'sid' => '',
                'esn' => '',
                'min' => '',
                'mdn' => '',
                'irdb' => '',
                'imei' => '',
                'market-id' => '',
                'base-price' => '',
                'line-discount' => '',
                'line-tax1' => '',
                'line-tax2' => '',
                'line-tax3' => '',
            ];
        }

        $data['items'] = $items;
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
        $xml = str_replace("'xml>", "", $xml);
        $xml = str_replace("'/xml>", "", $xml);
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
                    'partner-password' => '',
                    'source-url' => Config::get('services.ingram.source-url'),
                    'create-timestamp' => $date->getTimestamp(),
                    'response-request' => '1',
                ],
                'sales-order-submission' => [
                    'header' => [
                        'customer-id' => Config::get('services.ingram.customer-id'),
                        'business-name' => 'movo',
                        'carrier-name' => $data['shipping-code'],
                        'customer-information' => [
                            'customer-first-name' => $data['billing-first-name'],
                            'customer-last-name' => $data['billing-last-name'],
                            'customer-middle-initial' => '',
                            'customer-address1' => $data['billing-address'],
                            'customer-address2' => '',
                            'customer-address3' => '',
                            'customer-city' => $data['billing-city'],
                            'customer-state' => $data['billing-state'],
                            'customer-post-code' => $data['billing-zip'],
                            'customer-country-code' => $data['billing-country'],
                            'customer-phone1' => $data['billing-phone'],
                            'customer-phone2' => '',
                            'customer-fax' => '',
                            'customer-email' => $data['email'],
                        ],
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
                            'ship-phone2' => '',
                            'ship-fax' => '',
                            'ship-email' => $data['email'],
                            'ship-via' => $data['shipping-code'],
                            'ship-request-date' => $date->getTimestamp(),
                            'ship-request-from' => 'Indianapolis',
                            'ship-request-warehouse' => 'MVO1',
                        ],
                        'purchase-order-information' => [
                            'purchase-order-number' => '325',
                            'purchase-order-amount' => '',
                            'currency-code' => 'USD',
                            'account-description' => '',
                            'comments' => '',
                        ],
                        'credit-card-information' => [
                            'credit-card-number' => '',
                            'credit-card-expiration-date' => '',
                            'credit-card-identification' => '',
                            'credit-card-number' => '',
                            'credit-card-expiration-date' => '',
                            'credit-card-identification' => '',
                            'global-card-classification-code' => '',
                            'card-holder-name' => '',
                            'card-holder-address1' => '',
                            'card-holder-address2' => '',
                            'card-holder-city' => '',
                            'card-holder-state' => '',
                            'card-holder-post-code' => '',
                            'card-holder-country-code' => '',
                            'authorized-amount' => '',
                            'billing-sequence-number' => '',
                            'billing-authorization-response' => '',
                            'billing-address-match' => '',
                            'billing-zip-match' => '',
                            'avs-hold' => '',
                            'merchant-name' => '',
                        ],
                        'order-header' => [
                            'customer-order-number' => $data['result']['id'],
                            'customer-order-date' => $date->getTimestamp(),
                            'order-type' => 'WEB-SALES',
                            'order-sub-total' => '',
                            'order-discount' => '',
                            'order-tax1' => '',
                            'order-tax2' => '',
                            'order-tax3' => '',
                            'order-shipment-charge' => '',
                            'order-total-net' => '',
                            'order-status' => 'SUBMITTED',
                            'order-type' => 'WEB SALES',
                            'gift-flag' => '',
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