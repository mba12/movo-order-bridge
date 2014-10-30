<?php namespace Movo\Shipping;


interface ShippingInterface {
    public function ship(array $data);
}