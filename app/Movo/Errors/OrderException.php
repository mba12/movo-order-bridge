<?php
/**
 * Created by IntelliJ IDEA.
 * User: Alex
 * Date: 12/1/2014
 * Time: 12:35 PM
 */

namespace Movo\Errors;


use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;

class OrderException extends Exception {

}

App::error(function(OrderException $e, $code, $fromConsole)
{
    if ( $fromConsole )
    {
        return 'Error '.$code.': '.$e->getMessage()."\n";
    }

    return Response::json(array('status' => '400', 'message' => $e->getMessage()));

});