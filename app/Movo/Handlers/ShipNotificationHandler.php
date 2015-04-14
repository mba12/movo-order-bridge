<?php
namespace Movo\Handlers;
use Illuminate\Support\Facades\App;
use Movo\Observer\Observer;
class ShipNotificationHandler implements Observer {

    public function handleNotification($data)
    {
        $notifier = App::make('Movo\Receipts\MailgunShipNotification');
        $notifier->send($data);
    }
}