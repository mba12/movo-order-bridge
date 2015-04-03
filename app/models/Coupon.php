<?php

use Movo\Helpers\Format;

class Coupon extends \Eloquent
{
    protected $fillable = [
        'name', 'code', 'amount', 'method', 'limit', 'min_units', 'start_time', 'end_time', 'time_constraint', 'active'
    ];

    public function instances()
    {
        return $this->hasMany('CouponInstance', "code", "code");
    }

    public function usedCoupons()
    {
        return $this->instances()->where("used", "=", 1);
    }

    public function usedCouponCount()
    {
        return Order::where("coupon","=", $this->code)->where("stripe_charge_id","!=", "")->count();
    }

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
        // TODO: Michael - have this function extract the values from Input and then call the function below.
        // NOTE: code is duplicated in the method below
        if (Input::has("code") && Input::has("coupon_instance")) {
            $validCoupon = CouponInstance::where("code", "=", Input::get("code"))
                ->where("token", "=", Input::get("coupon_instance"))
                ->where("used", "=", 0)->first();
            if ($validCoupon) {
                $couponInstance = Coupon::where("code", "=", Input::get("code"))
                    ->where("active", "=", 1)
                    ->first();
                if ($couponInstance) {
                    if ($couponInstance->min_units == 0 || $couponInstance->min_units <= Input::get("quantity")) {
                        $validCoupon->used = 1;
                        $validCoupon->save();
                        return $couponInstance;
                    }
                }
            }
        }
        return null;
    }

    public static function getValidCouponInstanceCSV($data)
    {
        if (isset($data["code"]) && isset($data["coupon_instance"])) {
            $validCoupon = CouponInstance::where("code", "=", $data["code"])
                ->where("token", "=", $data["coupon_instance"])
                ->where("used", "=", 0)->first();
            if ($validCoupon) {
                $couponInstance = Coupon::where("code", "=", $data["code"])
                    ->where("active", "=", 1)
                    ->first();
                if ($couponInstance) {
                    if ($couponInstance->min_units == 0 || $couponInstance->min_units <= $data["quantity"]) {
                        $validCoupon->used = 1;
                        $validCoupon->save();
                        return $couponInstance;
                    }
                }
            }
        }

        return null;
    }
}