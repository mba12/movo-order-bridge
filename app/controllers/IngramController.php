<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Movo\Handlers\ShipNotificationHandler;

class IngramController extends \BaseController {


	public function trackInventory()
	{
        $environment = App::environment();
        Log::info("Track Inventory Current environment: " . $environment);
        $request = Request::instance();
		$content = $request->getContent();
		$log = new Logger('ingram-inventory');
		$log->pushHandler(new StreamHandler(base_path().'/app/storage/logs/inventory.log', Logger::INFO));
		$log->addInfo($content);
		InventorySync::parseAndSaveData($content);
		$content =  View::make("ingram.track-inventory");
		return Response::make($content, '200')->header('Content-Type', 'text/xml');
	}

	public function returns()
	{

		$request = Request::instance();
		$content = $request->getContent();
		$log = new Logger('ingram-returns');
		$log->pushHandler(new StreamHandler(base_path().'/app/storage/logs/returns.log', Logger::INFO));
		$log->addInfo($content);
		$content =  View::make("ingram.returns");
		return Response::make($content, '200')->header('Content-Type', 'text/xml');
	}

	public function shipAdvice(){

        // Get the incoming request
        $request = Request::instance();
		$content = $request->getContent();

        // Log all incoming requests to a file before processing
		$log = new Logger('ingram-ship-advice');
		$log->pushHandler(new StreamHandler(base_path().'/app/storage/logs/ship-advice.log', Logger::INFO));
		$log->addInfo($content);

        // Log incoming to the database
        $shipNotify = new ShipNotification();
        $trackingInfo = $shipNotify->parseSAndSaveData($content);

        $order_id = 0;
        try {

            if(isset($trackingInfo['order_number']) && is_numeric($trackingInfo['order_number']) === false) {
                // This is not a regular order number and is probably a ship exception or return
                // Use the Bright Point order number to trace back to the original order
                // <brightpoint-order-number>114100337</brightpoint-order-number>
                $log->addInfo("************ RETURN NOTIFICATION RECEIVED ************");
                /*
                Mail::send('emails.welcome', $data, function($message) use ($user)
                {
                    $message->to($user->email, $user->name)
                        ->subject('Ingram Return Ship Advice');
                });
                */

            } else {

                // This is a regular order number
                $order_id = intval($trackingInfo['order_number']);
                $order = Order::findOrFail($order_id);
                $order->tracking_code = $trackingInfo['tracking_code'];
                $order->save();

                $partner_id = $order->partner_id;
                Log::info("Partner id is: " . $partner_id);

                $environment = App::environment();
                Log::info("Environment is: " . $environment);
                $trackingInfo['ship-email'] = 'michael@getmovo.com';
                switch($environment) {
                    case 'production':
                    case 'prod':
                        Log::info("Sending ship notification to: " . $trackingInfo['ship-email']);
                        break;
                    case 'devorders':
                    case 'qaorders':
                        $trackingInfo['ship-email'] = getenv('ingram.receipt-email');
                        break;
                    default:
                        $trackingInfo['ship-email'] = 'michael@getmovo.com';
                }

                if ( !isset($partner_id) ||
                    (isset($partner_id) && strlen($partner_id) === 0) || strcasecmp($partner_id, 'movo')) {
                    (new ShipNotificationHandler)->handleNotification($trackingInfo);
                }

            }


        } catch (Exception $e) {
            Log::info("Exception during ship notification for order: " . $order_id);
            Log::info("Exception during ship notification: " . $e->getMessage());
            Log::info("Exception during ship notification: " . $e->getTraceAsString());
        }

		$content =  View::make("ingram.ship-advice");
		return Response::make($content, '200')->header('Content-Type', 'text/xml');
	}

	public function orderStatus(){
		$request = Request::instance();
		$content = $request->getContent();

        $log = new Logger('ingram-order-status');
        $log->pushHandler(new StreamHandler(base_path().'/app/storage/logs/order-status.log', Logger::INFO));
        $log->addInfo($content);

        Order::parseAndSaveData($content);
		$content =  View::make("ingram.order-status");
		return Response::make($content, '200')->header('Content-Type', 'text/xml');
	}
}