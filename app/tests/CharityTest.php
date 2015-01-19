<?php
  use Movo\Helpers\Format;
class CharityTest extends TestCase
{

    public function tearDown()
    {
        Mockery::close();
    }

    public function test_it_gets_a_list_of_charities()
    {

       $charities=CharityCalculation::all();
        $this->assertNotEmpty($charities);

    }

    public function test_it_calculates_the_donation_amount()
    {

        $charity=CharityCalculation::where("item_sku","=","857458005053")->first();
        $item=[
            "amount"=>10
        ];
        $donation=new Donation();
        $donationAmt=$donation->getDonation($charity,$item);
        $this->assertEquals(100,$donationAmt);

    }
}
