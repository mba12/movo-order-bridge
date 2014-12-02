<?php
/**
 * Created by IntelliJ IDEA.
 * User: Alex
 * Date: 12/1/2014
 * Time: 9:17 AM
 */

namespace Movo\Shipping;


use Movo\Helpers\Format;

class ShippingDropdown {
    public static function  createData($shippingInfo)
    {
        $shippingTypes = "";
        $shippingIds = "";
        $shippingRates = "";
        $i = 0;
        foreach ($shippingInfo as $info) {
            if ($i > 0) {
                $shippingTypes .= '|';
                $shippingIds .= '|';
                $shippingRates .= '|';
            }
            $shippingTypes .= $info->type;
            $shippingIds .= $info->id;
            $shippingRates .= Format::FormatDecimals($info->rate);
            $i++;
        }
        $dropdownData = [
            'shippingTypes' => $shippingTypes,
            'shippingIds' => $shippingIds,
            'shippingRates' => $shippingRates,
        ];
        return $dropdownData;
    }
}