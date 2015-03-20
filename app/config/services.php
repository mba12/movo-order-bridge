<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/

	'mailgun' => array(
		'domain' => 'getmovo.com',
		'secret' => 'key-20507900adecce50ee0c8faea5ffa3e2',
	),

	'pusher' => array(
		'public' =>  getenv('pusher.public'),
		'secret' =>  getenv('pusher.secret'),
		'app-id' =>  getenv('pusher.app-id'),
	),
	'zip-tax' => array(
		'key' =>  getenv('zip-tax.key'),
	),
	'stripe' => array(
		'secret' => getenv('stripeKeys.secret'),
		'publishable' => getenv('stripeKeys.publishable'),
	),
	'ingram' => array(
		'source-url' => getenv('ingram.source-url'),
		'customer-id' => getenv('ingram.customer-id'),
		'partner-name' => getenv('ingram.partner-name'),
	),
);
