<?php

class StandardResponse extends \Eloquent
{

    protected $fillable = [
        'message_id',
        'transaction_name',
        'partner_name',
        'partner_password',
        'source_url',
        'response_request',
        'status_code',
        'status_description',
        'comments',
        'response_timestamp',
        'filename',
        'eventID',
    ];

    public function parseAndSaveData($orderId, $xmlString)
    {
        Log::info("Standard Response::Incoming String: " . $xmlString);

        $xml = simplexml_load_string($xmlString);
        //$xml = new SimpleXMLElement($xmlString);

        $messageId = $xml->xpath('//message-id');
        $transactionName = $xml->xpath('//transaction-name');
        $partnerName = $xml->xpath('//partner-name');
        $sourceUrl = $xml->xpath('//source-url');
        $responseRequest = $xml->xpath('//response-request');
        $status_code = $xml->xpath('//status-code');
        $status_description = $xml->xpath('//status-description');
        $comments = $xml->xpath('//comments');
        $responseTimestamp = $xml->xpath('//response-timestamp');
        $fileName = $xml->xpath('//filename');
        $eventId = $xml->xpath('//eventID');

        $response = StandardResponse::create([

            'message_id' => (String) $messageId[0],
            'order_id' => intval($orderId),
            'transaction_name' => (String) $transactionName[0],
            'partner_name' => (String) $partnerName[0],
            'partner_password' => '',
            'source_url' => (String) $sourceUrl[0],
            'response_request' => (String) $responseRequest[0],
            'status_code' => intval($status_code[0]),
            'status_description' => (String) $status_description[0],
            'comments' => (String) $comments[0],
            'response_timestamp' => (String) $responseTimestamp[0],
            'filename' => (String) $fileName[0],
            'eventID' => (String) $eventId[0],
        ]);

        $response->save();
    }

    public function logTransmissionError($orderId, $url, $description, $comments)
    {

        $responseTimestamp = date('Ymd:His:e');

        $response = StandardResponse::create([
            'order_id' => intval($orderId),
            'transaction_name' => 'Failed transaction',
            'source_url' => $url,
            'status_code' => -1,
            'status_description' => $description,
            'comments' => $comments,
            'response_timestamp' => $responseTimestamp,
        ]);

        $response->save();
    }

}
