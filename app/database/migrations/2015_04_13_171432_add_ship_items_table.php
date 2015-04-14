<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShipItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// This is a sample of the XML item subset coming from Ingram
        /*
        <line-item>
            <line-no>1</line-no>
            <item-code>857458005022</item-code>
            <universal-product-code>857458005022</universal-product-code>
            <ship-quantity>1.0</ship-quantity>
            <unit-of-measure>EA</unit-of-measure>
            <line-status />
            <base-price>0.0</base-price>
            <bill-of-lading>074347380360313</bill-of-lading>
            <pallet-id>C45290070</pallet-id>
            <scac>FXG3</scac>
            <container-id>C45290070</container-id>
        */


        Schema::create('shipped_items', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('message_id');

            $table->integer('line_no')->nullable();
            $table->string('item_code', 30)->nullable();
            $table->string('universal_product_code', 50)->nullable();

            $table->string('ship_quantity', 10)->nullable();
            $table->string('unit_of_measure', 10)->nullable();
            $table->double('base_price')->nullable();

            $table->string('bill_of_lading', 40)->nullable();
            $table->string('pallet_id', 20)->nullable();
            $table->string('scac', 15)->nullable();
            $table->string('container_id', 20)->nullable();
            $table->timestamps();
        });

        Schema::table('ship_notification', function(Blueprint $table) {
            $table->dropColumn('order_id');
            $table->integer('order_number'); // NOT using order_id because eloquent will make that column a Primary KEY
        });

    }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('shipped_items');
        Schema::table('ship_notification', function(Blueprint $table) {
            $table->dropColumn('order_number');
            $table->integer('order_id', 20); // NOT using order_id because eloquent will make that column a Primary KEY
        });

    }


}
