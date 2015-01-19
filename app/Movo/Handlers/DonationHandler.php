<?php
namespace Movo\Handlers;

use Donation;
use Illuminate\Support\Facades\Input;
use Movo\Observer\Observer;
use Movo\Orders\OrderInput;
use Movo\Orders\SaveOrderDetails;
use Order;
use Whoops\Exception\ErrorException;


class DonationHandler implements Observer
{

    /**
     * @param Order $order
     * @return Order
     * @throws \Exception
     * @internal param $data
     */
    public function handleNotification( $orderData)
    {
        try {
            (new Donation())->saveDonation($orderData['order'], $orderData['data']);

        } catch (ErrorException $e) {
            throw new \Exception("Error on save donation");
        }
    }
}