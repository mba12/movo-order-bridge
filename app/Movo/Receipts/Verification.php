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

class Verification {
    public  function createEmailData($data)
    {
        $emailData['fullName'] = $data['first'] . " " . $data['last'];
        $emailData['email'] = $data['email'];
        $emailData['key'] = $data['key'];
        $emailData['id'] = $data['id'];
        return $emailData;
    }
}