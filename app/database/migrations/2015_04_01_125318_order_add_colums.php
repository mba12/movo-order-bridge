<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderAddColums extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//

        Schema::table('orders', function($table)
        {
            $table->string('partner_id', 20);
            $table->string('partner_order_id', 30);
            $table->string('shipping_address2', 50)->after('shipping_address');
            $table->string('shipping_address3', 50)->after('shipping_address2');
            $table->string('billing_address2', 50)->after('billing_address');
            $table->string('billing_address3', 50)->after('billing_address2');
            $table->string('notes', 50);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('orders', function(Blueprint $table) {
            $table->dropColumn('partner_id');
            $table->dropColumn('partner_order_id');
            $table->dropColumn('shipping_address2');
            $table->dropColumn('shipping_address3');
            $table->dropColumn('billing_address2');
            $table->dropColumn('billing_address3');
            $table->dropColumn('notes');
        });
	}

}
