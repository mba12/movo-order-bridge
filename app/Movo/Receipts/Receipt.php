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
        $emailData['address1'] = (isset($data['address1']) && strlen($data['address1']) > 0)?$data['address1']:'';;
        $emailData['address2'] = (isset($data['address2']) && strlen($data['address2']) > 0)?$data['address2']:'';;
        $emailData['address3'] = (isset($data['address3']) && strlen($data['address3']) > 0)?$data['address3']:'';
        $emailData['address4'] = $data['address4'];
        $emailData['name'] = $data['name'];
        $emailData['total'] = Format::FormatStripeMoney($data['result']['amount']);
        $emailData['quantity'] = $data['quantity'];
        return $emailData;
    }
}