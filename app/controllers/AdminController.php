<?php

use Movo\Shipping\ShippingDropdown;
use Movo\Orders\CsvValidation;
use Movo\Orders\OrderInput;

class AdminController extends \BaseController
{

    private $order;
    private $slackHeader = array('Batch ID','Order Date','Order Num','Sale ID','Sale Name','Vendor SKU','Stack SKU',
        'Product Name','QTY','Shipping First Name','Shipping Last Name','Shipping Address 1','Shipping Address 2',
        'City','State','Zip','Country','Email','Refunded','Carrier','Tracking Number');

    private $movoHeader = array('Partner-id','Partner-Order-Id','Billing First Name','Billing Last Name',
                                'Shipping-Type', 'Ship On Date','First','Last','Email Address',
                                'Telephone','Shipping Address 1','Shipping Address 2','Shipping Address 3','City',
                                'State','Zip',
                                'X-Small-Qty','Small-Qty','Medium-Qty','Large-Qty','X-Large-Qty',
                                'Standard-Qty','Neon-Qty');

    private $retailHeader = array('Partner-id','Partner-Order-Id','Retailer Code','Billing First Name','Billing Last Name',
        'Shipping-Type','Ship On Date','Ship No Later','Delivery Date','First','Last','Email Address',
        'Telephone', 'Shipping Address 1','Shipping Address 2','Shipping Address 3','City',
        'State','Zip', 'X-Small-Qty','Small-Qty','Medium-Qty','Large-Qty','X-Large-Qty',
        'Standard-Qty','Neon-Qty');

    private $env;
    private $url;


    function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function setEnvAndUrl($e, $u) {
        $this->$env = $e;
        $this->$url = $u;
    }

    public function index()
    {
        return View::make("admin.index", $this->getStatsArray());
    }

    private function getStatsArray()
    {
        $coupons = Coupon::where('active', '=', 1)->get();
        $couponCounts = [];
        foreach ($coupons as $coupon) {
            $couponCounts[] = $coupon->usedCouponCount();
        }
        $lastHour = $this->order->lastHour()->count();
        $lastDay = $this->order->lastDay()->count();
        $lastWeek = $this->order->lastWeek()->count();
        $lastMonth = $this->order->lastMonth()->count();
        $errors = $this->order->errors()->count();
        return [
            "coupons" => $coupons,
            "lastHour" => $lastHour,
            "lastDay" => $lastDay,
            "lastWeek" => $lastWeek,
            "lastMonth" => $lastMonth,
            "errors" => $errors,
            "couponCounts" => $couponCounts,
        ];
    }

    public function coupons()
    {
        $coupons = Coupon::all();

        return View::make("admin.coupons", [
            "coupons" => $coupons,
        ]);
    }

    public function orders()
    {
        return View::make("admin.orders", [
            'orders' => $this->getOrderPagination()
        ]);
    }

    public function orderDetails($id)
    {
        Log::info("Order ID: " . $id);
        $order = Order::find($id);
        Log::info("Order Lookup from admin page: " . $order->shipping_first_name . " : " . $order->shipping_last_name);

        // $combinedItems = $order->combineAndCountItems($order->items()->all());
        $combinedItems = $order->combineAndCountItems($order->items()->getResults());

        if(isset($order->tracking_code) && strlen($order->tracking_code) > 0) {
            $trackLink = 'https://www.fedex.com/apps/fedextrack/?action=track&trackingnumber=' . $order->tracking_code . '&cntry_code=us';
        } else {
            $trackLink = '';
        }

        return View::make("admin.order-details", [
            'order' => $order,
            'shipping' => Shipping::find($order->shipping_type),
            'combinedItems' => $combinedItems,
            'trackLink' => $trackLink,
        ]);
    }

    public function orderSearch()
    {

        $searchField = Input::get("search");
        $criteria = Input::get("criteria");
        if ($searchField != "" || $criteria == "error_flag") {
            if ($criteria == "error_flag" && $searchField == "") $searchField = 1;
            $searchResults = Order::where($criteria, "LIKE", "%" . $searchField . "%")->paginate(36);
            return View::make("admin.search-results", [
                'orders' => $searchResults
            ]);
        }

        return Redirect::route("admin-orders");
    }

    public function getStats()
    {
        return $this->getStatsArray();
    }

    public function login()
    {
        return View::make("admin.login");
    }

