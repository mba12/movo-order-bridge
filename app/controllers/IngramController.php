<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use SoapBox\Formatter\Formatter;


class IngramController extends \BaseController
{


    public function trackInventory()
    {
        $log = new Logger('ingram-inventory');
        $log->pushHandler(new StreamHandler(base_path() . '/app/storage/logs/inventory.log', Logger::INFO));
        $log->addInfo(json_encode(Input::all()));

        $formatter = Formatter::make(Input::get("data"), Formatter::XML);
        $obj = $formatter->toArray();
        $data = [];
        InventorySync::create([
            "message_id" => $data["message_id"],
            "transaction_name" => $data["transaction_name"],
            "partner_name" => $data["partner_name"],
            "partner_password" => $data["partner_password"],
            "source_url" => $data["source_url"],
            "create_timestamp" => $data["create_timestamp"],
            "response_request" => $data["response_request"],
            "customer_id" => $data["customer_id"],
            "business_name" => $data["business_name"],
            "line_no" => $data["line_no"],
            "transaction_document_number" => $data["transaction_document_number"],
            "item_code" => $data["item_code"],
            "universal_product_code" => $data["universal_product_code"],
            "warehouse_id" => $data["warehouse_id"],
            "unit_of_measure" => $data["unit_of_measure"],
            "quantity_on_hand" => $data["quantity_on_hand"],
            "quantity_committed" => $data["quantity_committed"],
            "quantity_available" => $data["quantity_available"],
            "quantity_on_back_order" => $data["quantity_on_back_order"],
            "synchronization_timestamp" => $data["synchronization_timestamp"],
            "comments" => $data["comments"],
            "eventID" => $data["eventID"],
        ]);

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

        $formatter = Formatter::make(Input::get("data"), Formatter::XML);
        $obj = $formatter->toArray();
        echo $obj['message-header']['transaction-name'];

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