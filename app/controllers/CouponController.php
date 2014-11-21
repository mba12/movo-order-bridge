<?php

class CouponController extends \BaseController
{


    /**
     * @param $code
     * @return null
     */
    public function check($code, $quantity)
    {
        ;
        $coupon = Coupon::where("code", "=", $code)->where("active", "=", 1)->first();
        if ($coupon) {
            if ($this->outsideTimeRange($coupon, time())) {
                return null;
            }
            $instanceCount = $instanceCount = CouponInstance::where("code", "=", $code)->count();
            if ($this->couponLimitReached($coupon, $code, $quantity, $instanceCount)) {
                return null;
            }

            $token = str_random(40);
            CouponInstance::create([
                "code" => $code,
                "token" => $token,
                "used" => 0
            ]);
            $result['token'] = $token;
            $result['coupon'] = $coupon;
            return $result;
        }

    }

    /**
     * @param $id
     * @return mixed
     */
    public function updateCoupon($id)
    {
        $coupon = Coupon::find($id);
        $coupon->name = Input::get("name");
        $coupon->code = Input::get("code");
        $coupon->amount = Input::get("amount");
        $coupon->method = Input::get("method");
        $coupon->limit = Input::get("limit");
        $coupon->min_units = Input::get("min_units");
        $coupon->start_time = Input::get("start_time");
        $coupon->end_time = Input::get("end_time");
        $coupon->time_constraint = Input::get("time_constraint");
        $coupon->active = Input::get("active");
        $coupon->save();
        return Redirect::to('/admin/coupons');;
    }

    /**
     * @param $coupon
     * @param $code
     * @param $quantity
     * @param $instanceCount
     * @return bool
     */
    public function couponLimitReached($coupon, $code, $quantity, $instanceCount)
    {

        if (($instanceCount <= $coupon->limit || $coupon->limit == 0) && $coupon->min_units <= $quantity) {
            return false;
        }
        return true;
    }


    /**
     * @param $coupon
     * @param $time
     * @return bool
     */
    public function outsideTimeRange($coupon,$time)
    {

        if ($coupon->time_constraint) {
              $startTime=strtotime($coupon->start_time);
              $endTime=strtotime($coupon->end_time);
              return !($time>=$startTime && $time<=$endTime);
        }
        return false;
    }

}