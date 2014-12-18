<?php

class ValidationTests extends TestCase
{

    public function test_it_should_return_true_if_all_fields_are_present()
    {
        $data=
            array(
                'shipping-first-name' => "Joe",
                'shipping-last-name' => "Public",
                'shipping-address' => "1234 Oak",
                'shipping-city' => "Anytown",
                'shipping-zip' => "91065",
                'shipping-state' => "CA",
                'shipping-country' => "US",
                'shipping-phone' => "555-123-4567",
                'billing-first-name' => "Joe",
                'billing-last-name' => "Public",
                'billing-address' => "1234 Oak",
                'billing-city' => "Anytown",
                'billing-zip' => "00000",
                'billing-state' => "CA",
                'billing-country' => "US",
                'billing-phone' => "555-123-1234",
                'quantity' => 1,
                'email' => "foo@foo.com",
                'shipping-type' => 1,
                'items'=>[
                    [
                        "sku"=>"12345",
                        "description"=>"something here"
                    ]
                ]

            );

        $result=\Movo\Orders\OrderValidate::validate($data);
        $this->assertTrue($result);
    }

    public function test_it_should_return_false_if_quantity_and_items_do_not_match()
    {
        $data=
            array(
                'shipping-first-name' => "Joe",
                'shipping-last-name' => "Public",
                'shipping-address' => "1234 Oak",
                'shipping-city' => "Anytown",
                'shipping-zip' => "91065",
                'shipping-state' => "CA",
                'shipping-country' => "US",
                'shipping-phone' => "555-123-4567",
                'billing-first-name' => "Joe",
                'billing-last-name' => "Public",
                'billing-address' => "1234 Oak",
                'billing-city' => "Anytown",
                'billing-zip' => "00000",
                'billing-state' => "CA",
                'billing-country' => "US",
                'billing-phone' => "555-123-1234",
                'quantity' => 2,
                'email' => "foo@foo.com",
                'shipping-type' => 1,
                'items'=>[
                    [
                        "sku"=>"12345",
                        "description"=>"something here"
                    ]
                ]

            );

        $result=\Movo\Orders\OrderValidate::validate($data);
        $this->assertFalse($result);
    }

    public function test_it_should_return_false_if_sku_is_null()
    {
        $data=
            array(
                'shipping-first-name' => "Joe",
                'shipping-last-name' => "Public",
                'shipping-address' => "1234 Oak",
                'shipping-city' => "Anytown",
                'shipping-zip' => "91065",
                'shipping-state' => "CA",
                'shipping-country' => "US",
                'shipping-phone' => "555-123-4567",
                'billing-first-name' => "Joe",
                'billing-last-name' => "Public",
                'billing-address' => "1234 Oak",
                'billing-city' => "Anytown",
                'billing-zip' => "00000",
                'billing-state' => "CA",
                'billing-country' => "US",
                'billing-phone' => "555-123-1234",
                'quantity' => 1,
                'email' => "foo@foo.com",
                'shipping-type' => 1,
                'items'=>[
                    [
                        "sku"=>null,
                        "description"=>"something here"
                    ]
                ]

            );

        $result=\Movo\Orders\OrderValidate::validate($data);
        $this->assertFalse($result);
    }

    public function test_it_should_return_false_if_desctiption_is_null()
    {
        $data=
            array(
                'shipping-first-name' => "Joe",
                'shipping-last-name' => "Public",
                'shipping-address' => "1234 Oak",
                'shipping-city' => "Anytown",
                'shipping-zip' => "91065",
                'shipping-state' => "CA",
                'shipping-country' => "US",
                'shipping-phone' => "555-123-4567",
                'billing-first-name' => "Joe",
                'billing-last-name' => "Public",
                'billing-address' => "1234 Oak",
                'billing-city' => "Anytown",
                'billing-zip' => "00000",
                'billing-state' => "CA",
                'billing-country' => "US",
                'billing-phone' => "555-123-1234",
                'quantity' => 1,
                'email' => "foo@foo.com",
                'shipping-type' => 1,
                'items'=>[
                    [
                        "sku"=>"12345",
                        "description"=>null
                    ]
                ]

            );

        $result=\Movo\Orders\OrderValidate::validate($data);
        $this->assertFalse($result);
    }

    public function test_it_should_return_false_if_item_is_null()
    {
        $data=
            array(
                'shipping-first-name' => "Joe",
                'shipping-last-name' => "Public",
                'shipping-address' => "1234 Oak",
                'shipping-city' => "Anytown",
                'shipping-zip' => "91065",
                'shipping-state' => "CA",
                'shipping-country' => "US",
                'shipping-phone' => "555-123-4567",
                'billing-first-name' => "Joe",
                'billing-last-name' => "Public",
                'billing-address' => "1234 Oak",
                'billing-city' => "Anytown",
                'billing-zip' => "00000",
                'billing-state' => "CA",
                'billing-country' => "US",
                'billing-phone' => "555-123-1234",
                'quantity' => 1,
                'email' => "foo@foo.com",
                'shipping-type' => 1,
                'items'=>[
                   null
                ]

            );

        $result=\Movo\Orders\OrderValidate::validate($data);
        $this->assertFalse($result);
    }

    public function test_it_should_return_false_if_email_is_invalid()
    {
        $data=
            array(
                'shipping-first-name' => "Joe",
                'shipping-last-name' => "Public",
                'shipping-address' => "1234 Oak",
                'shipping-city' => "Anytown",
                'shipping-zip' => "91065",
                'shipping-state' => "CA",
                'shipping-country' => "US",
                'shipping-phone' => "555-123-4567",
                'billing-first-name' => "Joe",
                'billing-last-name' => "Public",
                'billing-address' => "1234 Oak",
                'billing-city' => "Anytown",
                'billing-zip' => "00000",
                'billing-state' => "CA",
                'billing-country' => "US",
                'billing-phone' => "555-123-1234",
                'quantity' => 1,
                'email' => "foo",
                'shipping-type' => 1,
                'items'=>[
                    [
                        "sku"=>"12345",
                        "description"=>"something here"
                    ]
                ]

            );

        $result=\Movo\Orders\OrderValidate::validate($data);
        $this->assertFalse($result);
    }
}
