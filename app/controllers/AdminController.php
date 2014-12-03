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

    public function orderDetails($id)
    {
        $order=Order::find($id);
        $skus= explode("|",$order->sizes);
        $sizes=Size::getUnitSizes();
        $items=[];
        foreach($skus as $sku){
            foreach($sizes as $size){
               if($size->sku==$sku){
                   $items[]=$size->name;
               }
            }
        }

        return View::make("admin.order-details", [
            'order' => $order,
            'items' =>$items,
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