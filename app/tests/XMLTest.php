<?php

use SoapBox\Formatter\Formatter;

class XMLTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();


    }
    public function tearDown()
    {
        Mockery::close();
    }

    public function test_it_should_receive_returns_xml_and_parse_results()
    {
        $test=File::get(base_path()."\\app\\tests\\sample-returns.xml");
        $this->client->request('POST', 'http://movo.app:8000/ingram/returns', ["data"=>$test] );
        echo $this->client->getResponse();
        $this->assertResponseOk();
    }

    public function test_it_should_receive_shipping_xml_and_parse_results()
    {
        $test=File::get(base_path()."\\app\\tests\\sample-shipping.xml");
        $this->client->request('POST', 'http://movo.app:8000/ingram/ship-advice', ["data"=>$test] );
        echo $this->client->getResponse();
        $this->assertResponseOk();
    }


    public function test_it_should_receive_order_rejection_and_update_order()
    {

        $order=new Order();
        $order->stripe_charge_id="test_id".rand();
        $order->email="test@test.com";
        $chargeID=$order->stripe_charge_id;
        $order->save();
        $orderID=$order->id;

        $test=File::get(base_path()."\\app\\tests\\sample-order-status.xml");
        $test=str_replace("286104", $chargeID,$test);

        $client = new GuzzleHttp\Client();
        $response = $client->post('http://movo.app:8000/ingram/order-status', [
            'body' =>$test
        ]);
        $order=Order::find($orderID);
        $this->assertTrue(strpos(json_encode($response->xml()), "SUCCESS") !== FALSE);
        $this->assertEquals($order->ingram_order_id,"129620978");
        $this->assertEquals($order->error_flag,3);
    }

    public function test_it_should_receive_inventory_xml_and_parse_results()
    {
        $randomID= rand();
        $test=File::get(base_path()."\\app\\tests\\sample-inventory.xml");
        $test=str_replace("275484714", $randomID,$test);

        $client = new GuzzleHttp\Client();
        $response = $client->post('http://movo.app:8000/ingram/track-inventory', [
            'body' =>$test
            ]);
        $this->assertTrue(strpos(json_encode($response->xml()), "SUCCESS") !== FALSE);
        $inventorySync=InventorySync::where("message_id", "=", $randomID);
        $this->assertGreaterThan(0, $inventorySync->count());
    }

    public function test_it_should_save_the_inventory_xml_in_the_table(){
        $columns = Schema::getColumnListing('inventory_sync');
        for ($i = 0; $i < sizeof($columns); $i++) {
             echo '"'.$columns[$i].'" =>$data["'.$columns[$i].'"];';
        }
        //dd($columns);

    }
}
