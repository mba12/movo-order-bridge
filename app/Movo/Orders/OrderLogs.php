<?php
/**
 * Created by IntelliJ IDEA.
 * User: Alex
 * Date: 12/17/2014
 * Time: 3:12 PM
 */

namespace Movo\Orders;


use Illuminate\Support\Facades\Input;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class OrderLogs {

    /**
     *
     */
    public function save($data){
        $log = new Logger('order-logs');
        $log->pushHandler(new StreamHandler('../app/storage/logs/orders.log', Logger::INFO));
        $log->addInfo(json_encode($data));
    }
}