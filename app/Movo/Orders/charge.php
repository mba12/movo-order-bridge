<?php
/**
 * Created by IntelliJ IDEA.
 * User: Alex
 * Date: 10/26/2014
 * Time: 12:56 PM
 */

namespace Movo\Orders;


use Stripe;
use Stripe_Event;
use User;

class Charge
{
    public function __construct(array $payload)
    {

        Stripe::setApiKey("sk_test_6k4usddYrqLuqbUk1Whjv9Rk");
        $foo = Stripe_Event::retrieve("evt_14qBdOG7qzeE6UFgT56ufYru");
        $user = User::find(1);
        $user->name = "foo";
        $user->save();
        dd($foo['type']);

    }
}