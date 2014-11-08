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
			$table->integer('shipping_type')->nullable();
			$table->string('sizes')->nullable();

			$table->string('billing_first_name')->nullable();
			$table->string('billing_last_name')->nullable();
			$table->string('billing_address')->nullable();
			$table->string('billing_city')->nullable();
			$table->string('billing_state')->nullable();
			$table->string('billing_country')->nullable();
			$table->string('billing_zip')->nullable();
			$table->string('billing_phone')->nullable();

			$table->string('shipping_first_name')->nullable();
			$table->string('shipping_last_name')->nullable();
			$table->string('shipping_address')->nullable();
			$table->string('shipping_city')->nullable();
			$table->string('shipping_state')->nullable();
			$table->string('shipping_country')->nullable();
			$table->string('shipping_zip')->nullable();
			$table->string('shipping_phone')->nullable();

			$table->string('email')->nullable();

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
