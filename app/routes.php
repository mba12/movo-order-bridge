<?php


use Movo\Helpers\Format;
use Movo\Receipts\Item;
use Movo\Receipts\Receipt;

App::bind("Pusher", function ($app) {
    $keys = $app['config']->get('services.pusher');
    return new Pusher($keys['public'], $keys['secret'], $keys['app-id']);
});
Route::post('stripe/webhook', 'WebhookController@handleWebhook');

Route::get('/', 'OrderController@showForm');
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

    Route::get('/admin/coupons', array(
        'as' => 'admin-coupons',
        'uses' => 'AdminController@coupons',
    ));

    Route::post('/admin/stats', array(
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
        Route::post('/admin/orders', [
            'as' => 'order-search',
            'uses' => 'AdminController@orderSearch'
        ]);
    });

});

Route::get('admin/login', array(
    'as' => 'admin-login',
    'uses' => 'AdminController@login',
));

Route::group(array('before' => 'csrf'), function () {
    Route::post('/admin/login', array(
        'as' => 'post-admin-login',
        'uses' => 'AdminController@attemptLogin'
    ));
});


Route::get('/info', function () {
        echo phpinfo();
        return '';
    }
);

Route::get("/email-test", function () {
    $tmpData['quantity'] = 1;
    $tmpData['shippingName'] = 'Ryan Hovland';
    $tmpData['shippingAddress'] = '1651 Ash St';
    $tmpData['shippingCity'] = 'Lake Oswego';
    $tmpData['shippingState'] = 'OR';
    $tmpData['shippingZip'] = '97034';
    $tmpData['total'] = '$120.00';
    $tmpData['items']=[];
    for ($i = 0; $i < 3; $i++) {
        array_push($tmpData['items'], new Item("Item". ($i + 1), 1, Format::FormatUSD('29.99')));
    }
    return View::make("emails.receipt", [
        'data' => $tmpData
    ]);
});

