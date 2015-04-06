<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTableName extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::rename('standard_response', 'standard_responses');
        Schema::table('orders', function($table) {
            $table->integer('order_id');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::rename('standard_responses', 'standard_response');
        Schema::table('orders', function(Blueprint $table) {
            $table->dropColumn('order_id');
        });

    }

}
