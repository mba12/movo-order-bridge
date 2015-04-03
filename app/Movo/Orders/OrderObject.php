<?php
/**
 * Created by PhpStorm.
 * User: ahern
 * Date: 4/2/15
 * Time: 10:51 AM
 */

namespace Movo\Orders;

use Movo\Handlers\OrderErrorLogHandler;


class OrderObject {

    private $propertyMap = array();
    private $error = false;
    private $errorCodes = array();
    private static $required = array(
                    "quantity","shipping-type","shipping-first-name","shipping-last-name","shipping-address",
                    "shipping-city","shipping-state","shipping-zip","partner_id","partner_order_id");

    function __construct() {
        $this->propertyMap['items'] = array();
    }

    public function asFirstArray() {
        return $this->propertyMap;
    }


    public function asArray() {
        $this->convertToNumberedItems();
        return $this->propertyMap;
    }

    private function convertToNumberedItems() {
        $items = $this->propertyMap['items'];

        $newItems=[];
        // Copy each item to a numbered index
        foreach($items as $sku => $item) {
            $newItems[]=[
                "sku"=>$item['sku'] ,
                "description"=>$item['description'],
                "quantity"=>$item['quantity'],
            ];
        }

        unset($items);

        $this->setProperty('items', $newItems);
    }

    public function setProperty($key, $value) {
        $this->propertyMap[$key] = $value;
    }

    public function getProperty($key) {
        if (isset($this->propertyMap[$key])) {
            return $this->propertyMap[$key];
        } else {
            return null;
        }
    }

    public function getErrorCodes() {
        return implode(":",$this->errorCodes);
    }

    public function flagWithError() {
        $this->error = true;
    }

    public function getId() {
        return $this->getProperty('partner_order_id');
    }

    public function getTotalQuantity() {
        $items = $this->getProperty('items');

        $total = 0;
        foreach($items as $sku => $item) {
            $total += $item['quantity'];
        }

        return $total;
    }

    public function addItems($newItems) {

        $items = $this->getProperty('items');
        $size = count($newItems);

        for($i=0; $i < $size; $i++) {
            $sku = $newItems[$i]['sku'];

            if ( array_key_exists ( $sku , $items ) ) {
                $items[$sku]['quantity'] += $newItems[$i]['quantity'];
            } else {
                $items[$sku] = $newItems[$i];
            }
        }

        $this->setProperty('items', $items);

    }

    private function addItem($sku, $newItem) {

        $items = $this->getProperty('items');

        if( array_key_exists($sku, $items)) {
            $items[$sku]['quantity'] += $newItem['quantity'];

        } else {
            $items[$sku] = $newItem;
        }

        $this->setProperty('items', $items);
        $quantity = $this->getProperty('quantity');
        $quantity += $newItem['quantity'];
        $this->setProperty('quantity', $quantity);
    }

    public function isReturn() {

        $return = false;
        if (isset($this->propertyMap['Refunded']) &&
            strlen($this->propertyMap['Refunded']) > 0) {
            $return = true;
        }
        return $return;

    }

    public function isValid() {

        $valid = false;
        $count = 0;
        $zip = $this->getProperty('shipping-zip');
        if (isset($zip) &&
            (strlen($zip) == 5 || strlen($zip) == 10) ) {
            $count++;
        } else {
            array_push($this->errorCodes, "Zip Code is Invalid ");
        }

        $id = $this->getProperty('partner_order_id');
        if (isset($id)) {
            $count++;
        } else {
            array_push($this->errorCodes, "Order Number is missing ");
        }

        $quantity = $this->getProperty('quantity');
        if (isset($quantity) && $quantity > 0 ) {
            $count++;
        } else {
            array_push($this->errorCodes, "Quantity (QTY) is missing or zero ");
        }

        $failure = false;
        foreach(OrderObject::$required as $r) {
            $test = $this->getProperty($r);
            if(!isset($test)) {
                $failure = true;
                array_push($this->errorCodes, "Required field " . $r . " is missing or zero ");
            }
        }
        if(!$failure) {$count++;}

        if(!$this->error) {
            $count++;
        } else {
            array_push($this->errorCodes, "General Error: likely SKU is missing ");
        }

        if($count == 5) { $valid = true; }

        return $valid;

    }

    public function combineOrderLines($orderObject) {

        $items = $orderObject->getProperty('items');
        foreach($items as $sku => $item) {
            $this->addItem($sku, $item);
        }

    }

}