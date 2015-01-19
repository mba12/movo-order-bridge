<?php

class Donation extends \Eloquent {
	protected $fillable = ["charity_id", "order_id", "item_sku","amount"];

	public  function saveDonation($order, $data){
		$donations=[];
		$charityCalculations=CharityCalculation::all();

		for ($i = 0; $i <sizeof($data['items']) ; $i++) {
			     foreach($charityCalculations as $calc){
					 if($calc->item_sku==$data['items'][$i]['sku']){
						  if(!isset($donations[$calc->item_sku])){
							  $donations[$calc->item_sku]=1;
							  Donation::create(
								  [
									  "charity_id"=> $data['charity'],
									  "order_id"=> $order->id,
									  "amount"=> $this->getDonation($calc,$data['items'][$i]),
									  "item_sku"=> $data['items'][$i]['sku'],
								  ]
							  );
						  }
					 }
				 }
		}
	}

	public function getDonation($calc, $item)
	{
		if($calc->calculation_type=="fixed"){
			return $calc->fixed_amt;
		}   else{
			  return $item['amount']*$calc->percent_amt;
		}
	}
}