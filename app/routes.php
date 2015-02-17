<?php


use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Movo\Helpers\Format;
use Movo\Receipts\Item;
use Movo\Receipts\Receipt;
use Movo\Shipping\IngramShipping;

App::bind("Pusher", function ($app) {
    $keys = $app['config']->get('services.pusher');
    return new Pusher($keys['public'], $keys['secret'], $keys['app-id']);
});

Route::get('/', 'OrderController@showForm');

Route::post('buy', array(
    'as' => 'buy',
    'uses' => 'OrderController@buy',
));
Route::group(array('before' => 'csrf'), function () {
    Route::post('coupons/{code}', array(
        'as' => 'check-coupon',
        'uses' => 'CouponController@check',
    ));
});
Route::any('coupons/{code}/{quantity}', array(
    'as' => 'check-coupon',
    'uses' => 'CouponController@check',
));

Route::get('tax/{zipcode}/{state}', array(
    'as' => 'sales-tax',
    'uses' => 'SalesTaxController@getSalesTax',
));


Route::group(array('before' => 'admin'), function () {
    Route::get('/admin/orders', array(
        'as' => 'admin-orders',
        'uses' => 'AdminController@orders',
    ));

    Route::get('/admin/orders/{id}', array(
        'as' => 'admin-order-details',
        'uses' => 'AdminController@orderDetails',
    ));

    Route::get('/admin/coupons', array(
        'as' => 'admin-coupons',
        'uses' => 'AdminController@coupons',
    ));

    Route::any('/admin/stats', array(
        'as' => 'post-admin-stats',
        'uses' => 'AdminController@getStats',
    ));

    Route::get('/admin', 'AdminController@index');
    Route::group(array('before' => 'csrf'), function () {
        Route::put('/admin/coupon/{id}', [
            'as' => 'update-coupon',
            'uses' => 'CouponController@updateCoupon'
        ]);
    });
    Route::group(array('before' => 'csrf'), function () {
        Route::delete('/admin/coupon/{id}', [
            'as' => 'delete-coupon',
            'uses' => 'CouponController@deleteCoupon'
        ]);
    });

    Route::group(array('before' => 'csrf'), function () {
        Route::post('/admin/coupon/', [
            'as' => 'add-coupon',
            'uses' => 'CouponController@addCoupon'
        ]);
    });

    Route::any('/admin/order/search/', [
        'as' => 'order-search',
        'uses' => 'AdminController@orderSearch'
    ]);


});

Route::get('admin/login', array(
    'as' => 'admin-login',
    'uses' => 'AdminController@login',
));

Route::get('admin/logout', function () {
    Auth::logout();
    Session::flush();
    return Redirect::to('/admin');
});

Route::group(array('before' => 'csrf'), function () {
    Route::post('/admin/login', array(
        'as' => 'post-admin-login',
        'uses' => 'AdminController@attemptLogin'
    ));
});


Route::get('/soap', array(
    "as" => "soap",
    "uses" => "SoapController@demo"
));

Route::get('log', array(
    "as" => "log",
    "uses" => "LogController@test"
));

Route::any('/ingram/track-inventory', array(
    'as' => 'ingram-inventory',
    'uses' => 'IngramController@trackInventory',
));

Route::any('/ingram/ship-advice', array(
    'as' => 'ingram-ship-advice',
    'uses' => 'IngramController@shipAdvice',
));

Route::any('/ingram/returns', array(
    'as' => 'ingram-returns',
    'uses' => 'IngramController@returns',
));

Route::any('/ingram/order-status', array(
    'as' => 'ingram-order-status',
    'uses' => 'IngramController@orderStatus',
));

Route::get('connection-test-http', function () {
    $client = new GuzzleHttp\Client();
    $response = $client->post('http://messagehub-dev.brightpoint.com:9135/HttpPost', [
        'body' => [
            'field_name' => 'abc',
            'other_field' => '123'
        ]
    ]);
    $log = new Logger('ingram-connection-test-http');
    $log->pushHandler(new StreamHandler('../app/storage/logs/connection-test-http.log', Logger::INFO));
    $log->addInfo($response);
});

Route::get('connection-test-https', function () {
    $client = new GuzzleHttp\Client();
    $response = $client->post('https://messagehub-dev.brightpoint.com:9443/HttpPost', [
        'body' => [
            'field_name' => 'abc',
            'other_field' => '123'
        ]
    ]);
    $log = new Logger('connection-test-https');
    $log->pushHandler(new StreamHandler('../app/storage/logs/connection-test-https.log', Logger::INFO));
    $log->addInfo($response);
});

Route::get('order-test', function () {
    for ($i = 0; $i < 1; $i++) {
        $orderXML = IngramShipping::generateTestOrder();

        $url = "https://168.215.84.144:9443/HttpPost";
        $cert_file = "/root/test2.pem";
        $result = openssl_get_privatekey($cert_file, 'password');
        echo "Result: " . $result;

        $ch = curl_init();

        $options = array(

            CURLOPT_POST => 1,
            CURLOPT_HTTPHEADER => ['Content-Type:', 'text/xml'],
            CURLOPT_POSTFIELDS => $orderXML,
            CURLOPT_RETURNTRANSFER => 1,
            //CURLOPT_SSLCERTTYPE => "DER",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)',
            CURLOPT_VERBOSE => true,
            CURLOPT_URL => $url,
            CURLOPT_CAPATH => "/etc/pki/tls",
            CURLOPT_SSLVERSION => 3,
            //CURLOPT_SSLCERT => $cert_file ,
        );

        curl_setopt_array($ch, $options);

        $output = curl_exec($ch);
        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);
        if ($curl_errno > 0) {
          //  echo "cURL Error ($curl_errno): $curl_error\n";
        } else {
          //  echo "Data received\n";
        }

        if (!$output) {
          //  echo "Curl Error : " . curl_error($ch);
        } else {
          //  echo htmlentities($output);
        }
        curl_close($ch);

       /* $log = new Logger('ingram-order-test');
        $log->pushHandler(new StreamHandler('../app/storage/logs/ingram-order-test.log', Logger::INFO));
        $log->addInfo($output);*/
        return Response::make($orderXML, '200')->header('Content-Type', 'text/xml');
    }

});

Route::get('dummy', function () {
    $orderXML = IngramShipping::generateTestOrder();
    return Response::make($orderXML, '200')->header('Content-Type', 'text/xml');
});