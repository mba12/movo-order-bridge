<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class ShipNotification extends \Eloquent
{
    protected $guarded = [];
    protected $table = "ship_notification";
    protected $fieldList = [
        "message-id",
        "transaction-name",
        "partner-name",
        "partner-password",
        "source-url",
        "create-timestamp",
        "response-request",
        "customer-id",
        "business-name",
        "carrier-name",
        "ultimate-destination-code",
        "packing-list-number",
        "release-number",
        "customer-first-name",
        "customer-last-name",
        "customer-middle-initial",
        "customer-address1",
        "customer-address2",
        "customer-address3",
        "customer-city",
        "customer-state",
        "customer-post-code",
        "customer-country-code",
        "customer-phone1",
        "customer-phone2",
        "customer-fax",
        "customer-email",
        "ship-first-name",
        "ship-last-name",
        "ship-middle-initial",
        "ship-address1",
        "ship-address2",
        "ship-address3",
        "ship-city",
        "ship-state",
        "ship-post-code",
        "ship-country-code",
        "ship-phone1",
        "ship-phone2",
        "ship-fax",
        "ship-email",
        "ship-via",
        "ship-request-date",
        "ship-request-from",
        "ship-request-warehouse",
        "purchase-order-number",
        "account-description",
        "purchase-order-amount",
        "currency-code",
        "comments",
        "credit-card-number",
        "credit-card-expiration-date",
        "credit-card-identification",
        "global-card-classification-code",
        "card-holder-name",
        "card-holder-address1",
        "card-holder-address2",
        "card-holder-city",
        "card-holder-state",
        "card-holder-post-code",
        "card-holder-country-code",
        "invoice-number",
        "invoice-creation-date",
        "terms-due-days",
        "invoice-expiration-date",
        "terms-discount-percentage",
        "terms-discount-due-days",
        "terms-discount-expiration-date",
        "terms-description",
        "invoice-amount",
        "invoice-discount",
        "customer-order-number",
        "customer-order-date",
        "order-reference",
        "order-sub-total",
        "order-discount",
        "order-tax1",
        "order-tax2",
        "order-tax3",
        "order-shipment-charge",
        "order-total-net",
        "order-status",
        "order-type",
        "customer-channel-type",
        "customer-group-account",
        "customer-seller-code",
        "user-name",
        "gift-flag",
        "brightpoint-order-number",
        "warehouse-id",
        "ship-date",
        "ship-to-code",
        "line-no",
        "line-reference",
        "item-code",
        "universal-product-code",
        "product-name",
        "ship-quantity",
        "packs",
        "internal-packs",
        "unit-of-measure",
        "sid",
        "irdb",
        "market-id",
        "line-status",
        "base-price",
        "line-discount",
        "line-tax1",
        "line-tax2",
        "line-tax3",
        "bill-of-lading",
        "pallet-id",
        "scac",
        "routing-description",
        "container-id",
        "ownership-flag",
        "special-message1",
        "special-message2",
        "special-message3",
        "special-message4",
        "special-message5"];

    public static function parseSAndSaveData($doc)
    {
        $xml = new SimpleXMLElement($doc);
        $data = ShipNotification::parseData($xml);
        ShipNotification::saveData($data);


    }

    private static function parseData($xml)
    {



        $data=[];

        foreach (ShipNotification::$fieldList as $f) {
            $data[$f] = ShipNotification::checkData( $xml->xpath("//" . $f) );
        }

        return $data;
    }

    private static function checkData($data) {

        if (isset($data[0])) {
            return (String) $data[0];
        } else {
            return '';
        }
    }

    private static function saveData($data)
    {

        $inputValues = array();
        foreach($data as $v) {
            $inputValues[$v] = $data[$v];
        }

        ShipNotification::create($inputValues);

        /*
        ShipNotification::create([
			"message_id" =>$data["message-id"],
			"transaction_name" =>$data["transaction-name"],
			"partner_name" =>$data["partner-name"],
			"partner_password" =>$data["partner-password"],
			"source_url" =>$data["source-url"],
			"create_timestamp" =>$data["create-timestamp"],
			"response_request" =>$data["response-request"],
			"customer_id" =>$data["customer-id"],
			"business_name" =>$data["business-name"],
			"carrier_name" =>$data["carrier-name"],
			"ultimate_destination_code" =>$data["ultimate-destination-code"],
			"packing_list_number" =>$data["packing-list-number"],
			"release_number" =>$data["release-number"],
			"customer_first_name" =>$data["customer-first-name"],
			"customer_last_name" =>$data["customer-last-name"],
			"customer_middle_initial" =>$data["customer-middle-initial"],
			"customer_address1" =>$data["customer-address1"],
			"customer_address2" =>$data["customer-address2"],
			"customer_address3" =>$data["customer-address3"],
			"customer_city" =>$data["customer-city"],
			"customer_state" =>$data["customer-state"],
			"customer_post_code" =>$data["customer-post-code"],
			"customer_country_code" =>$data["customer-country-code"],
			"customer_phone1" =>$data["customer-phone1"],
			"customer_phone2" =>$data["customer-phone2"],
			"customer_fax" =>$data["customer-fax"],
			"customer_email" =>$data["customer-email"],
			"ship_first_name" =>$data["ship-first-name"],
			"ship_last_name" =>$data["ship-last-name"],
			"ship_middle_initial" =>$data["ship-middle-initial"],
			"ship_address1" =>$data["ship-address1"],
			"ship_address2" =>$data["ship-address2"],
			"ship_address3" =>$data["ship-address3"],
			"ship_city" =>$data["ship-city"],
			"ship_state" =>$data["ship-state"],
			"ship_post_code" =>$data["ship-post-code"],
			"ship_country_code" =>$data["ship-country-code"],
			"ship_phone1" =>$data["ship-phone1"],
			"ship_phone2" =>$data["ship-phone2"],
			"ship_fax" =>$data["ship-fax"],
			"ship_email" =>$data["ship-email"],
			"ship_via" =>$data["ship-via"],
			"ship_request_date" =>$data["ship-request-date"],
			"ship_request_from" =>$data["ship-request-from"],
			"ship_request_warehouse" =>$data["ship-request-warehouse"],
			"purchase_order_number" =>$data["purchase-order-number"],
			"account_description" =>$data["account-description"],
			"purchase_order_amount" =>$data["purchase-order-amount"],
			"currency_code" =>$data["currency-code"],
			"comments" =>$data["comments"],
			"credit_card_number" =>$data["credit-card-number"],
			"credit_card_expiration_date" =>$data["credit-card-expiration-date"],
			"credit_card_identification" =>$data["credit-card-identification"],
			"global_card_classification_code" =>$data["global-card-classification-code"],
			"card_holder_name" =>$data["card-holder-name"],
			"card_holder_address1" =>$data["card-holder-address1"],
			"card_holder_address2" =>$data["card-holder-address2"],
			"card_holder_city" =>$data["card-holder-city"],
			"card_holder_state" =>$data["card-holder-state"],
			"card_holder_post_code" =>$data["card-holder-post-code"],
			"card_holder_country_code" =>$data["card-holder-country-code"],
			"invoice_number" =>$data["invoice-number"],
			"invoice_creation_date" =>$data["invoice-creation-date"],
			"terms_due_days" =>$data["terms-due-days"],
			"invoice_expiration_date" =>$data["invoice-expiration-date"],
			"terms_discount_percentage" =>$data["terms-discount-percentage"],
			"terms_discount_due_days" =>$data["terms-discount-due-days"],
			"terms_discount_expiration_date" =>$data["terms-discount-expiration-date"],
			"terms_description" =>$data["terms-description"],
			"invoice_amount" =>$data["invoice-amount"],
			"invoice_discount" =>$data["invoice-discount"],
			"customer_order_number" =>$data["customer-order-number"],
			"customer_order_date" =>$data["customer-order-date"],
			"order_reference" =>$data["order-reference"],
			"order_sub_total" =>$data["order-sub-total"],
			"order_discount" =>$data["order-discount"],
			"order_tax1" =>$data["order-tax1"],
			"order_tax2" =>$data["order-tax2"],
			"order_tax3" =>$data["order-tax3"],
			"order_shipment_charge" =>$data["order-shipment-charge"],
			"order_total_net" =>$data["order-total-net"],
			"order_status" =>$data["order-status"],
			"order_type" =>$data["order-type"],
			"customer_channel_type" =>$data["customer-channel-type"],
			"customer_group_account" =>$data["customer-group-account"],
			"customer_seller_code" =>$data["customer-seller-code"],
			"user_name" =>$data["user-name"],
			"gift_flag" =>$data["gift-flag"],
			"brightpoint_order_number" =>$data["brightpoint-order-number"],
			"warehouse_id" =>$data["warehouse-id"],
			"ship_date" =>$data["ship-date"],
			"ship_to_code" =>$data["ship-to-code"],
			"line_no" =>$data["line-no"],
			"line_reference" =>$data["line-reference"],
			"item_code" =>$data["item-code"],
			"universal_product_code" =>$data["universal-product-code"],
			"product_name" =>$data["product-name"],
			"ship_quantity" =>$data["ship-quantity"],
			"packs" =>$data["packs"],
			"internal_packs" =>$data["internal-packs"],
			"unit_of_measure" =>$data["unit-of-measure"],
			"sid" =>$data["sid"],
			"irdb" =>$data["irdb"],
			"market_id" =>$data["market-id"],
			"line_status" =>$data["line-status"],
			"base_price" =>$data["base-price"],
			"line_discount" =>$data["line-discount"],
			"line_tax1" =>$data["line-tax1"],
			"line_tax2" =>$data["line-tax2"],
			"line_tax3" =>$data["line-tax3"],
			"bill_of_lading" =>$data["bill-of-lading"],
			"pallet_id" =>$data["pallet-id"],
			"scac" =>$data["scac"],
			"routing_description" =>$data["routing-description"],
			"container_id" =>$data["container-id"],
			"ownership_flag" =>$data["ownership-flag"],
			"special_message1" =>$data["special-message1"],
			"special_message2" =>$data["special-message2"],
			"special_message3" =>$data["special-message3"],
			"special_message4" =>$data["special-message4"],
			"special_message5" =>$data["special-message5"],
		]);
        */

    }

}
