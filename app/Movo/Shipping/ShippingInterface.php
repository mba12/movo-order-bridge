<?php namespace Movo\Shipping;


interface ShippingInterface {
    public function ship(array $data);
    public function shipWithSettings($environment, $url, array $data);

}