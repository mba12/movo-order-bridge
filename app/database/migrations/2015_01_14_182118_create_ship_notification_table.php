<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShipNotificationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ship_notification', function(Blueprint $table)
		{
			$table->string('message_id', 30)->nullable();
			$table->string('transaction_name', 30)->nullable();
			$table->string('partner_name', 30)->nullable();
			$table->string('partner_password', 30)->nullable();
			$table->string('source_url')->nullable();
			$table->string('create_timestamp', 40)->nullable();
			$table->string('response_request', 40)->nullable();
			$table->string('customer_id', 30)->nullable();
			$table->string('business_name', 40)->nullable();
			$table->string('carrier_name', 20)->nullable();
			$table->string('ultimate_destination_code', 30)->nullable();
			$table->integer('packing_list_number')->nullable();
			$table->string('release_number', 20)->nullable();
			$table->string('customer_first_name', 30)->nullable();
			$table->string('customer_last_name', 30)->nullable();
			$table->string('customer_middle_initial', 3)->nullable();
			$table->string('customer_address1', 100)->nullable();
			$table->string('customer_address2', 100)->nullable();
			$table->string('customer_address3', 100)->nullable();
			$table->string('customer_city', 50)->nullable();
			$table->string('customer_state', 50)->nullable();
			$table->string('customer_post_code', 15)->nullable();
			$table->string('customer_country_code', 10)->nullable();
			$table->string('customer_phone1', 30)->nullable();
			$table->string('customer_phone2', 30)->nullable();
			$table->string('customer_fax', 30)->nullable();
			$table->string('customer_email', 50)->nullable();
			$table->string('ship_first_name', 25)->nullable();
			$table->string('ship_last_name', 25)->nullable();
			$table->string('ship_middle_initial', 3)->nullable();
			$table->string('ship_address1', 50)->nullable();
			$table->string('ship_address2', 50)->nullable();
			$table->string('ship_address3', 50)->nullable();
			$table->string('ship_city', 50)->nullable();
			$table->string('ship_state', 50)->nullable();
			$table->string('ship_post_code', 20)->nullable();
			$table->string('ship_country_code', 10)->nullable();
			$table->string('ship_phone1', 20)->nullable();
			$table->string('ship_phone2', 20)->nullable();
			$table->string('ship_fax', 20)->nullable();
			$table->string('ship_email', 50)->nullable();
			$table->string('ship_via', 20)->nullable();
			$table->string('ship_request_date', 12)->nullable();
			$table->string('ship_request_from', 12)->nullable();
			$table->string('ship_request_warehouse', 20)->nullable();
			$table->string('purchase_order_number', 20)->nullable();
			$table->string('account_description', 20)->nullable();
			$table->decimal('purchase_order_amount', 10)->nullable();
			$table->string('currency_code', 10)->nullable();
			$table->string('comments', 50)->nullable();
			$table->string('credit_card_number', 1)->nullable();
			$table->string('credit_card_expiration_date', 1)->nullable();
			$table->string('credit_card_identification', 1)->nullable();
			$table->string('global_card_classification_code', 1)->nullable();
			$table->string('card_holder_name', 1)->nullable();
			$table->string('card_holder_address1', 1)->nullable();
			$table->string('card_holder_address2', 1)->nullable();
			$table->string('card_holder_city', 1)->nullable();
			$table->string('card_holder_state', 1)->nullable();
			$table->string('card_holder_post_code', 1)->nullable();
			$table->string('card_holder_country_code', 1)->nullable();
			$table->string('invoice_number', 30)->nullable();
			$table->string('invoice_creation_date', 12)->nullable();
			$table->string('terms_due_days', 5)->nullable();
			$table->string('invoice_expiration_date', 12)->nullable();
			$table->decimal('terms_discount_percentage', 5)->nullable();
			$table->string('terms_discount_due_days', 30)->nullable();
			$table->string('terms_discount_expiration_date', 30)->nullable();
			$table->string('terms_description', 20)->nullable();
			$table->decimal('invoice_amount', 10)->nullable();
			$table->decimal('invoice_discount', 10)->nullable();
			$table->string('customer_order_number', 20)->nullable();
			$table->string('customer_order_date', 12)->nullable();
			$table->string('order_reference', 20)->nullable();
			$table->decimal('order_sub_total', 10)->nullable();
			$table->decimal('order_discount', 10)->nullable();
			$table->decimal('order_tax1', 10)->nullable();
			$table->decimal('order_tax2', 10)->nullable();
			$table->decimal('order_tax3', 10)->nullable();
			$table->decimal('order_shipment_charge', 10)->nullable();
			$table->decimal('order_total_net', 10)->nullable();
			$table->string('order_status', 12)->nullable();
			$table->string('order_type', 12)->nullable();
			$table->string('customer_channel_type', 10)->nullable();
			$table->string('customer_group_account', 15)->nullable();
			$table->string('customer_seller_code', 10)->nullable();
			$table->string('user_name', 20)->nullable();
			$table->string('gift_flag', 3)->nullable();
			$table->string('brightpoint_order_number', 20)->nullable();
			$table->string('warehouse_id', 10)->nullable();
			$table->string('ship_date', 12)->nullable();
			$table->string('ship_to_code', 20)->nullable();
			$table->string('line_no', 5)->nullable();
			$table->string('line_reference', 5)->nullable();
			$table->string('item_code', 10)->nullable();
			$table->string('universal_product_code', 20)->nullable();
			$table->string('product_name', 30)->nullable();
			$table->decimal('ship_quantity', 10)->nullable();
			$table->string('packs', 30)->nullable();
			$table->string('internal_packs', 30)->nullable();
			$table->string('unit_of_measure', 20)->nullable();
			$table->string('sid', 10)->nullable();
			$table->string('irdb', 10)->nullable();
			$table->string('market_id', 10)->nullable();
			$table->string('line_status', 10)->nullable();
			$table->decimal('base_price')->nullable();
			$table->decimal('line_discount')->nullable();
			$table->decimal('line_tax1')->nullable();
			$table->decimal('line_tax2')->nullable();
			$table->decimal('line_tax3')->nullable();
			$table->string('bill_of_lading', 20)->nullable();
			$table->string('pallet_id', 10)->nullable();
			$table->string('scac', 20)->nullable();
			$table->string('routing_description', 20)->nullable();
			$table->string('container_id', 20)->nullable();
			$table->string('ownership_flag', 10)->nullable();
			$table->string('special_message1', 30)->nullable();
			$table->string('special_message2', 30)->nullable();
			$table->string('special_message3', 30)->nullable();
			$table->string('special_message4', 30)->nullable();
			$table->string('special_message5', 30)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ship_notification');
	}

}
