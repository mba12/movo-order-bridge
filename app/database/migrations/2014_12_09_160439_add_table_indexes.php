<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableIndexes extends Migration {

	public function up()
	{
		Schema::table('coupon_instances', function (Blueprint $table) {
			$table->index(['code',"token", "used"]);
		});

		Schema::table('orders', function (Blueprint $table) {
			$table->index(['billing_first_name']);
			$table->index(['billing_last_name']);
			$table->index(['billing_address']);
			$table->index(['billing_phone']);
			$table->index(['shipping_first_name']);
			$table->index(['shipping_last_name']);
			$table->index(['shipping_address']);
			$table->index(['shipping_phone']);
			$table->index(['stripe_charge_id']);
			$table->index(['email']);
			$table->index(['error_flag']);
		});

		Schema::table('items', function (Blueprint $table) {
			$table->index(['order_id']);
		});

	}

	public function down()
	{
		Schema::table('coupon_instances', function (Blueprint $table) {
			$table->dropIndex('coupon_instances_code_token_used_index');
		});

		Schema::table('orders', function (Blueprint $table) {
			$table->dropIndex('orders_billing_first_name_index');
			$table->dropIndex('orders_billing_last_name_index');
			$table->dropIndex('orders_billing_address_index');
			$table->dropIndex('orders_billing_phone_index');
			$table->dropIndex('orders_shipping_first_name_index');
			$table->dropIndex('orders_shipping_last_name_index');
			$table->dropIndex('orders_shipping_address_index');
			$table->dropIndex('orders_shipping_phone_index');
			$table->dropIndex('orders_stripe_charge_id_index');
			$table->dropIndex('orders_email_index');
			$table->dropIndex('orders_error_flag_index');
		});

		Schema::table('items', function (Blueprint $table) {
			$table->dropIndex('items_order_id_index');
		});
	}

}
