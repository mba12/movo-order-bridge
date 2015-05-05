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
        $first = Input::get("first");
        $last = Input::get("last");
        $email = Input::get("email");
        $key = $first . $last . $email;

        $inputValues =
        [
            "first_name"=>Input::get("first"),
            "last_name"=>Input::get("last"),
            "email"=>Input::get("email"),
            "key"=>md5($key),
        ];

        // Retrieve the user by the attributes, or create it if it doesn't exist...
        $verify = Verify::firstOrCreate($inputValues);
        // Logs the new user to the database
		//$verify = Verify::create($inputValues);
        $newId = $verify->id;
        $data = $inputValues;
        $data['fullName'] = $first . " " . $last;
        $data['id'] = $newId;

        // Now send an email to the user to ask them to confirm their email with us
        (new VerifyHandler)->handleNotification($data);

		//$content =  View::make("ingram.track-inventory");

        return Response::json(array('status' => '200','error_code'=>0, 'message' => 'Email verification processed.'));
	}

	public function userConfirm(){

        // Get the incoming request
        $request = Request::instance();
		$content = $request->getContent();

        // Log all incoming requests to a file before processing
		$log = new Logger('user-signups');
		$log->pushHandler(new StreamHandler(base_path().'/app/storage/logs/user-signups.log', Logger::INFO));
		$log->addInfo($content);

        $id = Input::get('id');
        $key = Input::get('key');
        // Log incoming to the database
        $verify = Verify::find($id);
        $confirmed = $verify->confirm($id, $key);

        try {

            if($confirmed === false) {
                $log->addInfo("************ BAD EMAIL NOTIFICATION RECEIVED ************");
                $content =  View::make("verify.confirm_bad");
            } else {
                $content =  View::make("verify.confirm_good");
            }


        } catch (Exception $e) {
            Log::info("Exception during email notification for email: " . Input::get('email'));
            Log::info("Exception during ship notification: " . $e->getMessage());
            Log::info("Exception during ship notification: " . $e->getTraceAsString());
        }

		return Response::make($content, '200')->header('Content-Type', 'text/xml');
	}

}