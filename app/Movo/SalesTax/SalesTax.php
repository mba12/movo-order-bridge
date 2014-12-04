<?php
/**
 * Created by IntelliJ IDEA.
 * User: Alex
 * Date: 11/20/2014
 * Time: 3:56 PM
 */

namespace Movo\SalesTax;


class SalesTax
{

    /**
     * @param $subtotal
     * @param $shipping
     * @param $rate
     * @param $state
     */
    public static function calculateTotalTax($subtotal, $shipping, $rate, $state)
    {
        $statesWhichTaxShipping = ["NY", "IN"];
        if (in_array($state, $statesWhichTaxShipping)) {
            return ($subtotal + $shipping) * $rate;
        }
        return $subtotal * $rate;
    }
}