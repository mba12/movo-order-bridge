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

    private $statesWhichTaxShipping = ["NY", "IN"];

    /**
     * @param $subtotal
     * @param $shipping
     * @param $rate
     * @param $state
     */
    public function calculateTotalTax($subtotal, $shipping, $rate, $state)
    {
        if (in_array($state, $this->statesWhichTaxShipping)) {
            return ($subtotal + $shipping) * $rate;
        }
        return $subtotal * $rate;
    }
}