<?php

namespace Movo\Providers;


use Illuminate\Support\ServiceProvider;

class ShippingServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Movo\Shipping\ShippingInterface', 'Movo\Shipping\IngramShipping');
    }
}