<?php
namespace Movo\Handlers;
use Movo\Observer\Observer;
use Movo\Orders\OrderInput;
use Movo\Orders\SaveOrderDetails;
use Order;


class OrderHandler implements Observer {

    /**
     * @param $data
     */
    public function handleNotification($data)
    {
         SaveOrderDetails::save((new Order),$data);
    }
}