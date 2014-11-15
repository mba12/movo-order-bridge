<?php

class CouponController extends \BaseController
{


    public function check($code)
    {
        $coupon = Coupon::where("code", "=", $code)->first();
        if ($coupon) {
            $instanceCount = CouponInstance::where("code", "=", $code)->count();
            if ($instanceCount <= $coupon->limit || $coupon->limit == 0) {

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
    }
}