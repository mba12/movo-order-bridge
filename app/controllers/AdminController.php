<?php

use Movo\Shipping\ShippingDropdown;

class AdminController extends \BaseController
{

    private $order;

    function __construct(Order $order)
    {
        $this->order = $order;
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




    public function manualorderentry()
    {
        return View::make("admin.manual", [
            "michael" => "Michael",
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
        $order = Order::find($id);
        $combinedItems = $order->combineAndCountItems($order->items()->all());
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

    public function manualOrderEntry()
    {
        return View::make("admin.manual", [
            "michael" => "Michael",
        ]);
    }
}