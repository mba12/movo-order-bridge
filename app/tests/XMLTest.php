<?php

use SoapBox\Formatter\Formatter;

class XMLTest extends TestCase
{

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


    public function test_it_should_receive_order_status_xml_and_parse_results()
    {


        $test=File::get(base_path()."\\app\\tests\\sample-order-status.xml");
        $this->client->request('POST', 'http://movo.app:8000/ingram/order-status', ["data"=>$test] );
        echo $this->client->getResponse();
        $this->assertResponseOk();
    }
    public function test_it_should_receive_order_rejection_and_update_order()
    {

        $order=DB::table('orders')->first();
        $chargeID=$order->stripe_charge_id;
        DB::table('orders')->where('stripe_charge_id', $chargeID)->update([
            "error_flag" => 3,
            "ingram_order_id" => ""
        ]);

        $test=File::get(base_path()."\\app\\tests\\sample-order-status.xml");
        $formatter = Formatter::make($test, Formatter::XML);
        $obj = $formatter->toArray();
        $obj['sales-order-rejection']['header']['customer-id']=$chargeID;
        $obj['transactionInfo']['eventID']="129620978";
        $formatter = Formatter::make($obj, Formatter::ARR);
        $xml = $formatter->toXml();
        $this->client->request('POST', 'http://movo.app:8000/ingram/order-status', ["data"=>$xml] );
        echo $this->client->getResponse();
        $this->assertResponseOk();

        $order=DB::table('orders')->first();
        $this->assertEquals($order->ingram_order_id,"129620978");
        $this->assertEquals($order->error_flag,3);

        DB::table('orders')->where('stripe_charge_id', $chargeID)->update([
            "error_flag" => "",
            "ingram_order_id" => ""
        ]);
    }

    public function test_it_should_receive_inventory_xml_and_parse_results()
    {
        $test=File::get(base_path()."\\app\\tests\\sample-inventory.xml");
        $this->client->request('POST', 'http://movo.app:8000/ingram/track-inventory', ["data"=>$test] );
        echo $this->client->getResponse();
        $this->assertResponseOk();
    }

    public function test_it_should_save_the_inventory_xml_in_the_table(){
        $columns = Schema::getColumnListing('inventory_sync');
        for ($i = 0; $i < sizeof($columns); $i++) {
             echo '"'.$columns[$i].'" =>$data["'.$columns[$i].'"];';
        }
        //dd($columns);

    }
}
