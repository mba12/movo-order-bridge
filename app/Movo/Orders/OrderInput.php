<?php
/**
 * Created by IntelliJ IDEA.
 * User: Alex
 * Date: 12/1/2014
 * Time: 10:16 AM
 */

namespace Movo\Orders;

use Illuminate\Support\Facades\Input;
use GuzzleHttp;
class OrderInput
{
    private static $COUNTRY = "shipping-country";
    private static $BILLING_COUNTRY = "billing-country";
    private static $SHIP_PHONE = "shipping-phone";
    private static $BILL_PHONE = "billing-phone";
    private static $SHIP_STATE = "shipping-state";
    private static $BILL_STATE = "billing-state";
    private static $SHIP_ZIP = "shipping-zip";

    private static $STATE_CODES =  [
        "Alabama" => "AL","Alaska" => "AK","Arizona" => "AZ","Arkansas" => "AR","California" => "CA",
        "Colorado" => "CO","Connecticut" => "CT","Delaware" => "DE","Dist. Of Columbia" => "DC",
        "District Of Columbia" => "DC", "Florida" => "FL", "Georgia" => "GA", "Hawaii" => "HI",
        "Idaho" => "ID", "Illinois" => "IL", "Indiana" => "IN", "Iowa" => "IA", "Kansas" => "KS",
        "Kentucky" => "KY", "Louisiana" => "LA", "Maine" => "ME", "Maryland" => "MD", "Massachusetts" => "MA",
        "Michigan" => "MI", "Minnesota" => "MN", "Mississippi" => "MS", "Missouri" => "MO", "Montana" => "MT",
        "Nebraska" => "NE", "Nevada" => "NV", "New Hampshire" => "NH", "New Jersey" => "NJ", "New Mexico" => "NM",
        "New York" => "NY", "North Carolina" => "NC", "North Dakota" => "ND", "Ohio" => "OH", "Oklahoma" => "OK",
        "Oregon" => "OR", "Pennsylvania" => "PA", "Rhode Island" => "RI", "South Carolina" => "SC",
        "South Dakota" => "SD", "Tennessee" => "TN", "Texas" => "TX", "Utah" => "UT", "Vermont" => "VT",
        "Virginia" => "VA", "Washington" => "WA", "West Virginia" => "WV", "Wisconsin" => "WI",
        "Wyoming" => "WY", "American Samoa" => "AS", "Guam" => "GU", "Northern Mariana Islands" => "MP",
		"Puerto Rico" => "PR", "U.S. Virgin Islands" => "VI", "U.s. Virgin Islands" => "VI",
        "Us Virgin Islands" => "VI", "United States Minor Outlying Islands" => "UM",
		];

    private static $stackFieldMap = array(
        "quantity" => 'QTY',
        "sku" => 'Vendor SKU',
        "shipping-type" => "shipping-type",
        "shipping-first-name" => 'Shipping First Name',
        "shipping-last-name" => 'Shipping Last Name',
        "shipping-address" => "Shipping Address 1" ,
        "shipping-address2" => 'Shipping Address 2',
        "shipping-city" => "City",
        "shipping-state" => "State",
        "shipping-zip" => "Zip",
        "shipping-country" => "Country",
        "shipping-phone" => "shipping-phone",
        "coupon" => "coupon",
        "billing-first-name" => 'Shipping First Name',
        "billing-last-name" => 'Shipping Last Name',
        "billing-address" => "Shipping Address 1",
        "billing-city" => 'City',
        "billing-state"=> 'State',
        "billing-zip"=> 'Zip',
        "billing-country"=> 'Country',
        "billing-phone" => "billing-phone",
        "email" => "Email",
        "partner_id" => "partner_id",
        "partner_order_id" => "Order Num",
        "shipping-type" => "shipping-type");

    private static $movoFieldMap = array(
        "shipping-type" => "Shipping-Type",
        "shipping-first-name" => "First",
        "shipping-last-name" => "Last",
        "shipping-address" => "Shipping Address 1" ,
        "shipping-address2" => "Shipping Address 2" ,
        "shipping-address3" => "Shipping Address 3" ,
        "shipping-city" => "City",
        "shipping-state" => "State",
        "shipping-zip" => "Zip",
        "shipping-country" => "Country",
        "shipping-phone" => "Telephone",
        "billing-first-name" => "Billing First Name",
        "billing-last-name" => "Billing Last Name",
        "email" => "Email Address",
        "partner_id" => "Partner-id",
        "partner_order_id" => "Partner-Order-Id");

    private static $productIdMap = array (  'X-Small-Qty' => 1,'Small-Qty' => 2,'Medium-Qty' => 3,'Large-Qty' => 4,
                                            'X-Large-Qty' => 5,'Standard-Qty'=>6,'Neon-Qty'=>7);

    private static $productList = array ('X-Small-Qty','Small-Qty','Medium-Qty','Large-Qty','X-Large-Qty',
                                         'Standard-Qty','Neon-Qty');


