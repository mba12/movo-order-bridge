<?php

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

    private function getStatsArray(){
        $coupons = Coupon::all();
        $couponCounts=[];
        foreach($coupons as $coupon){
            $couponCounts[]=$coupon->usedCoupons()->count();
        }
        $lastHour=$this->order->lastHour()->count();
        $lastDay=$this->order->lastDay()->count();
        $lastWeek=$this->order->lastWeek()->count();
        $lastMonth=$this->order->lastMonth()->count();
        $errors=$this->order->errors()->count();
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
        $order=Order::find($id);


        return View::make("admin.order-details", [
            'order' => $order,
            'shipping'=>Shipping::find($order->shipping_type)
        ]);
    }

    public function orderSearch()
    {
        if(Input::get("search")!=""){
            $searchResults=Order::where(Input::get("criteria"),"LIKE", "%".Input::get("search")."%")->paginate(15);
            return View::make("admin.search-results", [
                'orders'=>$searchResults
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
        return Order::orderBy("created_at", "DESC")->paginate(15);
    }


}