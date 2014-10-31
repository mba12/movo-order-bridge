<?php

namespace Movo\Providers;


use Illuminate\Support\ServiceProvider;

class ReceiptsServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Movo\Receipts\ReceiptsInterface', 'Movo\Receipts\MailgunReceipts');
    }
}