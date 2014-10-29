<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function ($table) {
			$table->increments('id');
			$table->integer('amount');
			$table->integer('quantity');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('address_1');
			$table->string('address_2');
			$table->string('city');
			$table->string('state');
			$table->string('zip');
			$table->string('country');
			$table->string('phone');
			$table->string('email');
			$table->string('shipping_service');
			$table->integer('charged');
			$table->integer('shipped');
			$table->string('tracking_code');
			$table->string('error_flag');
			$table->datetime('order_date');
			$table->datetime('fulfilment_date');
			$table->timestamps();
		});
	}
	public function down()
	{
		Schema::drop('users');
	}

}
