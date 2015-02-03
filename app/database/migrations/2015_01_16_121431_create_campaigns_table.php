<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCampaignsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('campaigns', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('partner_id')->unsigned();
			$table->string('name');
			$table->string('description');
			$table->boolean('active');
			$table->datetime('start_date');
			$table->datetime('end_date');
			$table->timestamps();
		});

		Schema::table('campaigns', function($table) {
			$table->foreign('partner_id')->unsigned()->references('id')->on('charity_partners')->onDelete('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('campaigns');
	}

}
