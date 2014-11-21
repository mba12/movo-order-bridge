<?php

class CouponTests extends TestCase
{

    public function tearDown()
    {
        Mockery::close();
    }

    public function test_it_should_get_a_coupon_object()
    {
        $couponController = Mockery::mock("CouponController")->makePartial();
        $couponController->shouldReceive("outsideTimeRange")->once()->andReturn(false);
        $couponController->shouldReceive("couponLimitReached")->once()->andReturn(false);
        $result = $couponController->check("friends20", 1);
        $this->assertNotEmpty($result);
    }

    public function test_it_should_return_null_if_limit_is_reached()
    {
        $couponController = Mockery::mock("CouponController")->makePartial();
        $couponController->shouldReceive("outsideTimeRange")->once()->andReturn(false);
        $couponController->shouldReceive("couponLimitReached")->once()->andReturn(true);
        $result = $couponController->check("friends20", 1);
        $this->assertEmpty($result);
    }

    public function test_it_should_return_true_if_instance_count_too_high()
    {
        $couponController = Mockery::mock("CouponController")->makePartial();
        $coupon = new Coupon();
        $coupon->limit = 100;
        $coupon->min_units = 1;
        $result = $couponController->couponLimitReached($coupon, "friends20", 1, 101);
        $this->assertTrue($result);
    }

    public function test_it_should_true_false_if_instance_count_lower_than_limit()
    {
        $couponController = Mockery::mock("CouponController")->makePartial();
        $coupon = new Coupon();
        $coupon->limit = 100;
        $coupon->min_units = 1;
        $result = $couponController->couponLimitReached($coupon, "friends20", 1, 99);
        $this->assertFalse($result);
    }

    public function test_it_should_true_true_if_coupon_outside_time_range()
    {
        $couponController = Mockery::mock("CouponController")->makePartial();
        $coupon = new Coupon();
        $coupon->start_time = '2014-11-11';
        $coupon->end_time = '2014-11-13';
        $coupon->time_constraint = 1;
        $result = $couponController->outsideTimeRange($coupon, strtotime('2014-11-14 06:11:33'));
        $this->assertTrue($result);
    }

    public function test_it_should_true_false_if_coupon_inside_time_range()
    {
        $couponController = Mockery::mock("CouponController")->makePartial();
        $coupon = new Coupon();
        $coupon->start_time = '2014-11-11';
        $coupon->end_time = '2014-11-13';
        $coupon->time_constraint = 1;
        $result = $couponController->outsideTimeRange($coupon, strtotime('2014-11-12 06:11:33'));
        $this->assertFalse($result);
    }

    public function test_it_should_false_if_coupon_not_time_constrained()
    {
        $couponController = Mockery::mock("CouponController")->makePartial();
        $coupon = new Coupon();
        $coupon->start_time = '2014-11-11';
        $coupon->end_time = '2014-11-13';
        $coupon->time_constraint = 0;
        $result = $couponController->outsideTimeRange($coupon, strtotime('2024-11-12 06:11:33'));
        $this->assertFalse($result);
    }

    public function test_it_should_return_null_if_outside_time_range()
    {
        $couponController = Mockery::mock("CouponController")->makePartial();
        $couponController->shouldReceive("outsideTimeRange")->once()->andReturn(true);
        $result = $couponController->check("friends20", 1);
        $this->assertEmpty($result);
    }

    public function test_it_should_be_empty_if_coupon_is_inactive()
    {
        //CouponController::shouldRecieve("check")->once();

        $couponController = new CouponController();
        $result = $couponController->check("dummy", 1);
        $this->assertEmpty($result);

    }

    public function test_it_should_not_be_empty_if_coupon_is_active_and_quantity_is_enough()
    {
        $couponController = new CouponController();
        $result = $couponController->check("friends20", 3);
        $this->assertNotEmpty($result);
    }

    public function test_it_should_be_empty_if_coupon_is_active_but_quantity_is_not_enough()
    {
        $couponController = new CouponController();
        $result = $couponController->check("friends20", 1);
        $this->assertEmpty($result);
    }
}
