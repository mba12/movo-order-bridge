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
        $emailData['address1'] = $data['address1'];
        $emailData['address2'] = $data['address2'];
        $emailData['address3'] = $data['address3'];
        $emailData['address4'] = $data['address4'];
        $emailData['name'] = $data['name'];
        $emailData['total'] = Format::FormatStripeMoney($data['result']['amount']);
        $emailData['quantity'] = $data['quantity'];
        return $emailData;
    }
}