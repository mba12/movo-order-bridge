<?php

class StandardResponse extends \Eloquent
{

    protected $fillable = [
        'order_id',
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

        $pos = strpos($xmlString, "Service Unavailable");
        $responseStr = '';
        if ( $pos === false ) {
            // then the response is good
            $responseStr = $xmlString;
        } else {
            // In the event that the Brightpoint service is down log that status
            $timestamp = \Faker\Provider\DateTime::iso8601();

$response = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<message>
    <message-header>
        <message-id>12345</message-id>
        <transaction-name>sales-order-submission</transaction-name>
        <partner-name>Brightpoint North America L.P.</partner-name>
        <source-url>http://messagehub.brightpoint.com:9135/HttpPost</source-url>
        <create-timestamp>{$timestamp}</create-timestamp>
        <response-request>0</response-request>
    </message-header>
    <message-status>
        <status-code>-100</status-code>
        <status-description>Message ERROR</status-description>
        <comments>SERVICE UNAVAILABLE</comments>
        <response-timestamp>{$timestamp}</response-timestamp>
        <filename>Business Process ID</filename>
    </message-status>
    <transactionInfo>
        <eventID>12345</eventID>
    </transactionInfo>
</message>
EOF;

            $responseStr = $response;

        }

        $xml = simplexml_load_string($responseStr);

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

        if ( $pos === false ) {
            // then the response is good
            $order=Order::find($orderId)->first();
            $order->ingram_order_id = (String) $responseTimestamp[0];
            $order->save();
        }

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

    private function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

}
