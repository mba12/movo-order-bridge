<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStandardResponseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('standard_response', function(Blueprint $table)
		{
			$table->string('message_id', 30)->nullable();
			$table->string('transaction_name', 30)->nullable();
			$table->string('partner_name', 30)->nullable();
			$table->string('partner_password', 30)->nullable();
			$table->string('source_url')->nullable();
			$table->string('create_timestamp', 40)->nullable();
			$table->string('response_request', 40)->nullable();
			$table->integer('status_code')->nullable();
			$table->string('status_description')->nullable();
			$table->string('comments')->nullable();
			$table->string('response_timestamp', 40)->nullable();
			$table->string('filename', 40)->nullable();
			$table->string('eventID', 100)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('standard_response');
	}

}
