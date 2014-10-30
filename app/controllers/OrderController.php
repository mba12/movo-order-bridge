<?php

class OrderController extends BaseController {
	public function showForm()
	{
		return View::make('order-form');
	}

	public function buy(){
		dd(Input::all());
	}

}
