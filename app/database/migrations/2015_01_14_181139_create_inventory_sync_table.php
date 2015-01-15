<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInventorySyncTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inventory_sync', function(Blueprint $table)
		{
			$table->string('message_id', 30)->nullable();
			$table->string('transaction_name', 30)->nullable();
			$table->string('partner_name', 30)->nullable();
			$table->string('partner_password', 30)->nullable();
			$table->string('source_url')->nullable();
			$table->string('create_timestamp', 40)->nullable();
			$table->string('response_request', 40)->nullable();
			$table->string('customer_id', 30)->nullable();
			$table->string('business_name', 30)->nullable();
			$table->string('line_no', 20)->nullable();
			$table->string('transaction_document_number', 20)->nullable();
			$table->string('item_code', 20)->nullable();
			$table->string('universal_product_code', 30)->nullable();
			$table->string('warehouse_id', 20)->nullable();
			$table->string('unit_of_measure', 20)->nullable();
			$table->decimal('quantity_on_hand', 10)->nullable();
			$table->decimal('quantity_committed', 10)->nullable();
			$table->decimal('quantity_available', 10)->nullable();
			$table->decimal('quantity_on_back_order', 10)->nullable();
			$table->string('synchronization_timestamp', 30)->nullable();
			$table->string('comments', 40)->nullable();
			$table->string('eventID', 40)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('inventory_sync');
	}

}
