<?php
namespace Movo\Handlers;
use Illuminate\Support\Facades\App;
use Movo\Observer\Observer;


class PusherHandler implements Observer {

    public function handleNotification($data)
    {
        return;
        $pusher = App::make("Pusher");
        $pusher->trigger("orderChannel", "completedOrder", []);
    }
}