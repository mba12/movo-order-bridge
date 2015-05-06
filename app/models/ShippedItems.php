<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class ShippedItems extends \Eloquent
{
    protected $fillable = [
        'message_id',
        'line_no',
        'item_code',
        'upc',
        'ship_quantity',
        'unit_of_measure',
        'base_price',
        'bill_of_lading',
        'pallet_id',
        'scac',
        'container_id',
    ];

    //  <purchase-order-number>606</purchase-order-number>
    protected $guarded = [];
    protected $table = "shipped_items";
    public static $fieldList = [
                        'line-no',
                        'item-code',
                        'universal-product-code',
                        'ship-quantity',
                        'unit-of-measure',
                        'base-price',
                        'bill-of-lading',
                        'pallet-id',
                        'scac',
                        'container-id'];



    private static function parseData($xml)
    {
        $data=[];

        foreach (ShippedItems::$fieldList as $f) {
            $data[$f] = ShippedItems::checkData( $xml->xpath("//" . $f) );
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

    public static function saveData($messageId, $items)
    {
        foreach($items as $item) {
            $inputValues = array();
            $inputValues['message_id'] = $messageId;
            foreach(ShippedItems::$fieldList as $v) {
                $dbField = str_replace("-", "_", $v);
                $inputValues[$dbField] = isset($item[$v])?$item[$v]:"";
            }
            ShippedItems::create($inputValues);
        }
    }

}
