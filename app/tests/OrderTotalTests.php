<?php

class OrderTotalTests extends TestCase
{

    public function tearDown()
    {
        Mockery::close();
    }

    public function test_it_should_return_a_result()
    {
        $result = Order::calculateTotal([
            "quantity"=>3,
            "tax-rate"=>.10,
            "unit-price"=>29.99,
            "state"=>"CA",
            "shipping-rate"=>5.99,
            "discount"=>5,
         ]);
        $this->assertNotEmpty($result);
    }
    public function test_it_should_add_tax_to_total()
    {
        $result = Order::calculateTotal([
            "quantity"=>3,
            "tax-rate"=>.10,
            "unit-price"=>100,
            "state"=>"CA",
            "shipping-rate"=>10,
            "discount"=>0,
        ]);
        $this->assertEquals($result, 340);
    }

    public function test_it_should_add_tax_to_shipping_if_in_list()
    {
        $result = Order::calculateTotal([
            "quantity"=>3,
            "tax-rate"=>.10,
            "unit-price"=>100,
            "state"=>"NY",
            "shipping-rate"=>10,
            "discount"=>0,
        ]);
        $this->assertEquals($result, 341);
    }
}
