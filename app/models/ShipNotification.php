<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class ShipNotification extends \Eloquent
{
    protected $guarded = [];
    protected $table = "ship_notification";

    public static function parseSAndSaveData($doc)
    {
        $xml = new SimpleXMLElement($doc);
        $data = ShipNotification::parseData($xml);
        ShipNotification::saveData($data);


    }

    private static function parseData($xml)
    {

        $fieldList = [
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

        $data=[];

        foreach ($fieldList as $f) {
            $data[$f] = checkData( $xml->xpath("//" . $f) );
        }

/*
		$data["message-id"] = (String)$xml->xpath("//message-id")[0];
		$data["transaction-name"] = (String)$xml->xpath("//transaction-name")[0]; // good
		$data["partner-name"] = (String)$xml->xpath("//partner-name")[0]; // good
		$data["partner-password"] = (String)$xml->xpath("//partner-password")[0];
		$data["source-url"] = (String)$xml->xpath("//source-url")[0]; // good
		$data["create-timestamp"] = (String)$xml->xpath("//create-timestamp")[0]; // good
		$data["response-request"] = (String)$xml->xpath("//response-request")[0]; // good
		$data["customer-id"] = (String)$xml->xpath("//customer-id")[0]; // good
		$data["business-name"] = (String)$xml->xpath("//business-name")[0];
		$data["carrier-name"] = (String)$xml->xpath("//carrier-name")[0];
		$data["ultimate-destination-code"] = (String)$xml->xpath("//ultimate-destination-code")[0];
		$data["packing-list-number"] = (String)$xml->xpath("//packing-list-number")[0];
		$data["release-number"] = (String)$xml->xpath("//release-number")[0];

		$data["customer-first-name"] = (String)$xml->xpath("//customer-first-name")[0];
		$data["customer-last-name"] = (String)$xml->xpath("//customer-last-name")[0];
		$data["customer-middle-initial"] = (String)$xml->xpath("//customer-middle-initial")[0];
		$data["customer-address1"] = (String)$xml->xpath("//customer-address1")[0];
		$data["customer-address2"] = (String)$xml->xpath("//customer-address2")[0];
		$data["customer-address3"] = (String)$xml->xpath("//customer-address3")[0];
		$data["customer-city"] = (String)$xml->xpath("//customer-city")[0];
		$data["customer-state"] = (String)$xml->xpath("//customer-state")[0];
		$data["customer-post-code"] = (String)$xml->xpath("//customer-post-code")[0];
		$data["customer-country-code"] = (String)$xml->xpath("//customer-country-code")[0];
		$data["customer-phone1"] = (String)$xml->xpath("//customer-phone1")[0];
		$data["customer-phone2"] = (String)$xml->xpath("//customer-phone2")[0];
		$data["customer-fax"] = (String)$xml->xpath("//customer-fax")[0];
		$data["customer-email"] = (String)$xml->xpath("//customer-email")[0];

		$data["ship-first-name"] = (String)$xml->xpath("//ship-first-name")[0];
		$data["ship-last-name"] = (String)$xml->xpath("//ship-last-name")[0];
	    $data["ship-middle-initial"] = (String)$xml->xpath("//ship-middle-initial")[0];
		$data["ship-address1"] = (String)$xml->xpath("//ship-address1")[0];
		$data["ship-address2"] = (String)$xml->xpath("//ship-address2")[0];
		$data["ship-address3"] = (String)$xml->xpath("//ship-address3")[0];
		$data["ship-city"] = (String)$xml->xpath("//ship-city")[0];
		$data["ship-state"] = (String)$xml->xpath("//ship-state")[0];
		$data["ship-post-code"] = (String)$xml->xpath("//ship-post-code")[0];
		$data["ship-country-code"] = (String)$xml->xpath("//ship-country-code")[0];
		$data["ship-phone1"] = (String)$xml->xpath("//ship-phone1")[0];
		$data["ship-phone2"] = (String)$xml->xpath("//ship-phone2")[0];
		$data["ship-fax"] = (String)$xml->xpath("//ship-fax")[0];
		$data["ship-email"] = (String)$xml->xpath("//ship-email")[0];
		$data["ship-via"] = (String)$xml->xpath("//ship-via")[0];
		$data["ship-request-date"] = (String)$xml->xpath("//ship-request-date")[0];
		$data["ship-request-from"] = (String)$xml->xpath("//ship-request-from")[0];
		$data["ship-request-warehouse"] = (String)$xml->xpath("//ship-request-warehouse")[0];
		$data["purchase-order-number"] = (String)$xml->xpath("//purchase-order-number")[0];
		$data["account-description"] = (String)$xml->xpath("//account-description")[0];
		$data["purchase-order-amount"] = (String)$xml->xpath("//purchase-order-amount")[0];
		$data["currency-code"] = (String)$xml->xpath("//currency-code")[0];
		$data["comments"] = (String)$xml->xpath("//comments")[0];
		$data["credit-card-number"] = (String)$xml->xpath("//credit-card-number")[0];
		$data["credit-card-expiration-date"] = (String)$xml->xpath("//credit-card-expiration-date")[0];
		$data["credit-card-identification"] = (String)$xml->xpath("//credit-card-identification")[0];
		$data["global-card-classification-code"] = (String)$xml->xpath("//global-card-classification-code")[0];
		$data["card-holder-name"] = (String)$xml->xpath("//card-holder-name")[0];
		$data["card-holder-address1"] = (String)$xml->xpath("//card-holder-address1")[0];
		$data["card-holder-address2"] = (String)$xml->xpath("//card-holder-address2")[0];
		$data["card-holder-city"] = (String)$xml->xpath("//card-holder-city")[0];
		$data["card-holder-state"] = (String)$xml->xpath("//card-holder-state")[0];
		$data["card-holder-post-code"] = (String)$xml->xpath("//card-holder-post-code")[0];
		$data["card-holder-country-code"] = (String)$xml->xpath("//card-holder-country-code")[0];
		$data["invoice-number"] = (String)$xml->xpath("//invoice-number")[0];
		$data["invoice-creation-date"] = (String)$xml->xpath("//invoice-creation-date")[0];
		$data["terms-due-days"] = (String)$xml->xpath("//terms-due-days")[0];
		$data["invoice-expiration-date"] = (String)$xml->xpath("//invoice-expiration-date")[0];
		$data["terms-discount-percentage"] = (String)$xml->xpath("//terms-discount-percentage")[0];
		$data["terms-discount-due-days"] = (String)$xml->xpath("//terms-discount-due-days")[0];
		$data["terms-discount-expiration-date"] = (String)$xml->xpath("//terms-discount-expiration-date")[0];
		$data["terms-description"] = (String)$xml->xpath("//terms-description")[0];
		$data["invoice-amount"] = (String)$xml->xpath("//invoice-amount")[0];
		$data["invoice-discount"] = (String)$xml->xpath("//invoice-discount")[0];
		$data["customer-order-number"] = (String)$xml->xpath("//customer-order-number")[0];
		$data["customer-order-date"] = (String)$xml->xpath("//customer-order-date")[0];
		$data["order-reference"] = (String)$xml->xpath("//order-reference")[0];
		$data["order-sub-total"] = (String)$xml->xpath("//order-sub-total")[0];
		$data["order-discount"] = (String)$xml->xpath("//order-discount")[0];
		$data["order-tax1"] = (String)$xml->xpath("//order-tax1")[0];
		$data["order-tax2"] = (String)$xml->xpath("//order-tax2")[0];
		$data["order-tax3"] = (String)$xml->xpath("//order-tax3")[0];
		$data["order-shipment-charge"] = (String)$xml->xpath("//order-shipment-charge")[0];
		$data["order-total-net"] = (String)$xml->xpath("//order-total-net")[0];
		$data["order-status"] = (String)$xml->xpath("//order-status")[0];
		$data["order-type"] = (String)$xml->xpath("//order-type")[0];
		$data["customer-channel-type"] = (String)$xml->xpath("//customer-channel-type")[0];
		$data["customer-group-account"] = (String)$xml->xpath("//customer-group-account")[0];
		$data["customer-seller-code"] = (String)$xml->xpath("//customer-seller-code")[0];
		$data["user-name"] = (String)$xml->xpath("//user-name")[0];
		$data["gift-flag"] = (String)$xml->xpath("//gift-flag")[0];
		$data["brightpoint-order-number"] = (String)$xml->xpath("//brightpoint-order-number")[0];
		$data["warehouse-id"] = (String)$xml->xpath("//warehouse-id")[0];
		$data["ship-date"] = (String)$xml->xpath("//ship-date")[0];
		$data["ship-to-code"] = (String)$xml->xpath("//ship-to-code")[0];
		$data["line-no"] = (String)$xml->xpath("//line-no")[0];
		$data["line-reference"] = (String)$xml->xpath("//line-reference")[0];
		$data["item-code"] = (String)$xml->xpath("//item-code")[0];
		$data["universal-product-code"] = (String)$xml->xpath("//universal-product-code")[0];
		$data["product-name"] = (String)$xml->xpath("//product-name")[0];
		$data["ship-quantity"] = (String)$xml->xpath("//ship-quantity")[0];
		$data["packs"] = (String)$xml->xpath("//packs")[0];
		$data["internal-packs"] = (String)$xml->xpath("//internal-packs")[0];
		$data["unit-of-measure"] = (String)$xml->xpath("//unit-of-measure")[0];
		$data["sid"] = (String)$xml->xpath("//sid")[0];
		$data["irdb"] = (String)$xml->xpath("//irdb")[0];
		$data["market-id"] = (String)$xml->xpath("//market-id")[0];
		$data["line-status"] = (String)$xml->xpath("//line-status")[0];
		$data["base-price"] = (String)$xml->xpath("//base-price")[0];
		$data["line-discount"] = (String)$xml->xpath("//line-discount")[0];
		$data["line-tax1"] = (String)$xml->xpath("//line-tax1")[0];
		$data["line-tax2"] = (String)$xml->xpath("//line-tax2")[0];
		$data["line-tax3"] = (String)$xml->xpath("//line-tax3")[0];
		$data["bill-of-lading"] = (String)$xml->xpath("//bill-of-lading")[0];
		$data["pallet-id"] = (String)$xml->xpath("//pallet-id")[0];
		$data["scac"] = (String)$xml->xpath("//scac")[0];
		$data["routing-description"] = (String)$xml->xpath("//routing-description")[0];
		$data["container-id"] = (String)$xml->xpath("//container-id")[0];
		$data["ownership-flag"] = (String)$xml->xpath("//ownership-flag")[0];
		$data["special-message1"] = (String)$xml->xpath("//special-message1")[0];
		$data["special-message2"] = (String)$xml->xpath("//special-message2")[0];
		$data["special-message3"] = (String)$xml->xpath("//special-message3")[0];
		$data["special-message4"] = (String)$xml->xpath("//special-message4")[0];
		$data["special-message5"] = (String)$xml->xpath("//special-message5")[0];

        */

        return $data;
    }

    private static function checkData($data) {

        if (isset($data)) {
            return (String) $data[0];
        } else {
            return '';

        }


    }

    private static function saveData($data)
    {
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

    }

}
