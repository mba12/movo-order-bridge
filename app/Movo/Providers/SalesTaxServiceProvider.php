<?php

namespace Movo\Providers;


use Illuminate\Support\ServiceProvider;

class SalesTaxServiceProvider extends ServiceProvider {

     /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Movo\SalesTax\SalesTaxInterface', 'Movo\SalesTax\ZipTax');
    }
}