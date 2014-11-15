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
    protected  function createEmailData($data)
    {
        $emailData['items'] = [];
        for ($i = 0; $i < Input::get("quantity"); $i++) {
            array_push($emailData['items'], new Item(Input::get("unit" . ($i + 1)), 1, Format::FormatUSD($data['unit-price'])));
        }
        if($data['couponData']){
            $discount = $data['couponData'] ? $data['couponData']->calculateDiscount($data['unit-price'], Input::get("quantity")) : 0;
            $emailData['discount'] = Format::FormatUSD($discount);
        }
        $emailData['total'] = Format::FormatStripeMoney($data['result']['amount']);
        $emailData['shipping-rate'] = Format::FormatUSD($data['shipping-rate']);
        $emailData['shipping-type'] = $data['shipping-type'];
        return $emailData;
    }
}