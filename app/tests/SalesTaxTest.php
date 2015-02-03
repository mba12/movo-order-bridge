<?php

use Movo\SalesTax\SalesTax;

class SalesTaxTests extends TestCase
{

    public function tearDown()
    {
        Mockery::close();
    }

    public function test_it_applies_tax_to_shipping_if_state_in_list()
    {
        $tax = new SalesTax();
        $salesTax=$tax->calculateTotalTax(100,2,.10,"NY");
        $this->assertEquals($salesTax, 10.20);
    }

    public function test_it_does_not_apply_tax_to_shipping_if_state_not_in_list()
    {
        $tax = new SalesTax();
        $salesTax=$tax->calculateTotalTax(100,2,.10,"CA");
        $this->assertEquals($salesTax, 10.00);
    }
}
