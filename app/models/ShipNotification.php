<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class ShipNotification extends \Eloquent
{

    //  <purchase-order-number>606</purchase-order-number>
    protected $guarded = [];
    protected $table = "ship_notification";
    public static $fieldList = [

        "message-id",
        "transaction-name",
        "partner-name",
        "source-url",
        "create-timestamp",
        "response-request",

        "customer-id",
        "ship-first-name",
        "ship-last-name",
        "ship-middle-initial",
        "ship-address1",
        "ship-address2",
        "ship-address3",
        "ship-city",
        "ship-state",
        "ship-post-code",
        "ship-country-code",
        "ship-phone1",
        "ship-email",
        "ship-via",
        "ship-request-date",
        "ship-request-warehouse",

        "purchase-order-number",
        "account-description",
        "purchase-order-amount",
        "currency-code",

        "customer-order-number",
        "customer-order-date",
        "order-total-net",
        "order-status",
        "order-type",
        "brightpoint-order-number",
        "warehouse-id",
        "ship-date",
        "bill-of-lading",
        "scac",
        "ship-to-code",

    ];

    public static function parseSAndSaveData($doc)
    {

        // TODO: This needs to get cleaned up -- only need to parse the incoming once not twice
        $betterArray = ShipNotification::parseXMLtoArray($doc);

        $xml = new SimpleXMLElement($doc);
        $data = ShipNotification::parseData($xml);
        ShipNotification::saveData($data);

        $items = $betterArray['ship-advice']['detail'];

        // NOTE: this is a real hack to deal with how the arrays come back from Ingram
        if (array_key_exists(0, $items['line-item'] ) === false) {
            $temp = $items['line-item'];
            unset($items['line-item']);
            $items['line-item'][0] = $temp;
        }

        $quantity = ShipNotification::sumQuantity($items['line-item']); // ok
        ShipNotification::lookupItemDescriptions($items['line-item']); // OK
        ShippedItems::saveData($betterArray['message-header']['message-id'], $items['line-item']);

        $timestamp = DateTime::createFromFormat('Ymd', $betterArray['ship-advice']['header']['order-header']['customer-order-date']);
        $order_date = date('m-d-Y', $timestamp->getTimestamp() );

        $updateInfo =   [   'order_number' => strval($data['purchase-order-number']),
                            'tracking_code' => strval($data['bill-of-lading']),
                            'ship_email' => $data['ship-email'],
                            "name" => $data["ship-first-name"] . " " . $data["ship-last-name"],
                            "address1" => $data["ship-address1"],
                            "address2" => $data["ship-address2"],
                            "address3" => $data["ship-address3"],
                            "address4" => $data["ship-city"] . ", " . $data["ship-state"] . " " . $data["ship-post-code"],
                            "ship_country_code" => $data["ship-country-code"],
                            "order_total_net" => $data["order-total-net"],
                            "result" => ["amount" => $data["order-total-net"]],
                            "items" => $items,
                            "quantity" => $quantity,
                            "order_date" => $order_date,
                            "brightpoint-order-number" => $data["brightpoint-order-number"],
                            "ship-to-code" => $data["ship-to-code"],
        ];

        return $updateInfo;

    }

    private static function lookupItemDescriptions(&$items) {
        // universal-product-code

        $size = count($items);
        for($i=0;$i<$size;$i++) {
            $items[$i]['name'] = Product::getNameBySKU($items[$i]['universal-product-code']);
        }
        /*
        foreach($items as &$item) {
            $item['name'] = Product::getNameBySKU($item['universal-product-code']);
        }
        */
    }

    private static function sumQuantity($items) {
        $debug = var_export($items, true);
        Log::info("The array " . count($items) . ": " . $debug);

        $quantity = 0;
        $size = count($items);
        for($i=0; $i<$size; $i++) {
            $quantity += $i['ship-quantity'];
        }
        return $quantity;
    }

    private static function parseData($xml)
    {
        $data=[];

        // TODO: This process does not take into account multiple items
        //       Should check against our items table to make sure the
        //       items going out in the ship advice match against what was ordered.
        foreach (ShipNotification::$fieldList as $f) {
            $data[$f] = ShipNotification::checkData( $xml->xpath("//" . $f) );
        }

        return $data;
    }

    private static function parseXMLtoArray($string) {

        $array = json_decode(json_encode((array) simplexml_load_string($string)), 1);

        return $array;
    }

    private static function checkData($data) {

        if (isset($data[0])) {
            return (String) $data[0];
        } else {
            return '';
        }
    }

    private static function saveData($data)
    {

        $inputValues = array();
        foreach(ShipNotification::$fieldList as $v) {
            $dbField = str_replace("-", "_", $v);
            $inputValues[$dbField] = $data[$v];
        }

        ShipNotification::create($inputValues);

    }

}
