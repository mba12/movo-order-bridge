<?php
namespace Movo\Handlers;
use Illuminate\Support\Facades\App;
use Movo\Observer\Observer;
class VerifyHandler implements Observer {

    public function handleNotification($data)
    {
        $verify = App::make('Movo\Receipts\MailgunSendVerificationRequest');
        $verify->send($data);
    }
}