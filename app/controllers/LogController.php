<?php
use Monolog;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class LogController extends \BaseController
{

    public function test()
    {
        // create a log channel
        $log = new Logger('name');
        $log->pushHandler(new StreamHandler('../app/storage/logs/warning.log', Logger::WARNING));
        $order=Order::with("items")->first();
// add records to the log
        $log->addWarning($order);
        $log->addError('Error to test');
        var_dump($log);
    }

}