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
        $messageId = (String) $xml->xpath('//message_id')[0];
        $transactionName = (String) $xml->xpath('//transaction_name')[0];
        $partnerName = (String) $xml->xpath('//partner_name')[0];
        $partnerPassword = (String) $xml->xpath('//partner_password')[0];
        $sourceUrl = (String) $xml->xpath('//source_url')[0];
        $responseRequest = (String) $xml->xpath('//response_request')[0];
        $status_code = (int) $xml->xpath('//status_code')[0];
        $status_description = (String) $xml->xpath('//status_description')[0];
        $comments = (String) $xml->xpath('//comments')[0];
        $responseTimestamp = (String) $xml->xpath('//response_timestamp')[0];
        $fileName = (String) $xml->xpath('//filename')[0];
        $eventId = (String) $xml->xpath('//eventID')[0];

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
