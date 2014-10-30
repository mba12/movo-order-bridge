<?php

use Illuminate\Support\Facades\App;



class OrderController extends BaseController {
	public function showForm()
	{
		return View::make('order-form');
	}

	public function buy(){
		$billing=App::make('Movo\Billing\BillingInterface');
		$result= $billing->charge([
		  'email'=>'alex@jumpkick.pro',
		  'token'=>Input::get("token"),
		]);

		switch($result){
			case 1:
				return "The charge went through";
				break;
			case 2:
				return "The charge did not go through";
				break;
			case 3:
				return "The charge did not go through";
				break;
			default:

		}

	}

}
