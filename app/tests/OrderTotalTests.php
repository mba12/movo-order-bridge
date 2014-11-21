<?php

use Movo\Billing\StripeBilling;

class OrderTotalTests extends TestCase
{

    public function tearDown()
    {
        Mockery::close();
    }

    public function test_it_should_return_a_result()
    {
        $result = Order::calculateTotal([
            "quantity"=>1,
            "tax-rate"=>0.088749997317791,
            "unit-price"=>29.99,
            "state"=>"NY",
            "shipping-rate"=>12,
            "discount"=>6,
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

    public function test_it_should_add_tax_to_shipping_if_in_list_and_has_discout()
    {
        $result = Order::calculateTotal([
            "quantity"=>1,
            "tax-rate"=>.088,
            "unit-price"=>29.99,
            "state"=>"NY",
            "shipping-rate"=>12,
            "discount"=>6,
        ]);
        $this->assertEquals($result, 39.15712);
    }

    public function test_it_should_round_result_down()
    {
        $result= StripeBilling::convertAmountToCents(39.184112403467);

        $this->assertEquals($result, 3918);
    }
}
