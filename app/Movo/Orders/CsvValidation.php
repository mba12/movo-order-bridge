<?php
/**
 * Created by PhpStorm.
 * User: ahern
 * Date: 3/31/15
 * Time: 9:28 AM
 */

namespace Movo\Orders;

class CsvValidation {

    // Validates an expected csv header row against the first row in a csv data input file
    public static function validateHeaders($header, $data)
    {
        $size = count($header);
        for($i = 0; $i < $size; $i++) {
            if (strcmp ( $header[$i] , $data[$i] ) != 0) {
                return false;
            }
        }

        return true;
    }

}