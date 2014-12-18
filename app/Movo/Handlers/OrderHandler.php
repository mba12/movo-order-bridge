<?php
namespace Movo\Handlers;

use Movo\Observer\Observer;
use Movo\Orders\OrderInput;
use Movo\Orders\SaveOrderDetails;
use Order;
use Whoops\Exception\ErrorException;


class OrderHandler implements Observer
{

    /**
     * @param $data
     * @return Order
     * @throws \Exception
     */
    public function handleNotification($data)
    {
        try {
            return SaveOrderDetails::save((new Order), $data);
        } catch (ErrorException $e) {
            throw new \Exception("Error on save");
        }
    }
}