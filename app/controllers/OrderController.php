<?php

use Illuminate\Support\Facades\App;



class OrderController extends BaseController {
	public function showForm()
	{
		return View::make('order-form');
	}

	public function buy(){
		$billing=App::make('Movo\Billing\BillingInterface');
		return $billing->charge([
		  'email'=>'alex@jumpkick.pro',
		  'token'=>Input::get("token"),
		]);
	}

}
