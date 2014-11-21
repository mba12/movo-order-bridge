<?php

class AdminController extends \BaseController
{

    public function index()
    {
        return View::make("admin.index", [
        ]);
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

    public function orderSearch()
    {
        if(Input::get("search")!=""){
            $searchResults=Order::where(Input::get("criteria"),"LIKE", "%".Input::get("search")."%")->get();
            return View::make("admin.orders", [
                'orders' => $this->getOrderPagination(),
                'searchResults'=>$searchResults
            ]);
        }

        return Redirect::route("admin-orders");
    }

    public function getStats()
    {
        $orderCount = DB::table('orders')->count();
        $stats['orderCount'] = $orderCount;
        $errorCount = DB::table('orders')->where('error_flag', '>=', 1)->count();
        $stats['orderCount'] = $orderCount;
        $stats['errorCount'] = $errorCount;
        return $stats;
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