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
                                'Shipping-Type','First','Last','Email Address',
                                'Telephone','Shipping Address 1','Shipping Address 2','Shipping Address 3','City',
                                'State','Zip',
                                'X-Small-Qty','Small-Qty','Medium-Qty','Large-Qty','X-Large-Qty',
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
        Log::info("Order stuff: " . $order->shipping_first_name . " : " . $order->shipping_last_name);

        // $combinedItems = $order->combineAndCountItems($order->items()->all());
        $combinedItems = $order->combineAndCountItems($order->items()->getResults());

        return View::make("admin.order-details", [
            'order' => $order,
            'shipping' => Shipping::find($order->shipping_type),
            'combinedItems' => $combinedItems,
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

        $waves=Product::waves();
        $loops=Product::loops();
        $charities=Charity::getList();
        $unitPrice = $waves[0]->price;
        $shippingInfo = Shipping::getShippingMethodsAndPrices();
        $shippingDropdownData = ShippingDropdown::createData($shippingInfo);
        $sizeInfo = $waves;
        $stateTaxMethods = Tax::getStateTaxMethods();
        $coupon = null;
        $code = Input::get("code");
        if ($code) {
            $coupon = Coupon::where("code", "=", $code)->first();
        }

        return View::make('admin.manual', [
            'shippingDropdownData' => $shippingDropdownData,
            'unitPrice' => $unitPrice,
            'sizeInfo' => $sizeInfo,
            'coupon' => $coupon,
            'stateTaxMethods' => $stateTaxMethods,
            'after3pm' => strtotime("03:00 pm") - time() < 0,
            'loops'=>$loops,
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

    public function processUploads()
    {

        $partnerId = Input::get("partner_id");
        $fileName = $this->backupCsvFile();

        $status = '';
        if (strcasecmp($partnerId,'STACK') == 0) {
            $status = $this->processStack($this->slackHeader, $fileName, $partnerId);
        } else if (strcasecmp($partnerId,'MOVO') == 0) {
            $status = $this->processPartner($this->movoHeader, $fileName, $partnerId);
        }

        Log::info("Completed upload: " . $fileName);
        $filename = "Saved file";
        return View::make('admin.upload', [
            'status' => $status,
            'filename'=>$filename
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

        $timeString = date('YmdHms');

        // go to the storage uploads directory
        $fileName = 'upload.' . $timeString;

        // move the csv file into storage before processing
        // give it a new name based on a timestamp
        Input::file('file')->move($folder, $fileName);

        return $folder . '/' . $fileName;
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
        $row = 0;
        $status = '';
        if (($handle = fopen($fileName, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                // validate the header row before processing
                if($row === 0) {
                    $valid = CsvValidation::validateHeaders($header, $data);
                    if ($valid === false) {
                        Log::info("Header validation false ");
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

                    $map['partner_id'] = $partnerId;
                    if(strcasecmp($partnerId, "STACK") == 0) {
                        $map['shipping-type'] = "2";
                        $convertedData = OrderInput::convertStackCSVInputToData($map);

                        // If a return then skip and continue
                        if (isset($data['Refunded - Do Not Ship']) && length($data['Refunded - Do Not Ship']) > 0) {
                            $row++;
                            continue;
                        }

                    } else if (strcasecmp($partnerId, "MOVO") == 0) {
                        $convertedData = OrderInput::convertMovoCSVInputToData($map);
                    }

                    $status = $processor->processOffline($convertedData);
                    // TODO: check the status and see if there was an error

                    Log::info("Processing status: " . $status);
                }
                $row++;
            }
            fclose($handle);
        }

        return $status;

    }


    public function manualOrderEntry()
    {
        return View::make("admin.manual", [
            "michael" => "Michael",
        ]);
    }
}