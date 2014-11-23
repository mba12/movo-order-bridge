<?php
namespace Movo\Handlers;
use Illuminate\Support\Facades\App;
use Movo\Observer\Observer;
class ReceiptHandler implements Observer {

    public function handleNotification($data)
    {
        $receipt = App::make('Movo\Receipts\ReceiptsInterface');
        $receipt->send($data);
    }
}