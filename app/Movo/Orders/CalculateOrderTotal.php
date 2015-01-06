<?php
/**
 * Created by IntelliJ IDEA.
 * User: Alex
 * Date: 11/23/2014
 * Time: 12:28 PM
 */

namespace Movo\Orders;


use Movo\SalesTax\SalesTax;

class CalculateOrderTotal
{
    public static function calculateTotal($data)
    {
        $discount = $data['discount'];
        $subtotal = $data['total-unit-prices']  - $discount;
        $shippingRate = $data['shipping-rate'];
        $totalSalesTax = SalesTax::calculateTotalTax($subtotal, $shippingRate, $data['tax-rate'], $data['state']);
        $amount = $subtotal + $totalSalesTax + $shippingRate;
        return $amount;
    }


}