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
			$table->integer('amount')->nullable();
			$table->integer('quantity')->nullable();
			$table->string('sizes')->nullable();

			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();

			$table->string('shipping_address_1')->nullable();
			$table->string('shipping_address_2')->nullable();
			$table->string('shipping_city')->nullable();
			$table->string('shipping_state')->nullable();
			$table->string('shipping_zip')->nullable();
			$table->string('shipping_country')->nullable();

			$table->string('phone')->nullable();
			$table->string('email')->nullable();

			$table->string('shipping_service')->nullable();
			$table->string('stripe_charge_id')->nullable();
			$table->string('ingram_order_id')->nullable();
			$table->integer('status')->nullable();
			$table->string('tracking_code')->nullable();
			$table->string('error_flag')->nullable();
			$table->timestamps();
		});
	}
	public function down()
	{
		Schema::drop('orders');
	}

}
