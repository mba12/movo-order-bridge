<?php

use Artisaninweb\SoapWrapper\Facades\SoapWrapper;

class SoapController extends \BaseController {

	public function demo()
	{
		// Add a new service to the wrapper
		SoapWrapper::add(function ($service) {
			$service
				->name('soap')
				->wsdl('http://currencyconverter.kowabunga.net/converter.asmx?WSDL')
				->trace(true);                                                   // Optional: (parameter: true/false)

		});

		$data = [
			'CurrencyFrom' => 'USD',
			'CurrencyTo'   => 'EUR',
			'RateDate'     => '2014-06-05',
			'Amount'       => '1000'
		];

		// Using the added service
		SoapWrapper::service('soap', function ($service) use ($data) {
			var_dump($service->getFunctions());
		});
	}

}