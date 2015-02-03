<?php

use Movo\Billing\StripeBilling;
use Movo\Orders\CalculateOrderTotal;
use Movo\Orders\SaveOrderDetails;

class OrderTotalTests extends TestCase
{

    public $processOrder;

    public function tearDown()
    {
        Mockery::close();
    }

    public function test_it_should_calculate_a_coupon_into_total_and_use_shipping_in_tax()
    {
        $processOrder = new \Movo\Orders\ProcessOrder();
        Input::replace(['token' => 'a-token-here']);
        $data = [];
        $shippingMethod = new Shipping();
        $shippingMethod->rate = 12;
        $coupon = new Coupon();
        $coupon->method = "$";
        $coupon->amount = "10";
        $data = $processOrder->populateDataWithOrderAmounts($data, 29.99, 0, $shippingMethod, 0.08875, "NY", $coupon);
        $this->assertNotEmpty($data);
        $this->assertEquals($data['amount'], 45.72);
        $this->assertEquals($data['order-total'], 45.72);
        echo json_encode($data);
    }

    public function test_it_should_calculate_a_coupon_into_total_and_use_shipping_in_tax_with_loops()
    {
        $processOrder = new \Movo\Orders\ProcessOrder();
        Input::replace(['token' => 'a-token-here']);
        $data = [];
        $shippingMethod = new Shipping();
        $shippingMethod->rate = 5.75;
        $coupon = new Coupon();
        $coupon->method = "$";
        $coupon->amount = "10";
        $data = $processOrder->populateDataWithOrderAmounts($data, 39.99, 0, $shippingMethod, 0.08875, "NY", $coupon);
        echo json_encode($data);
        $this->assertNotEmpty($data);
        $this->assertEquals($data['amount'], 49.8);
        $this->assertEquals($data['order-total'], 49.8);
    }


    public function test_it_should_calculate_item_totals()
    {
        $item = [
            "sku" => "12345",
            "description" => "foo",
            "quantity" => "2",
            "price" => "29.99",
        ];

        $data = [
            "tax" => "5.3232248391211",
            "amount" => "65.30",
            "total-unit-prices" => "89.97",
            "description" => "foo",
            "quantity" => "2",
            "discount" => "12",
            'shipping-rate' => "5.75"
        ];

        $data['items'] = [$item];
        $updatedItem = SaveOrderDetails::saveOrderItemPercentages($item, $data);
        $this->assertEquals($updatedItem['tax'], $data['tax'] / 3 * $item['quantity']);
        $this->assertEquals($updatedItem['discount'], $data['discount'] / 3 * $item['quantity']);
        echo json_encode($updatedItem);
    }

    public function test_it_should_return_a_result()
    {
        $result = CalculateOrderTotal::calculateTotal([
            "quantity" => 1,
            "tax-rate" => 0.088749997317791,
            "total-unit-prices" => 29.99,
            "state" => "NY",
            "shipping-rate" => 12,
            "discount" => 6,
        ]);
        $this->assertNotEmpty($result);
    }

    public function test_it_should_add_tax_to_total()
    {
        $result = CalculateOrderTotal::calculateTotal([
            "tax-rate" => .10,
            "total-unit-prices" => 300,
            "state" => "CA",
            "shipping-rate" => 10,
            "discount" => 0,
        ]);
        $this->assertEquals($result, 340);
    }

    public function test_it_should_add_tax_to_shipping_if_in_list()
    {
        $result = CalculateOrderTotal::calculateTotal([
            "tax-rate" => .10,
            "total-unit-prices" => 300,
            "state" => "NY",
            "shipping-rate" => 10,
            "discount" => 0,
        ]);
        $this->assertEquals($result, 341);
    }

    public function test_it_should_add_tax_to_shipping_if_in_list_and_has_discount()
    {
        $result = CalculateOrderTotal::calculateTotal([
            "tax-rate" => .088,
            "total-unit-prices" => 29.99,
            "state" => "NY",
            "shipping-rate" => 12,
            "discount" => 6,
        ]);
        $this->assertEquals($result, 39.15712);
    }

    public function test_it_should_round_result_down()
    {
        $result = StripeBilling::convertAmountToCents(39.184112403467);

        $this->assertEquals($result, 3918);
    }

    public function test_it_should_round_result_up()
    {
        $result = StripeBilling::convertAmountToCents(39.185112403467);

        $this->assertEquals($result, 3919);
    }
}
