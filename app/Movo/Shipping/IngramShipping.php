<?php namespace Movo\Shipping;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Movo\Errors\OrderException;
use Movo\Handlers\OrderErrorLogHandler;
use StandardResponse;
use Order;
use Shipping;
use SoapBox\Formatter\Formatter;
use GuzzleHttp;
use GuzzleHttp\Client;
use SimpleXMLElement;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class IngramShipping implements ShippingInterface
{
    private static $failed = "Order appears to have connected to Brightpoint but no response received.";
    private static $success = "Order transmission successfully connected to Brightpoint.";

    public function ship(array $data)
    {
        $xml = $this->generateXMLFromData($data);
        //$xmlObj = new SimpleXMLElement($xml);
        $this->sendToFulfillment($xml);
    }

    public static function retryFailedOrders()
    {
        // CronTab values
        // 12 07-14 * * 1-5 php /var/www/vhosts/rx7w-7k7n.accessdomain.com/artisan scheduled:run 1>> /dev/null 2>&1

        // devorders machine
        // /var/www/vhosts/dkly-pzds.accessdomain.com/devorders.getmovo.com/movo-order-bridge
        // * 07-14 * * 1-5 php /var/www/vhosts/dkly-pzds.accessdomain.com/devorders.getmovo.com/movo-order-bridge/artisan scheduled:run 1>> /dev/null 2>&1

        //NOTE: figure out what designates a failed order
        //      filter and resend
        Log::info("Running retry orders");
        $orders = new Order();
        $ids = $orders->where('trim(ingram_order_id)', '=', '' )->orWhereNull('ingram_order_id')->get();
        if(count($ids) > 0) {
            Log::info(count($ids) . " Orders need to be retried.");

            $shipping = new ShippingHandler();
            foreach($ids as $id) {
                $data = IngramShipping::generateOrderArray($id);
                $shipping->handleNotification($data);
            }
        } else {
            Log::info("No retry orders");
        }

    }

    public static function encryptXML($xml)
    {
        $fp = fopen(base_path() . "/cert/messagehub_TEST.cer", "r");
        $pub_key = fread($fp, 8192);
        fclose($fp);
        openssl_public_encrypt($xml, $crypttext, $pub_key);
        return ($crypttext);
    }

    public function generateTestOrderIds()
    {
        $rand1 = rand ( 3 , 7 );
        $rand2 = rand ( 5 , 11 );
        Log::info($rand1 . " :: " . $rand2);
        $order = new Order();
        $ids = $order->getIds($rand1, $rand2);

        $idList = array();
        $count = 0;

        foreach($ids as $id) {
            if ($id->id % $rand1 === 0 || $id->id % $rand2 === 0) {
                continue;
            }
            $idList[$count] = $id->id;
            $count++;
        }

        foreach($idList as $k=>$l) {
            Log::info($k . " :: " . $l);
        }

        return $idList;
    }

    public static function generateTestOrder($orderID) {
        Log::info("Generating test order: " . $orderID);
        $data = array();
        $order = Order::find($orderID);
        Log::info("Shipping Type: " . $order->shipping_type);
        Log::info("Shipping Code: " . Shipping::find($order->shipping_type)->scac_code);

        $data['order_id'] = $order->id;
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
        $count = 1;
        foreach ($order->items() as $item) {
            $items[] = [
                "line-no" => $count++,
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

        return $data;

    }

    private static function generateOrderArray($order) {
        Log::info("Generating order array: " . $order->id);
        $data = array();
        Log::info("Shipping Type: " . $order->shipping_type);
        Log::info("Shipping Code: " . Shipping::find($order->shipping_type)->scac_code);

        $data['order_id'] = $order->id;
        $data['shipping-code'] = Shipping::find($order->shipping_type)->scac_code;
        $data['shipping-first-name'] = $order->shipping_first_name;
        $data['shipping-last-name'] = $order->shipping_last_name;
        $data['shipping-address'] = $order->shipping_address;
        $data['shipping-address2'] = $order->shipping_address2;
        $data['shipping-address3'] = $order->shipping_address3;
        $data['shipping-city'] = $order->shipping_city;
        $data['shipping-state'] = $order->shipping_state;
        $data['shipping-zip'] = $order->shipping_zip;
        $data['shipping-country'] = $order->shipping_country;
        $data['shipping-phone'] = $order->shipping_phone;;

        $data['billing-first-name'] = $order->billing_first_name;
        $data['billing-last-name'] = $order->billing_last_name;
        $data['billing-address'] = $order->billing_address;
        $data['billing-address2'] = $order->billing_address2;
        $data['billing-address3'] = $order->billing_address3;
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
        $count = 1;
        foreach ($order->items() as $item) {
            $items[] = [
                "line-no" => $count++,
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

        return $data;

    }

    public function convertToXML(array $data)
    {
        $formatter = Formatter::make($data, Formatter::ARR);
        $xml = $formatter->toXml();
        return $xml;
    }

    private function sendToFulfillment($xml)
    {
        $errorLog = new OrderErrorLogHandler();
        $log = new Logger('ingram-order-sent');
        $log->pushHandler(new StreamHandler(base_path().'/app/storage/logs/order-sent.log', Logger::INFO));

        $environment = App::environment();
        $url = htmlentities(getenv('ingram.ingram-url'));

        $log->addInfo("ENVIRONMENT: " . $environment);
        $log->addInfo("URL: " . $url);

        $string = preg_replace("/\r\n|\r|\n/", ' ', $xml);
        $new_xml = stripslashes($string);

        $log->addInfo("xml: " . $new_xml);

        $xmlObj = simplexml_load_string($xml);
        $id = $xmlObj->xpath('//purchase-order-number');
        $orderId = intval($id[0]);
        if(!isset($environment) && !isset($url)) {
            $errorLog->handleNotification([ "Error" => "Parameters not set properly",
                "environment" => isset($environment)?$environment:"",
                "url" => isset($url)?$url:"",
                "Message" => "Check the settings for url and environment in sentToFulfillment"]);

            return;
        }

        $errorLog->handleNotification([ "Order ID" => $orderId, "OrderXML" => $new_xml]);

        switch($environment){
            case 'production':
            case 'prod':
            case 'devorders':
            case 'qaorders':

            //->handleNotification($data);
            // The environment is local
            $ch = curl_init();

            $options = array(

                CURLOPT_POST => 1,
                CURLOPT_HTTPHEADER => ['Content-Type:', 'text/xml'],
                CURLOPT_POSTFIELDS => $new_xml,
                CURLOPT_RETURNTRANSFER => 1,
                //CURLOPT_SSLCERTTYPE => "DER",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => true,
                // CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_USERAGENT => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)',
                CURLOPT_VERBOSE => true,
                CURLOPT_URL => $url,
                CURLOPT_CAPATH => "/etc/pki/tls",
                CURLOPT_SSLVERSION => 3,
                //CURLOPT_SSLCERT => $cert_file ,
            );

            curl_setopt_array($ch, $options);

            $output = curl_exec($ch);
            $curl_errno = curl_errno($ch);
            $curl_error = curl_error($ch);

            $sp = new StandardResponse(); // Logs the transmission status

            if ($curl_errno > 0) {
                $errorLog->handleNotification([ "order_id" => $orderId,
                    "curl_errno" => $curl_errno,
                    "curl_error" => $curl_error,
                    "Message" => "Order transmission failed to connect to Brightpoint."]);

            } else {
                $errorLog->handleNotification([ "order_id" => $orderId,
                    "curl_errno" => $curl_errno,
                    "curl_error" => isset($curl_error)?$curl_error:"No error message",
                    "Message" => "Order transmission successfully connected to Brightpoint."]);

            }

            // NOTE: If there is a curl connection error log and let the retry job try the order again
            /*
             * [2015-03-23 18:27:43] ingram-order-test.INFO: cURL Error (35): SSL connect error  [] []
    [2015-03-23 18:27:43] ingram-order-test.INFO: Curl Error : SSL connect error [] []
    [2015-03-23 18:27:43] ingram-order-test.INFO: SSL connect error [] []

             */

            if (!$output) {

                $errorLog->handleNotification([ "order_id" => $orderId,
                    "curl_errno" => $curl_errno,
                    "curl_error" => $curl_error,
                    "Message" => IngramShipping::$failed]);

                $sp->logTransmissionError($orderId, $url,$curl_error, IngramShipping::$failed);

            } else {
                $startPos = strpos($output, "<?xml");
                $output = substr($output, $startPos);

                // Add to error log file
                $errorLog->handleNotification([ "order_id" => $orderId,
                    "curl_errno" => $curl_errno,
                    "curl_error" => isset($curl_error)?$curl_error:"No error message",
                    "Message Status" => IngramShipping::$success,
                    "Message" => $output]);

                $sp->parseAndSaveData($orderId, $output);
            }

            if(strcasecmp($environment, "devorders")) {
                sleep(.3);
            }

            curl_close($ch);
            default:
                 // Do nothing
                 break;

        }

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
        $date_str = date_format($date, 'Ymd');

        $array = [
            'message' => [
                'message-header' => [
                    'message-id' => '12345',
                    'transaction-name' => 'sales-order-submission',
                    'partner-name' => Config::get('services.ingram.partner-name'),
                    'partner-password' => '',
                    'source-url' => Config::get('services.ingram.source-url'),
                    'create-timestamp' => $date_str,
                    'response-request' => '1',
                ],
                'sales-order-submission' => [
                    'header' => [
                        'customer-id' => Config::get('services.ingram.customer-id'),
                        'business-name' => '',
                        'carrier-name' => $data['shipping-code'],
                        'customer-information' => [
                            'customer-first-name' => $data['billing-first-name'],
                            'customer-last-name' => $data['billing-last-name'],
                            'customer-middle-initial' => '',
                            'customer-address1' => $data['billing-address'],
                            'customer-address2' => (isset($data['billing-address2']) &&
                                                    strlen($data['billing-address2']) > 0)?$data['billing-address2'] :'',
                            'customer-address3' => (isset($data['billing-address3']) &&
                                                    strlen($data['billing-address3']) > 0)?$data['billing-address3'] :'',
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
                            'ship-address2' => (isset($data['shipping-address2']) &&
                                                strlen($data['shipping-address2']) > 0)?$data['shipping-address2'] :'',
                            'ship-address3' => (isset($data['shipping-address3']) &&
                                                strlen($data['shipping-address3']) > 0)?$data['shipping-address3'] :'',
                            'ship-city' => $data['shipping-city'],
                            'ship-state' => $data['shipping-state'],
                            'ship-post-code' => $data['shipping-zip'],
                            'ship-country-code' => $data['shipping-country'],
                            'ship-phone1' => $data['shipping-phone'],
                            'ship-phone2' => '',
                            'ship-fax' => '',
                            'ship-email' => $data['email'],
                            'ship-via' => $data['shipping-code'],
                            'ship-request-date' => $date_str,
                            'ship-request-from' => 'Indianapolis',
                            'ship-request-warehouse' => 'MVO1',
                        ],
                        'purchase-order-information' => [
                            'purchase-order-number' => $data['order_id'],
                            'purchase-order-amount' => '',
                            'currency-code' => 'USD',
                            'account-description' => '',
                            'comments' => '',
                        ],
                        'credit-card-information' => [
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
                            'customer-order-number' => $data['order_id'],
                            'customer-order-date' => $date_str,
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