    public static function convertInputToData($data)
    {
        $data['quantity'] = Input::get("quantity");
        $data['charity'] = Input::get("charity");
        $data['shipping-type'] = Input::get("shipping-type");
        $data['shipping-first-name'] = Input::get("shipping-first-name");
        $data['shipping-last-name'] = Input::get("shipping-last-name");
        $data['shipping-address'] = Input::get("shipping-address");
        $data['shipping-city'] = Input::get("shipping-city");
        $data['shipping-state'] = Input::get("shipping-state");
        $data['shipping-zip'] = Input::get("shipping-zip");
        $data['shipping-country'] = Input::get("shipping-country");
        $data['shipping-phone'] = Input::get("shipping-phone");

        $data['billing-first-name'] = Input::get("billing-first-name");
        $data['billing-last-name'] = Input::get("billing-last-name");
        $data['billing-address'] = Input::get("billing-address");
        $data['billing-city'] = Input::get("billing-city");
        $data['billing-state'] = Input::get("billing-state");
        $data['billing-zip'] = Input::get("billing-zip");
        $data['billing-country'] = Input::get("billing-country");
        $data['billing-phone'] = Input::get("billing-phone");
        $data['email'] = Input::get("email");
        $data['coupon'] = Input::has("code") ? Input::get("code") : "";
        $data['quantity'] =0;
        $items=[];
        for ($i = 0; $i < Input::get("quantity"); $i++) {
            $items[]=[
                "sku"=>Input::get("unit" . ($i + 1)) ,
                "description"=>Input::get("unit" . ($i + 1)."Name"),
            ];
            $data['quantity']++;
        }
        $loops=json_decode(Input::get("loops"));

        for ($i = 0; $i < sizeof($loops); $i++) {
            $item=$loops[$i];
            $items[]=[
                "sku"=>$item->sku ,
                "description"=>$item->name,
                "quantity"=>$item->quantity,
            ];
            $data['quantity']+=$item->quantity;
        }
        $data['items']= $items;

        return $data;
    }

    public static function convertStackCSVInputToData($csvData)
    {

        $orderObject = new OrderObject();
        $row = 0;
        foreach(OrderInput::$stackFieldMap as $key => $value ) {
            if (isset($csvData[$value])) {
                $filtered = OrderInput::filterCheckField($key, $csvData[$value]);
                $orderObject->setProperty($key, $filtered);
            } else {
                $orderObject->setProperty($key, "");
            }
            $row++;
        }

        switch ($csvData['Vendor SKU']) {
            case  857458005039:
            case '857458005039':
                $products =  \Product::getLargeBundle();
                break;
            case  857458005022:
            case '857458005022':
                $products =  \Product::getMediumBundle();
                break;
            default:
                $orderObject->flagWithError();
                break;
        }

        // Now loop through the products and add them to the item array
        $quantity = 0; // represents the total number of items in the order
        $items= array();
        $i = 0;
        foreach ($products as $p) {
            $items[$i]=[
                "sku"=> $p->sku,
                "description"=> $p->name,
                "quantity"=>$csvData['QTY'],
            ];
            $i++;
            $quantity += $csvData['QTY'];
        }
        $orderObject->addItems($items);
        $orderObject->setProperty('quantity', $quantity);

        return $orderObject;
    }

    private static function filterCheckField($key, $value) {

        switch ($key) {
            case OrderInput::$COUNTRY:
            case OrderInput::$BILLING_COUNTRY:
                //TODO: needs to handle more country codes
                $newValue = "US";
                break;
            case OrderInput::$SHIP_PHONE:
            case OrderInput::$BILL_PHONE:
                // strip out any non-numeric characters
                $newValue = preg_replace("/[^0-9]/", "", $value);
                break;
            case OrderInput::$SHIP_STATE:
            case OrderInput::$BILL_STATE:
                if(strlen($value) === 2) {
                    $newValue = $value;
                } else {
                    $newValue = OrderInput::$STATE_CODES[ucwords($value)];
                }
                break;
            case OrderInput::$SHIP_ZIP:
                if(strlen($value) === 4) {
                    $newValue = "0" . $value;
                } else {
                    $newValue = $value;
                }
                break;
            default:
                $newValue = $value;
        }
        return $newValue;
    }

    public static function convertMovoCSVInputToData($csvData)
    {
        $row = 0;
        foreach(OrderInput::$movoFieldMap as $key => $value ) {
            if (isset($csvData[$value])) {
                $filtered = OrderInput::filterCheckField($key, $csvData[$value]);
                $data[$key] = $filtered;
            } else {
                $data[$key] = "";
            }
            $row++;
        }

        // Now loop through the products and add them to the item array
        $data['quantity'] = 0; // represents the total number of items in the order
        $items=[];
        $i = 0;
        foreach(OrderInput::$productList as $product) {
            if( isset($csvData[$product]) && strlen(strval($csvData[$product])) > 0 && is_numeric($csvData[$product]) ) {
                $productId = OrderInput::$productIdMap[$product];
                $p =  \Product::find($productId, ['sku', 'name']);
                $items[$i]=[
                    "sku"=> $p->sku,
                    "description"=> $p->name,
                    "quantity"=>$csvData[$product],
                ];
                $data['quantity']+=$csvData[$product];
                $i++;
            }
        }

        $data['billing-address'] = "";
        $data['billing-city'] = "";
        $data['billing-state'] = "";
        $data['billing-zip'] = "";
        $data['billing-country'] = "";
        $data['billing-phone'] = "";
        $data['coupon'] = "";

        $data['items']= $items;

        return $data;
    }

}