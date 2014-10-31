<?php

use Illuminate\Support\Facades\App;



class OrderController extends BaseController {
	public function showForm()
	{
		return View::make('order-form');
	}

	public function buy(){

		$billing=App::make('Movo\Billing\BillingInterface');
		$shipping=App::make('Movo\Shipping\ShippingInterface');
		$receipt=App::make('Movo\Receipts\ReceiptsInterface');
		$result= $billing->charge([
		  'email'=>'alex@jumpkick.pro',
		  'token'=>Input::get("token"),
		]);

		if($result){
			$shipping->ship([
				'result'=>$result
			]);
			$this->saveOrder($result);
			$receipt->send(["result"=>$result]);
			return "The charge went through";
		}else{
			return "The charge did not go through";

		}
	}

	private function saveOrder($result)
	{
		$order=new Order();
		$order->saveOrder($result['amount'], $result['id']);
	}
}
