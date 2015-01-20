<?php
use Movo\Helpers\Format;

class CharityTest extends TestCase
{
    public $order;

    public function setUp()
    {
        parent::setUp();
        DB::beginTransaction();
        $this->order = new Order();
        $this->order->id = 1;
    }

    public function tearDown()
    {
        DB::rollBack();
        Mockery::close();
    }

    public function test_it_gets_a_list_of_charities()
    {

        $charities = CharityCalculation::all();
        $this->assertNotEmpty($charities);


    }

    public function test_it_calculates_the_donation_amount()
    {


        $charity = CharityCalculation::where("item_sku", "=", "857458005053")->first();
        $item = [
            "amount" => 10
        ];
        $donation = new Donation();
        $donationAmt = $donation->getDonation($charity, $item);
        $this->assertEquals(100, $donationAmt);

    }

    public function test_it_saves_the_donation()
    {
        $sku="857458005053";
        $calc = CharityCalculation::where("item_sku", "=", $sku)->first();
        $items = [
            "amount" => 10
        ];
        $data = [
            "charity" => 1,
        ];
        $data['items'][]=[
            "sku"=>$sku,
            "amount"=>"1000",
        ];
        $donation = new Donation();
        $savedDonation = $donation->saveDonation($this->order,$calc, $data, 0);

        $this->assertEquals(1,$savedDonation->campaign_id);
        $this->assertEquals(100,$savedDonation->amount);
        $this->assertEquals(1,$savedDonation->order_id);
        $this->assertEquals($sku,$savedDonation->item_sku);
        $this->assertEquals(1,$savedDonation->charity_id);

    }

    public function test_it_saves_the_donation_with_percentage()
    {
        $sku="857458005053";
        $calc = new CharityCalculation();
        $calc->calculation_type="percent";
        $calc->campaign_id=1;
        $calc->percent_amt=10;
        $items = [
            "amount" => 100
        ];
        $data = [
            "charity" => 1,
        ];
        $data['items'][]=[
            "sku"=>$sku,
            "amount"=>"1000",
        ];
        $donation = new Donation();
        $savedDonation = $donation->saveDonation($this->order,$calc, $data, 0);

        $this->assertEquals(1,$savedDonation->campaign_id);
        $this->assertEquals(1000,$savedDonation->amount);
        $this->assertEquals(1,$savedDonation->order_id);
        $this->assertEquals($sku,$savedDonation->item_sku);
        $this->assertEquals(1,$savedDonation->charity_id);

    }
}
