<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

use Nathanmac\Utilities\Parser\Parser;
use SoapBox\Formatter\Formatter;


class IngramController extends \BaseController
{


    public function trackInventory()
    {
        $log = new Logger('ingram-inventory');
        $log->pushHandler(new StreamHandler(base_path() . '/app/storage/logs/inventory.log', Logger::INFO));
        $log->addInfo(json_encode(Input::all()));

        InventorySync::parseSAndSaveData(Input::get("data"));

        $content = View::make("ingram.track-inventory");
        return Response::make($content, '200')->header('Content-Type', 'text/xml');
    }

    public function returns()
    {
        $log = new Logger('ingram-returns');
        $log->pushHandler(new StreamHandler(base_path() . '/app/storage/logs/returns.log', Logger::INFO));
        $log->addInfo(json_encode(Input::all()));

        $formatter = Formatter::make(Input::get("data"), Formatter::XML);
        $obj = $formatter->toArray();
        echo $obj['message-header']['transaction-name'];

        $content = View::make("ingram.returns");
        return Response::make($content, '200')->header('Content-Type', 'text/xml');
    }

    public function shipAdvice()
    {
        $log = new Logger('ingram-ship-advice');
        $log->pushHandler(new StreamHandler(base_path() . '/app/storage/logs/ship-advice.log', Logger::INFO));
        $log->addInfo(json_encode(Input::all()));

        ShipNotification::parseSAndSaveData(Input::get("data"));

        $content = View::make("ingram.ship-advice");
        return Response::make($content, '200')->header('Content-Type', 'text/xml');
    }

    public function orderStatus()
    {
        $log = new Logger('ingram-order-status');
        $log->pushHandler(new StreamHandler(base_path() . '/app/storage/logs/order-status.log', Logger::INFO));
        $log->addInfo(json_encode(Input::all()));

        $formatter = Formatter::make(Input::get("data"), Formatter::XML);
        $obj = $formatter->toArray();

        if (isset($obj['sales-order-rejection'])) {
            $this->markOrderAsRejected($obj['sales-order-rejection']['header']['customer-id'], $obj['transactionInfo']['eventID']);
        }

        $content = View::make("ingram.order-status");
        return Response::make($content, '200')->header('Content-Type', 'text/xml');
    }

    private function markOrderAsRejected($chargeID, $ingramEventID)
    {

        DB::table('orders')->where('stripe_charge_id', $chargeID)->update([
            "error_flag" => 3,
            "ingram_order_id" => $ingramEventID
        ]);

    }
}