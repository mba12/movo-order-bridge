<?xml version="1.0" encoding="UTF-8"?>
<message xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="file://BPXML-ReturnReceipt.xsd">
    <message-header>
        <message-id>9</message-id>
        <transaction-name>return-receipt</transaction-name>
        <partner-name>test string</partner-name>
        <source-url>test string</source-url>
        <create-timestamp>test string</create-timestamp>
        <response-request>test string</response-request>
    </message-header>
    <return-receipt>
        <header>
            <customer-id>test string</customer-id>
            <business-name>test string</business-name>
            <carrier-name>test string</carrier-name>
            <customer-information>
                <customer-first-name>test string</customer-first-name>
                <customer-last-name>test string</customer-last-name>
                <customer-middle-initial>test string</customer-middle-initial>
                <customer-address1>test string</customer-address1>
                <customer-address2>test string</customer-address2>
                <customer-address3>test string</customer-address3>
                <customer-city>test string</customer-city>
                <customer-state>test string</customer-state>
                <customer-post-code>test string</customer-post-code>
                <customer-country-code>test string</customer-country-code>
                <customer-phone1>test string</customer-phone1>
                <customer-phone2>test string</customer-phone2>
                <customer-fax>test string</customer-fax>
                <customer-email>test string</customer-email>
            </customer-information>
            <shipment-information>
                <ship-first-name>test string</ship-first-name>
                <ship-last-name>test string</ship-last-name>
                <ship-middle-initial>test string</ship-middle-initial>
                <ship-address1>test string</ship-address1>
                <ship-address2>test string</ship-address2>
                <ship-address3>test string</ship-address3>
                <ship-city>test string</ship-city>
                <ship-state>test string</ship-state>
                <ship-post-code>test string</ship-post-code>
                <ship-country-code>test string</ship-country-code>
                <ship-phone1>test string</ship-phone1>
                <ship-phone2>test string</ship-phone2>
                <ship-fax>test string</ship-fax>
                <ship-email>test string</ship-email>
                <ship-via>test string</ship-via>
                <ship-request-date>test string</ship-request-date>
                <ship-request-from>test string</ship-request-from>
                <ship-request-warehouse>test string</ship-request-warehouse>
                <ship-to-code>test string</ship-to-code>
            </shipment-information>
            <purchase-order-information>
                <purchase-order-number>test string</purchase-order-number>
                <account-description>test string</account-description>
                <purchase-order-amount>test string</purchase-order-amount>
                <purchase-order-event>test string</purchase-order-event>
                <currency-code>test string</currency-code>
                <comments>test string</comments>
            </purchase-order-information>
            <credit-card-information>
                <credit-card-number>test string</credit-card-number>
                <credit-card-expiration-date>test string</credit-card-expiration-date>
                <credit-card-identification>test string</credit-card-identification>
                <global-card-classification-code>test string</global-card-classification-code>
                <card-holder-name>test string</card-holder-name>
                <card-holder-address1>test string</card-holder-address1>
                <card-holder-address2>test string</card-holder-address2>
                <card-holder-city>test string</card-holder-city>
                <card-holder-state>test string</card-holder-state>
                <card-holder-post-code>test string</card-holder-post-code>
                <card-holder-country-code>test string</card-holder-country-code>
                <authorized-amount>test string</authorized-amount>
                <billing-sequence-number>test string</billing-sequence-number>
                <billing-authorization-response>test string</billing-authorization-response>
                <billing-address-match>test string</billing-address-match>
                <billing-zip-match>test string</billing-zip-match>
                <avs-hold>test string</avs-hold>
                <merchant-name>test string</merchant-name>
            </credit-card-information>
            <order-header>
                <customer-order-number>test string</customer-order-number>
                <customer-order-date>test string</customer-order-date>
                <brightpoint-order-number>test string</brightpoint-order-number>
                <order-reference>test string</order-reference>
                <brightpoint-return-number>test string</brightpoint-return-number>
                <order-status>test string</order-status>
                <order-sub-total>test string</order-sub-total>
                <order-discount>test string</order-discount>
                <order-tax1>test string</order-tax1>
                <order-tax2>test string</order-tax2>
                <order-tax3>test string</order-tax3>
                <order-shipment-charge>test string</order-shipment-charge>
                <order-total-net>test string</order-total-net>
                <order-type>test string</order-type>
                <gift-flag>test string</gift-flag>
            </order-header>
        </header>
        <detail>
            <line-item>
                <line-no>test string</line-no>
                <line-reference>test string</line-reference>
                <transaction-id>test string</transaction-id>
                <item-code>test string</item-code>
                <universal-product-code>test string</universal-product-code>
                <product-name>test string</product-name>
                <quantity>test string</quantity>
                <unit-of-measure>test string</unit-of-measure>
                <serial-list>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                </serial-list>
                <serial-list>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                </serial-list>
                <serial-list>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                </serial-list>
                <market-id>test string</market-id>
                <line-status>test string</line-status>
                <comments>test string</comments>
                <rejection-date>test string</rejection-date>
                <base-price>test string</base-price>
                <line-discount>test string</line-discount>
                <line-tax1>test string</line-tax1>
                <line-tax2>test string</line-tax2>
                <line-tax3>test string</line-tax3>
                <receipt-date>test string</receipt-date>
                <service-type>test string</service-type>
                <return-reason-code>test string</return-reason-code>
                <failure-reason>test string</failure-reason>
                <special-message>
                    <special-message1>test string</special-message1>
                    <special-message2>test string</special-message2>
                    <special-message3>test string</special-message3>
                    <special-message4>test string</special-message4>
                    <special-message5>test string</special-message5>
                </special-message>
            </line-item>
            <line-item>
                <line-no>test string</line-no>
                <line-reference>test string</line-reference>
                <transaction-id>test string</transaction-id>
                <item-code>test string</item-code>
                <universal-product-code>test string</universal-product-code>
                <product-name>test string</product-name>
                <quantity>test string</quantity>
                <unit-of-measure>test string</unit-of-measure>
                <serial-list>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                </serial-list>
                <serial-list>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                </serial-list>
                <serial-list>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                </serial-list>
                <market-id>test string</market-id>
                <line-status>test string</line-status>
                <comments>test string</comments>
                <rejection-date>test string</rejection-date>
                <base-price>test string</base-price>
                <line-discount>test string</line-discount>
                <line-tax1>test string</line-tax1>
                <line-tax2>test string</line-tax2>
                <line-tax3>test string</line-tax3>
                <receipt-date>test string</receipt-date>
                <service-type>test string</service-type>
                <return-reason-code>test string</return-reason-code>
                <failure-reason>test string</failure-reason>
                <special-message>
                    <special-message1>test string</special-message1>
                    <special-message2>test string</special-message2>
                    <special-message3>test string</special-message3>
                    <special-message4>test string</special-message4>
                    <special-message5>test string</special-message5>
                </special-message>
            </line-item>
            <line-item>
                <line-no>test string</line-no>
                <line-reference>test string</line-reference>
                <transaction-id>test string</transaction-id>
                <item-code>test string</item-code>
                <universal-product-code>test string</universal-product-code>
                <product-name>test string</product-name>
                <quantity>test string</quantity>
                <unit-of-measure>test string</unit-of-measure>
                <serial-list>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                </serial-list>
                <serial-list>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                </serial-list>
                <serial-list>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                </serial-list>
                <market-id>test string</market-id>
                <line-status>test string</line-status>
                <comments>test string</comments>
                <rejection-date>test string</rejection-date>
                <base-price>test string</base-price>
                <line-discount>test string</line-discount>
                <line-tax1>test string</line-tax1>
                <line-tax2>test string</line-tax2>
                <line-tax3>test string</line-tax3>
                <receipt-date>test string</receipt-date>
                <service-type>test string</service-type>
                <return-reason-code>test string</return-reason-code>
                <failure-reason>test string</failure-reason>
                <special-message>
                    <special-message1>test string</special-message1>
                    <special-message2>test string</special-message2>
                    <special-message3>test string</special-message3>
                    <special-message4>test string</special-message4>
                    <special-message5>test string</special-message5>
                </special-message>
            </line-item>
        </detail>
    </return-receipt>
    <return-receipt>
        <header>
            <customer-id>test string</customer-id>
            <business-name>test string</business-name>
            <carrier-name>test string</carrier-name>
            <customer-information>
                <customer-first-name>test string</customer-first-name>
                <customer-last-name>test string</customer-last-name>
                <customer-middle-initial>test string</customer-middle-initial>
                <customer-address1>test string</customer-address1>
                <customer-address2>test string</customer-address2>
                <customer-address3>test string</customer-address3>
                <customer-city>test string</customer-city>
                <customer-state>test string</customer-state>
                <customer-post-code>test string</customer-post-code>
                <customer-country-code>test string</customer-country-code>
                <customer-phone1>test string</customer-phone1>
                <customer-phone2>test string</customer-phone2>
                <customer-fax>test string</customer-fax>
                <customer-email>test string</customer-email>
            </customer-information>
            <shipment-information>
                <ship-first-name>test string</ship-first-name>
                <ship-last-name>test string</ship-last-name>
                <ship-middle-initial>test string</ship-middle-initial>
                <ship-address1>test string</ship-address1>
                <ship-address2>test string</ship-address2>
                <ship-address3>test string</ship-address3>
                <ship-city>test string</ship-city>
                <ship-state>test string</ship-state>
                <ship-post-code>test string</ship-post-code>
                <ship-country-code>test string</ship-country-code>
                <ship-phone1>test string</ship-phone1>
                <ship-phone2>test string</ship-phone2>
                <ship-fax>test string</ship-fax>
                <ship-email>test string</ship-email>
                <ship-via>test string</ship-via>
                <ship-request-date>test string</ship-request-date>
                <ship-request-from>test string</ship-request-from>
                <ship-request-warehouse>test string</ship-request-warehouse>
                <ship-to-code>test string</ship-to-code>
            </shipment-information>
            <purchase-order-information>
                <purchase-order-number>test string</purchase-order-number>
                <account-description>test string</account-description>
                <purchase-order-amount>test string</purchase-order-amount>
                <purchase-order-event>test string</purchase-order-event>
                <currency-code>test string</currency-code>
                <comments>test string</comments>
            </purchase-order-information>
            <credit-card-information>
                <credit-card-number>test string</credit-card-number>
                <credit-card-expiration-date>test string</credit-card-expiration-date>
                <credit-card-identification>test string</credit-card-identification>
                <global-card-classification-code>test string</global-card-classification-code>
                <card-holder-name>test string</card-holder-name>
                <card-holder-address1>test string</card-holder-address1>
                <card-holder-address2>test string</card-holder-address2>
                <card-holder-city>test string</card-holder-city>
                <card-holder-state>test string</card-holder-state>
                <card-holder-post-code>test string</card-holder-post-code>
                <card-holder-country-code>test string</card-holder-country-code>
                <authorized-amount>test string</authorized-amount>
                <billing-sequence-number>test string</billing-sequence-number>
                <billing-authorization-response>test string</billing-authorization-response>
                <billing-address-match>test string</billing-address-match>
                <billing-zip-match>test string</billing-zip-match>
                <avs-hold>test string</avs-hold>
                <merchant-name>test string</merchant-name>
            </credit-card-information>
            <order-header>
                <customer-order-number>test string</customer-order-number>
                <customer-order-date>test string</customer-order-date>
                <brightpoint-order-number>test string</brightpoint-order-number>
                <order-reference>test string</order-reference>
                <brightpoint-return-number>test string</brightpoint-return-number>
                <order-status>test string</order-status>
                <order-sub-total>test string</order-sub-total>
                <order-discount>test string</order-discount>
                <order-tax1>test string</order-tax1>
                <order-tax2>test string</order-tax2>
                <order-tax3>test string</order-tax3>
                <order-shipment-charge>test string</order-shipment-charge>
                <order-total-net>test string</order-total-net>
                <order-type>test string</order-type>
                <gift-flag>test string</gift-flag>
            </order-header>
        </header>
        <detail>
            <line-item>
                <line-no>test string</line-no>
                <line-reference>test string</line-reference>
                <transaction-id>test string</transaction-id>
                <item-code>test string</item-code>
                <universal-product-code>test string</universal-product-code>
                <product-name>test string</product-name>
                <quantity>test string</quantity>
                <unit-of-measure>test string</unit-of-measure>
                <serial-list>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                </serial-list>
                <serial-list>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                </serial-list>
                <serial-list>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                </serial-list>
                <market-id>test string</market-id>
                <line-status>test string</line-status>
                <comments>test string</comments>
                <rejection-date>test string</rejection-date>
                <base-price>test string</base-price>
                <line-discount>test string</line-discount>
                <line-tax1>test string</line-tax1>
                <line-tax2>test string</line-tax2>
                <line-tax3>test string</line-tax3>
                <receipt-date>test string</receipt-date>
                <service-type>test string</service-type>
                <return-reason-code>test string</return-reason-code>
                <failure-reason>test string</failure-reason>
                <special-message>
                    <special-message1>test string</special-message1>
                    <special-message2>test string</special-message2>
                    <special-message3>test string</special-message3>
                    <special-message4>test string</special-message4>
                    <special-message5>test string</special-message5>
                </special-message>
            </line-item>
            <line-item>
                <line-no>test string</line-no>
                <line-reference>test string</line-reference>
                <transaction-id>test string</transaction-id>
                <item-code>test string</item-code>
                <universal-product-code>test string</universal-product-code>
                <product-name>test string</product-name>
                <quantity>test string</quantity>
                <unit-of-measure>test string</unit-of-measure>
                <serial-list>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                </serial-list>
                <serial-list>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                </serial-list>
                <serial-list>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                </serial-list>
                <market-id>test string</market-id>
                <line-status>test string</line-status>
                <comments>test string</comments>
                <rejection-date>test string</rejection-date>
                <base-price>test string</base-price>
                <line-discount>test string</line-discount>
                <line-tax1>test string</line-tax1>
                <line-tax2>test string</line-tax2>
                <line-tax3>test string</line-tax3>
                <receipt-date>test string</receipt-date>
                <service-type>test string</service-type>
                <return-reason-code>test string</return-reason-code>
                <failure-reason>test string</failure-reason>
                <special-message>
                    <special-message1>test string</special-message1>
                    <special-message2>test string</special-message2>
                    <special-message3>test string</special-message3>
                    <special-message4>test string</special-message4>
                    <special-message5>test string</special-message5>
                </special-message>
            </line-item>
            <line-item>
                <line-no>test string</line-no>
                <line-reference>test string</line-reference>
                <transaction-id>test string</transaction-id>
                <item-code>test string</item-code>
                <universal-product-code>test string</universal-product-code>
                <product-name>test string</product-name>
                <quantity>test string</quantity>
                <unit-of-measure>test string</unit-of-measure>
                <serial-list>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                </serial-list>
                <serial-list>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                </serial-list>
                <serial-list>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                </serial-list>
                <market-id>test string</market-id>
                <line-status>test string</line-status>
                <comments>test string</comments>
                <rejection-date>test string</rejection-date>
                <base-price>test string</base-price>
                <line-discount>test string</line-discount>
                <line-tax1>test string</line-tax1>
                <line-tax2>test string</line-tax2>
                <line-tax3>test string</line-tax3>
                <receipt-date>test string</receipt-date>
                <service-type>test string</service-type>
                <return-reason-code>test string</return-reason-code>
                <failure-reason>test string</failure-reason>
                <special-message>
                    <special-message1>test string</special-message1>
                    <special-message2>test string</special-message2>
                    <special-message3>test string</special-message3>
                    <special-message4>test string</special-message4>
                    <special-message5>test string</special-message5>
                </special-message>
            </line-item>
        </detail>
    </return-receipt>
    <return-receipt>
        <header>
            <customer-id>test string</customer-id>
            <business-name>test string</business-name>
            <carrier-name>test string</carrier-name>
            <customer-information>
                <customer-first-name>test string</customer-first-name>
                <customer-last-name>test string</customer-last-name>
                <customer-middle-initial>test string</customer-middle-initial>
                <customer-address1>test string</customer-address1>
                <customer-address2>test string</customer-address2>
                <customer-address3>test string</customer-address3>
                <customer-city>test string</customer-city>
                <customer-state>test string</customer-state>
                <customer-post-code>test string</customer-post-code>
                <customer-country-code>test string</customer-country-code>
                <customer-phone1>test string</customer-phone1>
                <customer-phone2>test string</customer-phone2>
                <customer-fax>test string</customer-fax>
                <customer-email>test string</customer-email>
            </customer-information>
            <shipment-information>
                <ship-first-name>test string</ship-first-name>
                <ship-last-name>test string</ship-last-name>
                <ship-middle-initial>test string</ship-middle-initial>
                <ship-address1>test string</ship-address1>
                <ship-address2>test string</ship-address2>
                <ship-address3>test string</ship-address3>
                <ship-city>test string</ship-city>
                <ship-state>test string</ship-state>
                <ship-post-code>test string</ship-post-code>
                <ship-country-code>test string</ship-country-code>
                <ship-phone1>test string</ship-phone1>
                <ship-phone2>test string</ship-phone2>
                <ship-fax>test string</ship-fax>
                <ship-email>test string</ship-email>
                <ship-via>test string</ship-via>
                <ship-request-date>test string</ship-request-date>
                <ship-request-from>test string</ship-request-from>
                <ship-request-warehouse>test string</ship-request-warehouse>
                <ship-to-code>test string</ship-to-code>
            </shipment-information>
            <purchase-order-information>
                <purchase-order-number>test string</purchase-order-number>
                <account-description>test string</account-description>
                <purchase-order-amount>test string</purchase-order-amount>
                <purchase-order-event>test string</purchase-order-event>
                <currency-code>test string</currency-code>
                <comments>test string</comments>
            </purchase-order-information>
            <credit-card-information>
                <credit-card-number>test string</credit-card-number>
                <credit-card-expiration-date>test string</credit-card-expiration-date>
                <credit-card-identification>test string</credit-card-identification>
                <global-card-classification-code>test string</global-card-classification-code>
                <card-holder-name>test string</card-holder-name>
                <card-holder-address1>test string</card-holder-address1>
                <card-holder-address2>test string</card-holder-address2>
                <card-holder-city>test string</card-holder-city>
                <card-holder-state>test string</card-holder-state>
                <card-holder-post-code>test string</card-holder-post-code>
                <card-holder-country-code>test string</card-holder-country-code>
                <authorized-amount>test string</authorized-amount>
                <billing-sequence-number>test string</billing-sequence-number>
                <billing-authorization-response>test string</billing-authorization-response>
                <billing-address-match>test string</billing-address-match>
                <billing-zip-match>test string</billing-zip-match>
                <avs-hold>test string</avs-hold>
                <merchant-name>test string</merchant-name>
            </credit-card-information>
            <order-header>
                <customer-order-number>test string</customer-order-number>
                <customer-order-date>test string</customer-order-date>
                <brightpoint-order-number>test string</brightpoint-order-number>
                <order-reference>test string</order-reference>
                <brightpoint-return-number>test string</brightpoint-return-number>
                <order-status>test string</order-status>
                <order-sub-total>test string</order-sub-total>
                <order-discount>test string</order-discount>
                <order-tax1>test string</order-tax1>
                <order-tax2>test string</order-tax2>
                <order-tax3>test string</order-tax3>
                <order-shipment-charge>test string</order-shipment-charge>
                <order-total-net>test string</order-total-net>
                <order-type>test string</order-type>
                <gift-flag>test string</gift-flag>
            </order-header>
        </header>
        <detail>
            <line-item>
                <line-no>test string</line-no>
                <line-reference>test string</line-reference>
                <transaction-id>test string</transaction-id>
                <item-code>test string</item-code>
                <universal-product-code>test string</universal-product-code>
                <product-name>test string</product-name>
                <quantity>test string</quantity>
                <unit-of-measure>test string</unit-of-measure>
                <serial-list>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                </serial-list>
                <serial-list>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                </serial-list>
                <serial-list>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                </serial-list>
                <market-id>test string</market-id>
                <line-status>test string</line-status>
                <comments>test string</comments>
                <rejection-date>test string</rejection-date>
                <base-price>test string</base-price>
                <line-discount>test string</line-discount>
                <line-tax1>test string</line-tax1>
                <line-tax2>test string</line-tax2>
                <line-tax3>test string</line-tax3>
                <receipt-date>test string</receipt-date>
                <service-type>test string</service-type>
                <return-reason-code>test string</return-reason-code>
                <failure-reason>test string</failure-reason>
                <special-message>
                    <special-message1>test string</special-message1>
                    <special-message2>test string</special-message2>
                    <special-message3>test string</special-message3>
                    <special-message4>test string</special-message4>
                    <special-message5>test string</special-message5>
                </special-message>
            </line-item>
            <line-item>
                <line-no>test string</line-no>
                <line-reference>test string</line-reference>
                <transaction-id>test string</transaction-id>
                <item-code>test string</item-code>
                <universal-product-code>test string</universal-product-code>
                <product-name>test string</product-name>
                <quantity>test string</quantity>
                <unit-of-measure>test string</unit-of-measure>
                <serial-list>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                </serial-list>
                <serial-list>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                </serial-list>
                <serial-list>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                </serial-list>
                <market-id>test string</market-id>
                <line-status>test string</line-status>
                <comments>test string</comments>
                <rejection-date>test string</rejection-date>
                <base-price>test string</base-price>
                <line-discount>test string</line-discount>
                <line-tax1>test string</line-tax1>
                <line-tax2>test string</line-tax2>
                <line-tax3>test string</line-tax3>
                <receipt-date>test string</receipt-date>
                <service-type>test string</service-type>
                <return-reason-code>test string</return-reason-code>
                <failure-reason>test string</failure-reason>
                <special-message>
                    <special-message1>test string</special-message1>
                    <special-message2>test string</special-message2>
                    <special-message3>test string</special-message3>
                    <special-message4>test string</special-message4>
                    <special-message5>test string</special-message5>
                </special-message>
            </line-item>
            <line-item>
                <line-no>test string</line-no>
                <line-reference>test string</line-reference>
                <transaction-id>test string</transaction-id>
                <item-code>test string</item-code>
                <universal-product-code>test string</universal-product-code>
                <product-name>test string</product-name>
                <quantity>test string</quantity>
                <unit-of-measure>test string</unit-of-measure>
                <serial-list>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                </serial-list>
                <serial-list>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                </serial-list>
                <serial-list>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                    <serial-numbers>
                        <min>test string</min>
                        <mdn>test string</mdn>
                        <esn>test string</esn>
                        <sim>test string</sim>
                        <imei>test string</imei>
                        <sid>test string</sid>
                        <meid>test string</meid>
                    </serial-numbers>
                </serial-list>
                <market-id>test string</market-id>
                <line-status>test string</line-status>
                <comments>test string</comments>
                <rejection-date>test string</rejection-date>
                <base-price>test string</base-price>
                <line-discount>test string</line-discount>
                <line-tax1>test string</line-tax1>
                <line-tax2>test string</line-tax2>
                <line-tax3>test string</line-tax3>
                <receipt-date>test string</receipt-date>
                <service-type>test string</service-type>
                <return-reason-code>test string</return-reason-code>
                <failure-reason>test string</failure-reason>
                <special-message>
                    <special-message1>test string</special-message1>
                    <special-message2>test string</special-message2>
                    <special-message3>test string</special-message3>
                    <special-message4>test string</special-message4>
                    <special-message5>test string</special-message5>
                </special-message>
            </line-item>
        </detail>
    </return-receipt>
</message>
