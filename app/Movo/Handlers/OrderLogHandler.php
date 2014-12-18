<?php
namespace Movo\Handlers;
use Movo\Observer\Observer;
use Movo\Orders\OrderInput;
use Movo\Orders\InputLogs;
use Movo\Orders\OrderLogs;
use Movo\Orders\SaveOrderDetails;
use Order;


class OrderLogHandler implements Observer {


    public function handleNotification($data)
    {
        (new OrderLogs)->save($data);
    }
}