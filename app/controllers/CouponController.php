<?php

class CouponController extends \BaseController
{


    /**
     * @param $code
     * @param $quantity
     * @return null
     */
    public function check($code, $quantity)
    {
        $result = [];
        $coupon = Coupon::where("code", "=", $code)->where("active", "=", 1)->first();
        if ($coupon) {
            if ($this->outsideTimeRange($coupon, time())) {
                $result['error'] = [
                    "message" => "This coupon has expired."
                ];
            }
            $instanceCount = $instanceCount = CouponInstance::where("code", "=", $code)->count();
            if ($this->couponLimitReached($coupon, $quantity, $instanceCount)) {
                $result['error'] = [
                    "message" => "This coupon code is no longer valid."
                ];
            }

            if ($this->tooFewUnits($coupon, $quantity)) {
                $result['error'] = [
                    "message" => "You must order at least " . $coupon->min_units . " to use this coupon."
                ];
            }

            if (!isset($result['error'])) {
                $token = str_random(40);
                CouponInstance::create([
                    "code" => $code,
                    "token" => $token,
                    "used" => 0
                ]);
                $result['token'] = $token;
                $result['coupon'] = $coupon;
            }
        }else{
            $result['error'] = [
                "message" => "That coupon code is invalid."
            ];
        }
        return $result;
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


    public function deleteCoupon($id){
        $coupon=Coupon::find($id);
        if(isset($coupon)){
            $code=$coupon->code;
            $instances=CouponInstance::where("code", "=", $code);
            $instances->delete();
            $coupon->delete();


        }
        return Redirect::to('/admin/coupons');;
    }

    public function addCoupon(){

        $rules=["name"=>"required"];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            return Redirect::to('/admin/coupons')->with("add-coupon-message","Please include a name for your coupon");
        }

        Coupon::create([
            "name"=>Input::get("name"),
            "code"=>Input::get("name"),
            "amount"=>0,
            "method"=>"%",
            "limit"=>0,
            "min_units"=>1,
            "start_time"=>date("Y-m-m"),
            "end_time"=>date("Y-m-m"),
            "min_units"=>1,
            "time_constraint"=>0,
            "active"=>0,
        ]);
        return Redirect::to('/admin/coupons')->with("add-coupon-message","Your coupon was added");
    }

    /**
     * @param $coupon
     * @param $quantity
     * @param $instanceCount
     * @return bool
     * @internal param $code
     */
    public function couponLimitReached($coupon, $quantity, $instanceCount)
    {

        if (($instanceCount < $coupon->limit || $coupon->limit == 0) && $coupon->min_units <= $quantity) {
            return false;
        }
        return true;
    }


    /**
     * @param $coupon
     * @param $time
     * @return bool
     */
    public function outsideTimeRange($coupon, $time)
    {

        if ($coupon->time_constraint) {
            $startTime = strtotime($coupon->start_time);
            $endTime = strtotime($coupon->end_time);
            return !($time >= $startTime && $time <= $endTime);
        }
        return false;
    }

    /**
     * @param $coupon
     * @param $quantity
     * @return bool
     */
    private function tooFewUnits($coupon, $quantity)
    {
        return $coupon->min_units>$quantity;
    }

}