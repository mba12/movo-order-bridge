<?php

use Movo\SalesTax\SalesTax;

class Order extends \Eloquent
{
    protected $fillable = [
        'amount',
        'quantity',
        'sizes',
        'shipping_type',
        'shipping_first_name',
        'shipping_last_name',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_zip',
        'shipping_country',
        'shipping_phone',

        'billing_first_name',
        'billing_last_name',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_zip',
        'billing_country',
        'billing_phone',
        'email',

        'stripe_charge_id',
        'coupon',
        'ingram_order_id',
        'status',
        'tracking_code',
        'error_flag',
    ];

    public function lastHour()
    {
        return $this->where("created_at", ">=", date('Y-m-d h:m:s',strtotime("-1 hour")));
    }

    public function lastDay()
    {
        return $this->where("created_at", ">=", date('Y-m-d h:m:s',strtotime("-1 day")));
    }

    public function lastWeek()
    {
        return $this->where("created_at", ">=", date('Y-m-d h:m:s',strtotime("-1 week")));
    }

    public function lastMonth()
    {
        return $this->where("created_at", ">=", date('Y-m-d h:m:s',strtotime("-1 month")));
    }

    public function errors()
    {
        return $this->where("error_flag",">",0);
    }
}
