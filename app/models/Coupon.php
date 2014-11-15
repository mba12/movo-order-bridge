<?php

use Movo\Helpers\Format;

class Coupon extends \Eloquent
{
    protected $fillable = [
        //	'name','code','amount','method','limit','min_units'
    ];

    public function calculateDiscount($unitPrice, $quantity)
    {
        if ($this->method == "%") {
            return Format::FormatDecimals(($unitPrice * $quantity) * ($this->amount / 100));
        } else {
            return $this->amount;
        }

    }
}