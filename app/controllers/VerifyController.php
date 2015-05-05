<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Movo\Handlers\VerifyHandler;

class VerifyController extends \BaseController {


	public function userSignup()
	{
        $environment = App::environment();
        Log::info("Track User Signup environment: " . $environment);
        $request = Request::instance();
		$content = $request->getContent();
		$log = new Logger('user-signups');
		$log->pushHandler(new StreamHandler(base_path().'/app/storage/logs/user-signups.log', Logger::INFO));
		$log->addInfo($content);
        $key = Input::get("fullname") . Input::get("email");

        $inputValues =
        [
            "full_name"=>Input::get("fullname"),
            "email"=>Input::get("email"),
            "key"=>md5($key),
        ];

        try {
            // Retrieve the user by the attributes, or create it if it doesn't exist...
            // Logs the new user to the database
            $verify = Verify::firstOrCreate($inputValues);

        } catch (Exception $e) {
            Log::info("Exception during email notification for email: " . Input::get('email'));
            Log::info("Exception during ship notification: " . $e->getMessage());
            Log::info("Exception during ship notification: " . $e->getTraceAsString());
            return Response::json(array('status' => '300','error_code'=>1, 'message' => 'Duplicate email key. The full name value or key value was likely changed and this is the second attempt at sending an email except the values have been updated between the first and subsequent attempt.'));

        }

        $newId = $verify->id;
        $inputValues['id'] = $newId;

        $environment = App::environment();
        Log::info("Environment is: " . $environment);
        switch($environment) {
            case 'production':
            case 'prod':
                $inputValues['env'] = 'orders.getmovo.com/';
                break;
            case 'devorders':
                $inputValues['env'] = 'devorders.getmovo.com/';
                break;
            case 'qaorders':
                $inputValues['env'] = 'qaorders.getmovo.com/';
                break;
            default:
                $inputValues['env'] = 'movo.app:8000/';
        }

        // Now send an email to the user to ask them to confirm their email with us
        (new VerifyHandler)->handleNotification($inputValues);

        return Response::json(array('status' => '200','error_code'=>0, 'message' => 'Email verification processed.'));
	}

	public function userConfirm(){

        $environment = App::environment();
        Log::info("Track User Confirm environment: " . $environment);

        // Get the incoming request
        $request = Request::instance();
		$content = $request->getContent();

        // Log all incoming requests to a file before processing
		$log = new Logger('user-signups');
		$log->pushHandler(new StreamHandler(base_path().'/app/storage/logs/user-signups.log', Logger::INFO));
		$log->addInfo($content);

        $id = Input::get('id');
        $key = Input::get('tracking');
        // Log incoming to the database
        $verify = Verify::find($id);
        $confirmed = $verify->confirm($id, $key);

        try {

            if($confirmed === false) {
                $log->addInfo("************ BAD EMAIL NOTIFICATION RECEIVED ************");
                $content =  View::make("verify.invalid");
            } else {
                $content =  View::make("verify.confirm");
            }

        } catch (Exception $e) {
            Log::info("Exception during email notification for email: " . Input::get('email'));
            Log::info("Exception during ship notification: " . $e->getMessage());
            Log::info("Exception during ship notification: " . $e->getTraceAsString());
        }

		return Response::make($content, '200')->header('Content-Type', 'text/html');
	}

}