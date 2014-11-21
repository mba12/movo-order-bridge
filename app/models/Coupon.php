<?php

use Movo\Helpers\Format;

class Coupon extends \Eloquent
{
    protected $fillable = [
        //	'name','code','amount','method','limit','min_units'
    ];

    public function calculateCouponDiscount($unitPrice, $quantity)
    {
        if ($this->method == "%") {
            return Format::FormatDecimals(($unitPrice * $quantity) * ($this->amount / 100));
        } else {
            return $this->amount;
        }

    }

    public static function getValidCouponInstance()
    {
        if (Input::has("code")&& Input::has("coupon_instance")) {
            $validCoupon = CouponInstance::where("code", "=", Input::get("code"))
                ->where("token", "=", Input::get("coupon_instance"))
                ->where("used", "=", 0)->first();
             if ($validCoupon) {
                $couponInstance = Coupon::where("code", "=", Input::get("code"))->first();
                if ($couponInstance) {
                    if ($couponInstance->min_units == 0 || $couponInstance->min_units <= Input::get("quantity")) {
                        $validCoupon->used=1;
                        $validCoupon->save();
                        return $couponInstance;
                    }
                }
            }
        }
        return null;
    }
}