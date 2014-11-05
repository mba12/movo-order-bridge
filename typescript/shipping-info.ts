class ShippingInfo {

    private $shippingSelect:JQuery;
    private $quantityInputField:JQuery;
    private $useBillingAddressCheckbox:JQuery;
    private $addressFields:JQuery;
    private $billingPage:JQuery;
    private $shippingPage:JQuery;

    private $shippingFirstName:JQuery;
    private $shippingLastName:JQuery;
    private $shippingPhone:JQuery;
    private $shippingCountry:JQuery;
    private $shippingAddress:JQuery;
    private $shippingCity:JQuery;
    private $shippingState:JQuery;
    private $shippingZip:JQuery;

    private $billingFirstName:JQuery;
    private $billingLastName:JQuery;
    private $billingPhone:JQuery;
    private $billingCountry:JQuery;
    private $billingAddress:JQuery;
    private $billingCity:JQuery;
    private $billingState:JQuery;
    private $billingZip:JQuery;

    constructor() {
        this.setSelectors();
        this.initEvents();
        this.initPriceSelect();
    }

    private setSelectors():void {
        this.$shippingSelect = $('#shipping-type');
        this.$quantityInputField = $('#fixed-right-module').find('input');
        this.$useBillingAddressCheckbox = $('#use-billing-address-checkbox');
        this.$billingPage = $('#billing-info');
        this.$shippingPage = $('#shipping-info');
        this.$addressFields = this.$shippingPage.find('.fields');

        this.$shippingFirstName = this.$shippingPage.find('#shipping-first-name');
        this.$shippingLastName = this.$shippingPage.find('#shipping-last-name');
        this.$shippingPhone = this.$shippingPage.find('#shipping-phone');
        this.$shippingCountry = this.$shippingPage.find('#shipping-country');
        this.$shippingAddress = this.$shippingPage.find('#shipping-address');
        this.$shippingCity = this.$shippingPage.find('#shipping-city');
        this.$shippingState = this.$shippingPage.find('#shipping-state-select');
        this.$shippingZip = this.$shippingPage.find('#shipping-zip');

        this.$billingFirstName = this.$billingPage.find('#billing-first-name');
        this.$billingLastName = this.$billingPage.find('#billing-last-name');
        this.$billingPhone = this.$billingPage.find('#billing-phone');
        this.$billingCountry = this.$billingPage.find('#billing-country');
        this.$billingAddress = this.$billingPage.find('#billing-address');
        this.$billingCity = this.$billingPage.find('#billing-city');
        this.$billingState = this.$billingPage.find('#billing-state-select');
        this.$billingZip = this.$billingPage.find('#billing-zip');
    }

    private initEvents():void {
        this.$quantityInputField.on('change blur', ()=>this.onQuantityChange());
        this.$useBillingAddressCheckbox.on('change', ()=>this.onUseBillingAddressCheckboxChange());
        this.$billingPage.find('input, select').on('change', ()=>this.onBillingInputChange());
    }

    private initPriceSelect():void {
        var $form = $('form');
        var shippingTypes:any = $form.data('shipping-types').split('|');
        var shippingRates:any = $form.data('shipping-rates').split('|');
        var shippingIds:any = $form.data('shipping-ids').split('|');
        var qty:number = parseInt(this.$quantityInputField.val());
        var startingIndex:number = qty > 1 ? 1 : 0;
        this.$shippingSelect.append('<option value="">-- Shipping type --</option>');
        for (var i = startingIndex; i < shippingTypes.length - 1; i++) {
            var price = shippingRates[i];
            this.$shippingSelect.append('<option value="' + shippingIds[i] + '" data-price="' + price + '" >' + shippingTypes[i] + ' - $' + price + '</option>');
        }
    }

    private emptyShippingSelect():void {
        this.$shippingSelect.empty();
    }

    private onQuantityChange():void {
        this.emptyShippingSelect();
        this.initPriceSelect();
    }

    private onUseBillingAddressCheckboxChange():void {
        if (this.$useBillingAddressCheckbox.is(":checked")) {
            this.$addressFields.slideUp(300, ()=> {
                this.copyInBillingFieldValues();
            });
        } else {
            this.resetAllFields();
            this.$addressFields.slideDown();
        }
    }

    private onBillingInputChange():void {
        if (this.$useBillingAddressCheckbox.is(":checked")) {
            this.copyInBillingFieldValues();
        }
    }

    private copyInBillingFieldValues():void {
        this.$shippingFirstName.val(this.$billingFirstName.val());
        this.$shippingLastName.val(this.$billingLastName.val());
        this.$shippingPhone.val(this.$billingPhone.val());
        this.$shippingCountry.val(this.$billingCountry.val());
        this.$shippingAddress.val(this.$billingAddress.val());
        this.$shippingCity.val(this.$billingCity.val());
        this.$shippingState.val(this.$billingState.val());
        this.$shippingZip.val(this.$billingZip.val());
    }

    private resetAllFields():void {
        this.$shippingFirstName.val('');
        this.$shippingLastName.val('');
        this.$shippingPhone.val('');
//        this.$shippingCountry.val('');
        this.$shippingAddress.val('');
        this.$shippingCity.val('');
//        this.$shippingState.val('');
        this.$shippingZip.val('');
    }
}