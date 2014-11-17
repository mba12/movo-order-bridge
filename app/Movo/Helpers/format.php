<?php


namespace Movo\Helpers;


class Format
{
    public static function FormatStripeMoney($cents)
    {
        return '$' . number_format($cents / 100, 2, '.', ',');
    }

    public static function FormatUSD($amount)
    {
        return '$' . number_format($amount, 2, '.', ',');
    }

    public static function FormatDecimals($amount)
    {
        return  number_format($amount, 2, '.', ',');
    }
}