<?php

class AdminController extends \BaseController {


	public function index()
	{
		return View::make("admin.index");
	}
	public function orders()
	{
		return View::make("admin.orders",[
			'orders'=>Order::orderBy("created_at", "DESC")->paginate(15)
		]);
	}

	public function coupons()
	{
		return View::make("admin.coupons",[

		]);
	}
	public function getStats()
	{
		$orderCount=DB::table('orders')->count();
		$stats['orderCount']=$orderCount;
		return $stats;
	}
	public function login(){
		return View::make("admin.login");
	}

	public function attemptLogin(){
		if (Auth::validate(array('name' => Input::get("name"), 'password' =>  Input::get("password")), true))
		{
			Session::put('admin', 'true');
			return Redirect::to('/admin');

		} else{
			return Redirect::to('/admin/login')->with("global", "Please enter valid login information");
		}
	}
}