    public function attemptLogin()
    {
        if (Auth::validate(array('name' => Input::get("name"), 'password' => Input::get("password")), true)) {
            Session::put('admin', 'true');
            return Redirect::to('/admin');

        } else {
            return Redirect::to('/admin/login')->with("global", "Please enter valid login information");
        }
    }

    private function getOrderPagination()
    {
        return Order::orderBy("created_at", "DESC")->paginate(36);
    }

    public function manual()
    {

        $manual = array();
        $manual['test'] = 'test';

        Log::info("PRE Products ");

        $waves=Product::allManual();

        Log::info("Products: " . $waves);

        $charities=Charity::getList();
        $shippingInfo = Shipping::getShippingMethodsAndPrices();
        $sizeInfo = $waves;
        $stateTaxMethods = Tax::getStateTaxMethods();
        $coupon = null;
        $code = Input::get("code");
        if ($code) {
            $coupon = Coupon::where("code", "=", $code)->first();
        }

        return View::make('admin.manual', [
            'shippingDropdownData' => $shippingInfo,
            'sizeInfo' => $sizeInfo,
            'stateTaxMethods' => $stateTaxMethods,
            'after3pm' => strtotime("03:00 pm") - time() < 0,
            'charities'=>$charities,
            'waves'=>$waves,
            'manual'=>$manual
        ]);
    }


    public function upload()
    {
        $manual = 'Michael';
        return View::make('admin.upload', [
            'manual'=>$manual
        ]);

    }

    private function backupCsvFile() {

        // Get the app base directory
        $folder = storage_path() . '/csvuploads';

        // Make sure the 'csvuploads' directory exists
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        // Get the current time

        $timeString = date('YmdHis');

        // go to the storage uploads directory
        $fileName = 'upload.' . $timeString;

        // move the csv file into storage before processing
        // give it a new name based on a timestamp
        Input::file('file')->move($folder, $fileName);

        return $folder . '/' . $fileName;
    }

    public function processUploads()
    {

        $partnerId = Input::get("partner_id");
        $fileName = $this->backupCsvFile();

        $status = '';
        if (strcasecmp($partnerId,'STACK') == 0) {
            $status = $this->processStack($this->slackHeader, $fileName, $partnerId);
        } else if (strcasecmp($partnerId,'MOVO') == 0 || strcasecmp($partnerId,'AHA') == 0) {
            $status = $this->processPartner($this->movoHeader, $fileName, $partnerId);
        } else if (strcasecmp($partnerId,'RETAIL') == 0) {
            Log::info("Entering processRetail: ");
            $status = $this->processRetail($this->retailHeader, $fileName, $partnerId);
        }

        Log::info("Completed upload: " . $fileName);

        $stringArray = print_r($status, true);
        Log::info("Status: " . $stringArray);

        return View::make('admin.upload', [
            'statusList' => $status,
        ]);
    }


