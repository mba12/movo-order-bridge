<?php

class IngramTest extends TestCase
{

    public function tearDown()
    {
        Mockery::close();
    }

    public function test_it_should_send_xml_as_body()
    {
        $client = new GuzzleHttp\Client();
        $response = $client->post('http://movo.app:8000/ingram/track-inventory', [
            'body' =>"<message>
  <message-header>
    <message-id>129620978</message-id>
    <transaction-name>sales-order-rejection</transaction-name>
    <partner-name>customer</partner-name>
    <source-url>http://www.brightpoint.com</source-url>
    <create-timestamp>2010-06-17T00:51:50.971-04:00</create-timestamp>
    <response-request>1</response-request>
  </message-header>
  <sales-order-rejection>
    <header>
      <customer-id>286104</customer-id>
      <shipment-information>
        <ship-first-name>chris</ship-first-name>
        <ship-last-name>chris</ship-last-name>
        <ship-address1>3671 Norfolk Drive</ship-address1>
        <ship-city>Somewhere</ship-city>
        <ship-state>IN</ship-state>
        <ship-post-code>12345</ship-post-code>
        <ship-country-code>US</ship-country-code>
        <ship-phone1>(317)555-5306</ship-phone1>
        <ship-email>montnapa@yahoo.com</ship-email>
        <ship-via>SFXSVP</ship-via>
        <ship-request-date>2010-06-16T00:00:00</ship-request-date>
        <ship-request-warehouse>whse1</ship-request-warehouse>
      </shipment-information>
      <purchase-order-information>
        <purchase-order-number>206285</purchase-order-number>
        <account-description/>
        <comments>Duplicate order</comments>
      </purchase-order-information>
      <order-header>
        <customer-order-number>206285</customer-order-number>
        <customer-order-date>20100616</customer-order-date>
        <order-sub-total>0.0</order-sub-total>
        <order-discount>0.0</order-discount>
        <order-tax1>0.0</order-tax1>
        <order-tax2>0.0</order-tax2>
        <order-tax3>0.0</order-tax3>
        <order-shipment-charge>0.0</order-shipment-charge>
        <order-total-net>0.0</order-total-net>
      </order-header>
    </header>
    <detail>
      <line-item>
        <line-no>0</line-no>
        <item-code>TKAKN10001</item-code>
        <quantity>1</quantity>
        <unit-of-measure>EA</unit-of-measure>
        <line-status>REJECTED</line-status>
        <comments> Domino</comments>
        <rejection-date>20100617</rejection-date>
        <line-discount>0.0</line-discount>
        <line-tax1>0.0</line-tax1>
        <line-tax2>0.0</line-tax2>
        <line-tax3>0.0</line-tax3>
      </line-item>
    </detail>
  </sales-order-rejection>
  <transactionInfo>
    <eventID>129620978</eventID>
  </transactionInfo>
</message>"
        ]);

      $this->assertTrue(strpos(json_encode($response->xml()), "SUCCESS") !== FALSE);
    }



}
