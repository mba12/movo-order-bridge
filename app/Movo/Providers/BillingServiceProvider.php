<?php

namespace Movo\Providers;


use Illuminate\Support\ServiceProvider;

class BillingServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Movo\Billing\BillingInterface', 'Movo\Billing\StripeBilling');
    }
}