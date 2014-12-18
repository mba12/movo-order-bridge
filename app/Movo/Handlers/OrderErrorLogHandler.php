<?php
namespace Movo\Handlers;
use Movo\Observer\Observer;
use Movo\Orders\OrderErrorLogs;

class OrderErrorLogHandler implements Observer {


    public function handleNotification($data)
    {
        (new OrderErrorLogs)->save($data);
    }
}