<?php
  use Movo\Helpers\Format;
class FormatTests extends TestCase
{

    public function tearDown()
    {
        Mockery::close();
    }

    public function test_it_formats_phone_numbers_with_only_numbers()
    {
        $phone='(123)456-7890';
        $phone=Format::ReducePhoneNumberToDigits($phone);
        $this->assertEquals('1234567890', $phone);

        $phone='123-456-7890';
        $phone=Format::ReducePhoneNumberToDigits($phone);
        $this->assertEquals('1234567890', $phone);

        $phone='123  456-7890';
        $phone=Format::ReducePhoneNumberToDigits($phone);
        $this->assertEquals('1234567890', $phone);

        $phone='1.123 456-7890';
        $phone=Format::ReducePhoneNumberToDigits($phone);
        $this->assertEquals('11234567890', $phone);

        $phone='+1.123 456-7890';
        $phone=Format::ReducePhoneNumberToDigits($phone);
        $this->assertEquals('11234567890', $phone);
    }
}
