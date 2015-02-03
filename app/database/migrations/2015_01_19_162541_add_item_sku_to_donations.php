<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddItemSkuToDonations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('donations', function(Blueprint $table)
		{
			$table->dropColumn('item_id');
			$table->string('item_sku');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('donations', function(Blueprint $table)
		{
			$table->dropColumn('item_sku');
			$table->integer('item_id');
		});
	}

}
