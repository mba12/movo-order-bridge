<?php
namespace Movo\Handlers;
use Movo\Observer\Observer;
use Movo\Orders\SaveOrderDetails;
use Order;


class OrderHandler implements Observer {

    /**
     * @param $data
     */
    public function handleNotification($data)
    {
        $order = new Order();
        SaveOrderDetails::save($order,$data['result']['amount'], $data['result']['id']);
    }
}