<?php
namespace Movo\Handlers;
use Illuminate\Support\Facades\App;
use Movo\Observer\Observer;



class ShippingHandler implements Observer {

    public function handleNotification($data)
    {
        $shipping = App::make('Movo\Shipping\ShippingInterface');
        $shipping->ship($data);

    }
}