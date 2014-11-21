<?php
/**
 * Created by IntelliJ IDEA.
 * User: Alex
 * Date: 11/12/2014
 * Time: 10:12 AM
 */

namespace Movo\Receipts;


use Illuminate\Support\Facades\Input;
use Movo\Helpers\Format;

class Receipt {
    public  function createEmailData($data)
    {
        $emailData['items'] = $data['items'];
        if($data['couponInstance']){
            $discount = $data['couponInstance'] ? $data['couponInstance']->calculateCouponDiscount($data['unit-price'], $data['quantity']) : 0;
            $emailData['discount'] = Format::FormatUSD($discount);
        }
        $emailData['shippingAddress'] = $data['shippingAddress'];
        $emailData['total'] = Format::FormatStripeMoney($data['result']['amount']);
        $emailData['shipping-rate'] = Format::FormatUSD($data['shipping-rate']);
        $emailData['shipping-type'] = $data['shipping-type'];
        return $emailData;
    }
}