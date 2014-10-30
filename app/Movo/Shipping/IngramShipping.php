<?php namespace Movo\Shipping;

use Illuminate\Support\Facades\Config;
use SoapBox\Formatter\Formatter;

class IngramShipping implements ShippingInterface
{
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
                        'carrier-name' => '2-day',
                        'shipment-information' => [
                            'ship-first-name' => 'Joe',
                            'ship-last-name' => 'Public',
                            'ship-address1' => '871 Main Street Drive',
                            'ship-address2' => 'Suite 200',
                            'ship-address3' => 'My Company Solutions',
                            'ship-city' => 'Anytown',
                            'ship-state' => 'NY',
                            'ship-post-code' => '97219',
                            'ship-country-code' => 'US',
                            'ship-phone1' => '555-555-5555',
                            'ship-email' => 'myemail@gmail.com',
                            'ship-via' => '2-day',
                            'ship-request-date' => $date->getTimestamp(),
                            'ship-no-later' => '',
                            'no-ship-before' => '',
                        ],
                        'purchase-order-information' => [
                            'purchase-order-number' => '',
                            'comments' => '',
                        ],
                        'order-header' => [
                            'customer-order-number' => 'SO82553',
                            'customer-order-date' => $date->getTimestamp(),
                            'order-type' => 'WEB-SALES',
                        ]
                    ],
                    'detail' => $this->createOrderList()
                ]
            ],
        ];
        $xml= $this->convertToXML($array);
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
        $items = [
            [
                'line-no' => '1',
                'item-code' => 'M04-100005-US',
                'quantity' => '1.0',
                'unit-of-measure' => 'EA',
            ],
             [
                'line-no' => '1',
                'item-code' => 'M04-100007-US',
                'quantity' => '3.0',
                'unit-of-measure' => 'EA',
            ]
        ];

        return $items;
    }

    private function sendToFulfillment($xml)
    {
        echo($xml);
    }


}