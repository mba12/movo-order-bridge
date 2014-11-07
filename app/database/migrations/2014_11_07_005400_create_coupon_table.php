<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponTable extends Migration {

	public function up()
	{
		Schema::create('coupons', function ($table) {
			$table->increments('id');
			$table->timestamps();
		});
	}


	public function down()
	{
		Schema::drop('coupons');
	}
}
