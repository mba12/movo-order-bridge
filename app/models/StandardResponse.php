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
        $messageId = $xml->xpath('//message_id')[0];
        $transactionName = $xml->xpath('//transaction_name')[0];
        $partnerName = $xml->xpath('//partner_name')[0];
        $partnerPassword = $xml->xpath('//partner_password')[0];
        $sourceUrl = $xml->xpath('//source_url')[0];
        $responseRequest = $xml->xpath('//response_request')[0];
        $status_code = $xml->xpath('//status_code')[0];
        $status_description = $xml->xpath('//status_description')[0];
        $comments = $xml->xpath('//comments')[0];
        $responseTimestamp = $xml->xpath('//response_timestamp')[0];
        $fileName = $xml->xpath('//filename')[0];
        $eventId = $xml->xpath('//eventID')[0];

        $response = StandardResponse::create([

            'message_id' => $messageId,
            'transaction_name' => $transactionName,
            'partner_name' => $partnerName,
            'partner_password' => $partnerPassword,
            'source_url' => $sourceUrl,
            'response_request' => $responseRequest,
            'status_code' => $status_code,
            'status_description' => $status_description,
            'comments' => $comments,
            'response_timestamp' => $responseTimestamp,
            'filename' => $fileName,
            'eventID' => $eventId,
        ]);

        $response->save();
    }


}
