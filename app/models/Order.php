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
        'shipping_address2',
        'shipping_address3',
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

        'partner_id',
        'partner_order_id',

        'ship_to_code',
        'ship_no_later',
        'dock_date'

    ];

    public static function parseAndSaveData($xmlString)
    {

        // <transaction-name>sales-order-success</transaction-name> sales-order-success
        $xml = new SimpleXMLElement($xmlString);
        $result = $xml->xpath('//customer-order-number')[0];  // NOTE: Field contains the stripe id
        $idVal = intval($result);
        $order=Order::find($idVal)->first();
        $order->ingram_order_id= (String)$xml->xpath('//message-id')[0];

        $status = (String)($xml->xpath('//transaction-name')[0]);

        if($status == "sales-order-success"){
            $order->error_flag=0;
            $order->status=1;
        } else if($status == "sales-order-rejection"){
            $order->error_flag=3;
            $order->status=0;
        } else {
            $order->error_flag=3;
            $order->status=0;
        }
        $order->save();

        //TODO: Match the entire order against what we have in our database.
        //      Right now only the order success field is being matched
    }
    public function items()
    {
        return $this->hasMany("Item");
    }

    public function donations()
    {
        return $this->hasMany("Donation");
    }

    public function combineAndCountItems($items, $key="sku")
    {
        $combinedItems=[];
        foreach ($items as $item) {
            if(!isset($combinedItems[$item[$key]])){
                $combinedItems[$item[$key]]=$item;
                $combinedItems[$item[$key]]['quantity']=$item['quantity'];
            }else{
                $combinedItems[$item[$key]]['quantity']++;
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
        return $this->where("amount", ">", 0)->where("error_flag", "<", 2)->where("created_at", ">=", date('Y-m-d H:i:s', strtotime("-1 day 21:00:00")))->get();
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

    public function getIds($first, $second)
    {
        $usedIds = [83,86,88,89,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,
            121,122,123,125,128,129,130,131,132,133,134,135,325,325,325];

        //$result = DB::table('orders')->where("id", ">", 67 + $first * $second)->get();
        // $result = DB::table('orders')->get();
        //$result = $this->all();
        $result = $this->where("id", ">", 300 + $first * $second * 2)->whereNotIn('id', $usedIds)->get(); //->pluck('id');

        Log::info("Database query finished: " . $result->count());

        return $result;
    }
}
