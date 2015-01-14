<?php

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

    public function test_it_should_receive_inventory_xml_and_parse_results()
    {
        $test=File::get(base_path()."\\app\\tests\\sample-inventory.xml");
        $this->client->request('POST', 'http://movo.app:8000/ingram/track-inventory', ["data"=>$test] );
        echo $this->client->getResponse();
        $this->assertResponseOk();
    }
}