    private function processStack($header, $fileName, $partnerId) {

        $status = '';
        $error = false;
        $row = 0;
        $masterOrderList = array(); // key is order number
        if (($handle = fopen($fileName, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                // validate the header row before processing
                if($row === 0) {
                    $valid = CsvValidation::validateHeaders($header, $data);
                    if ($valid === false) {
                        Log::info("Header validation failed for file: " . $fileName);
                        $status = 'The header validation failed. You did not upload a CSV file in Stack format. Or the file format may be corrupt if proper line breaks do not exist between the lines. Check for bad line breaks with a good text editor. Open the CSV file in a text editor to check.';
                        $error = true;
                        break;
                    }
                } else {

                    // Pass each row to the order processing routine
                    Log::info("Processing row: " . $row);
                    $map = array();
                    $c = 0;
                    foreach($header as $key) {
                        if (isset($data[$c])) {
                            $map[$key] = $data[$c];
                        } else {
                            $map[$key] = "";
                        }
                        $c++;
                    }

                    $map['partner_id'] = $partnerId;
                    $map['shipping-type'] = "2";

                    $orderObject = OrderInput::convertStackCSVInputToData($map);

                    if($orderObject->isReturn()) {
                        $row++;
                        continue;
                    }

                    // If not valid or a return skip this order
                    if ( !$orderObject->isValid() ) {
                        $status .= 'Error in row: ' . $row . ' in file: ' . $fileName;
                        $status .= '<br/><br/>Error Codes: ' . $orderObject->getErrorCodes();
                        $error = true;
                        break;
                    }

                    $this->addOrderToList($masterOrderList, $orderObject);
                }
                $row++;
            }
            fclose($handle);

            if (!$error) {
                // The entire file has been processed and consolidated into
                // a single data structure. Now being processed one consolidated order
                // at a time. The original file may contain skus on multiple lines.
                $processor=new Movo\Orders\ProcessOrder();
                $status = $processor->processMultipleOffline($masterOrderList);
            }

        }

        return $status;

    }

    private function addOrderToList(&$masterOrderList, $orderObject) {

        $id = $orderObject->getId();

        if ( array_key_exists ( $id , $masterOrderList ) ) {
            $existingOrder = $masterOrderList[$id];
            $existingOrder->combineOrderLines($orderObject);
            $masterOrderList[$id] = $existingOrder;
        } else {
            $masterOrderList[$id] = $orderObject;
        }
    }

    private function processPartner($header, $fileName, $partnerId) {

        // read and parse the csv file
        $processor=new Movo\Orders\ProcessOrder();
        $row = 0; $count = 0;
        $status = '';
        $statusList = array();
        if (($handle = fopen($fileName, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                // validate the header row before processing
                if($row === 0) {
                    $valid = CsvValidation::validateHeaders($header, $data);
                    if ($valid === false) {
                        Log::info("Header validation false ");
                        $status = "The attached CSV file header was not in Movo format. You are likely loaded a Stack Social formatted file as a Movo/AHA file.";
                        break;
                    } else {
                        $row++;
                        continue;
                    }
                } else {

                    // Pass each row to the order processing routine
                    Log::info("Processing row: " . $row);
                    $map = array();
                    $c = 0;
                    foreach($header as $key) {
                        if (isset($data[$c])) {
                            $map[$key] = $data[$c];
                        } else {
                            $map[$key] = "";
                        }
                        $c++;
                    }

                    if (strcasecmp($partnerId, "MOVO") === 0 || strcasecmp($partnerId, "AHA") === 0) {
                        try {
                            $convertedData = OrderInput::convertMovoCSVInputToData($map);
                        } catch (Exception $e) {
                            $statusList[$count] = array('status' => '777', 'error_code'=>2047,'message' => 'Error 2047: The Ship On Date is in a bad format or more than two weeks away.');
                            break;
                        }
                    }

                    $status = $processor->processOffline($convertedData);
                    $statusList[$count] = $status;
                }
                $row++; $count++;
            }
            fclose($handle);
        }
        if($row === 0) {
            return $status;
        } else {
            return $statusList;
        }
    }

    private function processRetail($header, $fileName, $partnerId) {

        Log::info("Start processRetail ");
        // read and parse the csv file
        $processor=new Movo\Orders\ProcessOrder();
        $row = 0; $count = 0;
        $status = '';
        $statusList = array();
        if (($handle = fopen($fileName, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                Log::info("Reading Data " . $row);
                // validate the header row before processing
                if($row === 0) {
                    $valid = CsvValidation::validateHeaders($header, $data);
                    if ($valid === false) {
                        Log::info("Header validation false ");
                        $status = "The attached CSV file header was not in Retail Order format. You are likely mistakenly loaded a Movo formatted file as a Retail file.";
                        break;
                    } else {
                        Log::info("Retail Header validation true");
                        $row++;
                        continue;
                    }
                } else {

                    // Pass each row to the order processing routine
                    $map = array();
                    $c = 0;
                    foreach($header as $key) {
                        if (isset($data[$c])) {
                            Log::info("Data: " . $data[$c]);
                            $map[$key] = $data[$c];
                        } else {
                            $map[$key] = "";
                            Log::info("Missing data: " . $row . " :: " . $c);
                        }
                        $c++;
                    }

                    Log::info("Partner ID: " . $partnerId);
                    if (strcasecmp($partnerId, "RETAIL") === 0) {
                        try {
                            Log::info("Printing Array");
                            $this->print_array("PRINT ARRAY:", $map);
                            $convertedData = OrderInput::convertRetailCSVInputToData($map);
                            Log::info("Printing Converted Map");
                            $this->print_map("MAP", $convertedData);

                        } catch (Exception $e) {
                            $statusList[$count] = array('status' => '777', 'error_code'=>2047,'message' => 'Error 2047: The Ship On Date is in a bad format or more than 180 days away.<br/>' . $e->getMessage());
                            Log::info("Exception: " . $e->getMessage());
                            break;
                        }
                        $status = $processor->processOffline($convertedData);

                        if(is_array($status)) {
                            $this->print_array("Status Array", $status);
                        } else {
                            Log::info("Retail return status: " . $status);
                        }

                    } else {
                        $status = "Partner ID in column 1 needs to be 'RETAIL' and is set to: " . $partnerId;
                    }

                    $statusList[$count] = $status;
                }
                $row++; $count++;
            }
            fclose($handle);
        }
        if($row === 0) {
            return $status;
        } else {
            return $statusList;
        }
    }

/*
    public function processUploads()
    {

        $partnerId = Input::get("partner_id");
        $fileName = $this->backupCsvFile();

        $status = '';
        if (strcasecmp($partnerId,'STACK') == 0) {
            $status = $this->processStack($this->slackHeader, $fileName, $partnerId);
        } else if (strcasecmp($partnerId,'MOVO') == 0 || strcasecmp($partnerId,'AHA') == 0) {
            $status = $this->processPartner($this->movoHeader, $fileName, $partnerId);
        } else if (strcasecmp($partnerId,'RETAIL') == 0) {
            Log::info("Entering processRetail: ");
            $status = $this->processRetail($this->retailHeader, $fileName, $partnerId);
        }

        Log::info("Completed upload: " . $fileName);

        $stringArray = print_r($status, true);
        Log::info("Status: " . $stringArray);

        return View::make('admin.upload', [
            'statusList' => $status,
        ]);
    }
*/


    public function manualOrderEntry()
    {
        $processor=new Movo\Orders\ProcessOrder();
        Log::info("Entered Manual Order Entry");

        $input = Input::all();
        Log::info(print_r($input));

        $partnerId = $input["partner_id"];


        $unitID = $input['unitID']; // this is an array of skus Array ( [0] => 857458005022 [1] => 857458005060 [2] => 857458005084 [3] => 857458005121 [4] => [5] => [6] => [7] => [8] => [9] => )
        $quantities = $input['quantities'];            // [quantity] => Array ( [0] => 4 [1] => 4 [2] => 3 [3] => 5 [4] => 0 [5] => 0 [6] => 0 [7] => 0 [8] => 0 [9] => 0 )
        $prices = $input['price'];            //    [price] => Array ( [0] => 29.99 [1] => 5 [2] => 34.99 [3] => 5.50 [4] => [5] => [6] => [7] => [8] => [9] => )
        $items = array();
        $quantity = 0;
        for($i = 0; $i < 10; $i++) {
            if (isset($unitID[$i]) && strlen($unitID[$i]) > 9) {
                $quantity += $quantities[$i];
                $items[$i] = ['sku' => $unitID[$i], 'description' => Product::getNameBySKU($unitID[$i]), 'quantity' => $quantities[$i], 'price' => $prices[$i]];
            } else {
                break;
            }
        }

        $input['quantity'] = $quantity;
        $input['items'] = $items;
        $input['coupon'] = "";

        if (isset($input['shipping-state-input']) && strlen($input['shipping-state-input']) > 1) {
            $input['shipping-state'] = $input['shipping-state-input'];
        }

        $processor->processOffline($input);

        $this->manual();

        //return View::make("admin.manual", [
        //    "michael" => "Michael",
        // ]);
    }

    public function print_array($title,$array){

        if(is_array($array)) {
            $size = sizeof($array);
            Log::info("Size: " . $size);

            $count = 0;
            Log::info("BEGIN " . $title . "||---------------------------------||" );
            foreach($array as $v) {
                $count++;
                if(is_null($v)) {
                    Log::info("Array value is NULL");
                } else if(isset($v)) {
                    if(is_array($v)) {
                        $this->print_array("SubArray", $v);
                    } else {
                        Log::info("value2: " . $v);
                    }

                } else {
                    Log::info("Array value is not set");
                }
                Log::info("Count: " + $count);
            }
        } else {
            echo $title." is not an array.";
        }

        Log::info("END ". $title . "||---------------------------------||");
    }

    public function print_map($title,$map){

            Log::info("BEGIN MAP " . $title . "||---------------------------------||\n");
            foreach($map as $k => $v) {
                if(isset($k) && isset($v)) {
                    if(is_array($v)) {
                        $this->print_map($k,$v);
                    } else {
                        Log::info($k . "=>" .$v);
                    }
                } else {
                    Log::info("Map value is not set");
                }
            }
            Log::info( "END ".$title."||---------------------------------||\n");

    }

}