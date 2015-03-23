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

    public function parseAndSaveData($xmlString)
    {
        Log::info("Incoming String: " . $xmlString);
        $xml = new SimpleXMLElement($xmlString);

        $testArray = $xml->message_id;
        Log::info("Test: " . $testArray);

        //$messageId = $xml->xpath('//message_id');
        $messageId = $xml->message_id;
        // $transactionName = $xml->xpath('//transaction_name');
        $transactionName = $xml->transaction_name;
        $partnerName = $xml->xpath('//partner_name');
        $partnerPassword = $xml->xpath('//partner_password');
        $sourceUrl = $xml->xpath('//source_url');
        $responseRequest = $xml->xpath('//response_request');
        $status_code = $xml->xpath('//status_code');
        $status_description = $xml->xpath('//status_description');
        $comments = $xml->xpath('//comments');
        $responseTimestamp = $xml->xpath('//response_timestamp');
        $fileName = $xml->xpath('//filename');
        $eventId = $xml->xpath('//eventID');

        $response = StandardResponse::create([

            'message_id' => (String) $messageId,
            'transaction_name' => (String) $transactionName,
            'partner_name' => (String) $partnerName[0],
            'partner_password' => (String) $partnerPassword[0],
            'source_url' => (String) $sourceUrl[0],
            'response_request' => (String) $responseRequest[0],
            'status_code' => (int) $status_code[0],
            'status_description' => (String) $status_description[0],
            'comments' => (String) $comments[0],
            'response_timestamp' => (String) $responseTimestamp[0],
            'filename' => (String) $fileName[0],
            'eventID' => (String) $eventId[0],
        ]);

        $response->save();
    }


}
