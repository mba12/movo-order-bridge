<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponTable extends Migration {

	public function up()
	{
		Schema::create('coupons', function ($table) {
			$table->increments('id');
			$table->string('name'); //friendly name for internal use
			$table->string('code',100); //coupon code
			$table->double('amount'); //how much to discount
			$table->string('method'); //percentage or dollars off
			$table->integer('limit'); //total number of uses
			$table->integer('min_units'); //minimum order to qualify for this discount
			$table->timestamps();
		});
	}


	public function down()
	{
		Schema::drop('coupons');
	}
}
