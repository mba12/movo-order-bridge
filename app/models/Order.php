<?php

use Movo\SalesTax\SalesTax;

class Order extends \Eloquent
{
    protected $fillable = [
        'amount',
        'tax',
        'discount',
        'unit_price',
        'quantity',
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

    public function items()
    {
        return $this->hasMany("Item");
    }

    public function combineAndCountItems($items, $key="description")
    {
        $combinedItems=[];
        foreach ($items as $item) {
            if(!isset($combinedItems[$item[$key]])){
                $combinedItems[$item[$key]]=[
                    $key=>$item[$key],
                    "count"=>1
                ];
            }else{
                $combinedItems[$item[$key]]['count']++;
            }
        }
        return $combinedItems;
    }

    public function lastHour()
    {
        return $this->where("amount", ">", 0)->where("error_flag", "<", 2)->where("created_at", ">=", date('Y-m-d H:i:s', strtotime("-60 minute")));
    }

    public function lastDay()
    {
        return $this->where("amount", ">", 0)->where("error_flag", "<", 2)->where("created_at", ">=", date('Y-m-d H:i:s', strtotime("09:00:00")))->get();
    }

    public function lastWeek()
    {
        return $this->where("amount", ">", 0)->where("error_flag", "<", 2)->where("created_at", ">=", date('Y-m-d H:i:s', strtotime("-1 week")));
    }

    public function lastMonth()
    {
        return $this->where("amount", ">", 0)->where("error_flag", "<", 2)->where("created_at", ">=", date('Y-m-d H:i:s', strtotime("-1 month")));
    }

    public function errors()
    {
        return $this->where("error_flag", "=", 2);
    }
}
