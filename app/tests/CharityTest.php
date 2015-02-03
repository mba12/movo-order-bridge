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
        $app = $this->createApplication();

        $app->make('artisan')->call('cache:clear');
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
            "amount" => 10,
            "quantity" => 1
        ];
        $donation = new Donation();
        $donationAmt = $donation->getDonation($charity, $item);
        $this->assertEquals(100, $donationAmt);

    }

    public function test_it_saves_the_donation()
    {
        $sku = "857458005053";
        $calc = CharityCalculation::where("item_sku", "=", $sku)->first();

        $data = [
            "charity" => 1,
        ];
        $data['items'][] = [
            "sku" => $sku,
            "amount" => "1000",
            "quantity" => 1
        ];
        $donation = new Donation();
        $savedDonation = $donation->saveDonation($this->order, $calc, $data, 0);

        $this->assertEquals(1, $savedDonation->campaign_id);
        $this->assertEquals(100, $savedDonation->amount);
        $this->assertEquals(1, $savedDonation->order_id);
        $this->assertEquals($sku, $savedDonation->item_sku);
        $this->assertEquals(1, $savedDonation->charity_id);
        $savedDonation->delete();
    }

    public function test_it_saves_the_donation_with_percentage()
    {
        $sku = "857458005053";
        $calc = new CharityCalculation();
        $calc->calculation_type = "percent";
        $calc->campaign_id = 1;
        $calc->percent_amt = 10;

        $data = [
            "charity" => 1,
        ];
        $data['items'][] = [
            "sku" => $sku,
            "amount" => "1000",
            "quantity" => 1
        ];
        $donation = new Donation();
        $savedDonation = $donation->saveDonation($this->order, $calc, $data, 0);

        $this->assertEquals(1, $savedDonation->campaign_id);
        $this->assertEquals(100, $savedDonation->amount);
        $this->assertEquals(1, $savedDonation->order_id);
        $this->assertEquals($sku, $savedDonation->item_sku);
        $this->assertEquals(1, $savedDonation->charity_id);
        $savedDonation->delete();

    }

    public function test_it_only_gets_active_charities()
    {
        $charities = Charity::getList();
        foreach ($charities as $charity) {
            $this->assertEquals($charity->active, 1);
        }
        $this->assertEquals(3, $charities->count());
    }

    public function test_it_calculates_fixed_amt_quantity_of_items()
    {
        $sku = "857458005053";
        $calc = new CharityCalculation();
        $calc->calculation_type = "fixed";
        $calc->campaign_id = 1;
        $calc->percent_amt = 10;
        $calc->fixed_amt = 100;
        $items = [
            "amount" => 1000
        ];
        $data = [
            "charity" => 2,
        ];
        $data['items'][] = [
            "sku" => $sku,
            "amount" => "1000",
            "quantity" => "3",
        ];
        $donation = new Donation();
        $savedDonation = $donation->saveDonation($this->order, $calc, $data, 0);

        $this->assertEquals(1, $savedDonation->campaign_id);
        $this->assertEquals(300, $savedDonation->amount);
        $this->assertEquals(1, $savedDonation->order_id);
        $this->assertEquals($sku, $savedDonation->item_sku);
        $this->assertEquals(2, $savedDonation->charity_id);
        $savedDonation->delete();

    }

    public function test_it_calculates_percent_amt_quantity_of_items()
    {
        $sku = "857458005053";
        $calc = new CharityCalculation();
        $calc->calculation_type = "percent";
        $calc->campaign_id = 1;
        $calc->percent_amt = 10;
        $calc->fixed_amt = 100;
        $items = [
            "amount" => 1000
        ];
        $data = [
            "charity" => 2,
        ];
        $data['items'][] = [
            "sku" => $sku,
            "amount" => "1000",
            "quantity" => "3",
        ];
        $donation = new Donation();
        $savedDonation = $donation->saveDonation($this->order, $calc, $data, 0);

        $this->assertEquals(1, $savedDonation->campaign_id);
        $this->assertEquals(300, $savedDonation->amount);
        $this->assertEquals(1, $savedDonation->order_id);
        $this->assertEquals($sku, $savedDonation->item_sku);
        $this->assertEquals(2, $savedDonation->charity_id);
        $savedDonation->delete();

    }

    public function test_it_saves_the_correct_number_of_donations()
    {
        $sku = "857458005053";
        $calc = new CharityCalculation();
        $calc->calculation_type = "percent";
        $calc->campaign_id = 1;
        $calc->percent_amt = 10;
        $calc->fixed_amt = 100;
        $items = [
            "amount" => 1000
        ];
        $data = [
            "charity" => 2,
        ];
        $data['items'][] = [
            "sku" => $sku,
            "amount" => "1000",
            "quantity" => "3",
        ];
        $donation = new Donation();
        $donation->saveAllDonations($this->order, $data);
        $donations = Donation::where("order_id", "=", 1);
        $count = $donations->count();
        $donations->delete();
        $this->assertEquals(1, $count);


    }
}
