<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEmailConfirm extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::table('verify', function(Blueprint $table) {
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->string('full_name', 100)->nullable();
        });

    }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('verify', function(Blueprint $table) {
            $table->dropColumn('full_name');
            $table->string('first_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
        });

    }

}
