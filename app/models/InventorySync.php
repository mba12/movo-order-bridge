<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class InventorySync extends \Eloquent
{
    protected $guarded = [];
    protected $table = "inventory_sync";

    public static $fieldList = [ 'message-id',
                                'transaction-name',
                                'partner-name',
                                'source-url',
                                'create-timestamp',
                                'response-request',
                                'customer-id',
                                'line-no',
                                'transaction-document-number',
                                'item-code',
                                'universal-product-code',
                                'warehouse-id',
                                'unit-of-measure',
                                'quantity-on-hand',
                                'quantity-committed',
                                'quantity-available',
                                'quantity-on-back-order',
                                'synchronization-timestamp',
                                'eventID'];

    public static function parseAndSaveData($xmlString)
    {
        $xml = new SimpleXMLElement($xmlString);
        $result = $xml->xpath('//line-item');
        for ($i = 0; $i < sizeof($result); $i++) {
            $data = InventorySync::parseData($result[$i], $i);
            InventorySync::saveData($data);
        }
    }

    private static function parseData($xml, $i)
    {

        $data = [];
        foreach (InventorySync::$fieldList as $f) {
            $data[$f] = InventorySync::checkData( $xml->xpath("//" . $f), $i );
        }

        return $data;

/*

        $data["message_id"] = (String)$xml->xpath('//message-id')[0];
        $data["transaction_name"] = (String)$xml->xpath('//transaction-name')[0];
        $data["partner_name"] = (String)$xml->xpath('//partner-name')[0];
        $data["source_url"] = (String)$xml->xpath('//source-url')[0];
        $data["create_timestamp"] = (String)$xml->xpath('//create-timestamp')[0];
        $data["response_request"] =(String) $xml->xpath('//response-request')[0];
        $data["customer_id"] = (String)$xml->xpath('//customer-id')[0];
        $data["line_no"] = (String)$xml->xpath('//line-no')[$i];
        $data["transaction_document_number"] = (String)$xml->xpath('//transaction-document-number')[$i];
        $data["item_code"] = (String)$xml->xpath('//item-code')[$i];
        $data["universal_product_code"] = (String)$xml->xpath('//universal-product-code')[$i];
        $data["warehouse_id"] = (String)$xml->xpath('//warehouse-id')[$i];
        $data["unit_of_measure"] = (String)$xml->xpath('//unit-of-measure')[$i];
        $data["quantity_on_hand"] = (String)$xml->xpath('//quantity-on-hand')[$i];
        $data["quantity_committed"] = (String)$xml->xpath('//quantity-committed')[$i];
        $data["quantity_available"] = (String)$xml->xpath('//quantity-available')[$i];
        $data["quantity_on_back_order"] = (String)$xml->xpath('//quantity-on-back-order')[$i];
        $data["synchronization_timestamp"] = (String)$xml->xpath('//synchronization-timestamp')[$i];
        $data["eventID"] = (String)$xml->xpath('//eventID')[0];
        return $data;
*/
    }

    private static function saveData($data)
    {

        $inputValues = array();
        foreach(InventorySync::$fieldList as $v) {
            $dbField = str_replace("-", "_", $v);
            $inputValues[$dbField] = $data[$v];
        }

        InventorySync::create($inputValues);

/*
        InventorySync::create([
            "message_id" => $data["message_id"],
            "transaction_name" => $data["transaction_name"],
            "partner_name" => $data["partner_name"],
            "partner_password" => "",
            "source_url" => $data["source_url"],
            "create_timestamp" => $data["create_timestamp"],
            "response_request" => $data["response_request"],
            "customer_id" => $data["customer_id"],
            "business_name" => "",
            "line_no" => $data["line_no"],
            "transaction_document_number" => $data["transaction_document_number"],
            "item_code" => $data["item_code"],
            "universal_product_code" => $data["universal_product_code"],
            "warehouse_id" => $data["warehouse_id"],
            "unit_of_measure" => $data["unit_of_measure"],
            "quantity_on_hand" => $data["quantity_on_hand"],
            "quantity_committed" => $data["quantity_committed"],
            "quantity_available" => $data["quantity_available"],
            "quantity_on_back_order" => $data["quantity_on_back_order"],
            "synchronization_timestamp" => $data["synchronization_timestamp"],
            "comments" => "",
            "eventID" => $data["eventID"],
        ]);
*/
    }

    private static function checkData($data, $i) {

        if (isset($data[$i])) {
            return (String) $data[$i];
        } else {
            return '';
        }
    }


}
