<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCharityCalculationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('charity_calculations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('item_sku');
			$table->integer('campaign_id')->unsigned();
			$table->datetime('start_date');
			$table->datetime('end_date');
			$table->string('calculation_type');
			$table->double('percent_amt');
			$table->double('fixed_amt');
			$table->timestamps();
		});

		Schema::table('charity_calculations', function($table) {
			$table->foreign('campaign_id')->unsigned()->references('id')->on('campaigns')->onDelete('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('charity_calculations');
	}

}
