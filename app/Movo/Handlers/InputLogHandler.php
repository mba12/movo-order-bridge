<?php
namespace Movo\Handlers;
use Movo\Observer\Observer;
use Movo\Orders\OrderInput;
use Movo\Orders\InputLogs;
use Movo\Orders\SaveOrderDetails;
use Order;


class InputLogHandler implements Observer {


    public function handleNotification($data)
    {
        (new InputLogs)->save($data);
    }
}