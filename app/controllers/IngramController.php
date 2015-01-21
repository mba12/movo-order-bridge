<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class IngramController extends \BaseController {


	public function trackInventory()
	{
		$request = Request::instance();
		$content = $request->getContent();
		$log = new Logger('ingram-inventory');
		$log->pushHandler(new StreamHandler('../app/storage/logs/inventory.log', Logger::INFO));
		$log->addInfo($content);
		$content =  View::make("ingram.track-inventory");
		return Response::make($content, '200')->header('Content-Type', 'text/xml');
	}

	public function returns()
	{
		$request = Request::instance();
		$content = $request->getContent();
		$log = new Logger('ingram-returns');
		$log->pushHandler(new StreamHandler('../app/storage/logs/returns.log', Logger::INFO));
		$log->addInfo($content);
		$content =  View::make("ingram.returns");
		return Response::make($content, '200')->header('Content-Type', 'text/xml');
	}

	public function shipAdvice(){
		$request = Request::instance();
		$content = $request->getContent();
		$log = new Logger('ingram-ship-advice');
		$log->pushHandler(new StreamHandler('../app/storage/logs/ship-advice.log', Logger::INFO));
		$log->addInfo($content);
		$content =  View::make("ingram.ship-advice");
		return Response::make($content, '200')->header('Content-Type', 'text/xml');
	}

	public function orderStatus(){
		$request = Request::instance();
		$content = $request->getContent();
		$log = new Logger('ingram-order-status');
		$log->pushHandler(new StreamHandler('../app/storage/logs/order-status.log', Logger::INFO));
		$log->addInfo($content);
		$content =  View::make("ingram.order-status");
		return Response::make($content, '200')->header('Content-Type', 'text/xml');
	}
}