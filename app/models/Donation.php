<?php

class Donation extends \Eloquent
{
    protected $fillable = ["charity_id", "order_id", "item_sku", "amount", "campaign_id"];

    public function saveAllDonations($order, $data)
    {
        $donations = [];
        $charityCalculations = CharityCalculation::all();

        for ($i = 0; $i < sizeof($data['items']); $i++) {
            foreach ($charityCalculations as $calc) {
                if ($calc->item_sku == $data['items'][$i]['sku']) {
                    $this->saveDonation($order, $calc, $data, $i);
                }
            }
        }
    }

    public function saveDonation($order, $calc, $data, $index)
    {
        $savedDonation = Donation::create(
            [
                "charity_id" => $data['charity'],
                "order_id" => $order->id,
                "amount" => $this->getDonation($calc, $data['items'][$index]),
                "item_sku" => $data['items'][$index]['sku'],
                "campaign_id" => $calc->campaign_id,
            ]
        );
        return $savedDonation;
    }

    public function getDonation($calc, $item)
    {
        if ($calc->calculation_type == "fixed") {
            return $calc->fixed_amt * $item['quantity'];
        } else {
            return $item['amount'] * $calc->percent_amt / 100 * $item['quantity'];
        }
    }
}