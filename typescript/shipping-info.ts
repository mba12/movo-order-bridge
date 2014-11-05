class ShippingInfo {

    private $shippingSelect:JQuery;
    private $quantityInputField:JQuery;
    private $useBillingAddressCheckbox:JQuery;
    private $addressFields:JQuery;

    constructor() {
        this.setSelectors();
        this.initEvents();
        this.initPriceSelect();
    }

    private setSelectors():void {
        this.$shippingSelect = $('#shipping-type');
        this.$quantityInputField = $('#fixed-right-module').find('input');
        this.$useBillingAddressCheckbox = $('#use-billing-address-checkbox');
        this.$addressFields = $('#shipping-info').find('.fields');
    }

    private initEvents():void {
        this.$quantityInputField.on('change blur', ()=>this.onQuantityChange());
        this.$useBillingAddressCheckbox.on('change', ()=>this.onUseBillingAddressCheckboxChange());
    }

    private initPriceSelect():void {
        var $form = $('form');
        var shippingTypes:any = $form.data('shipping-types').split('|');
        var shippingRates:any = $form.data('shipping-rates').split('|');
        var shippingIds:any = $form.data('shipping-ids').split('|');
        var qty:number = parseInt(this.$quantityInputField.val());
        var startingIndex:number = qty > 1 ? 1 : 0;
        this.$shippingSelect.append('<option value="">-- Shipping type --</option>');
        for(var i=startingIndex; i<shippingTypes.length-1; i++) {
            var price = shippingRates[i];
            this.$shippingSelect.append('<option value="' + shippingIds[i] + '" data-price="' + price + '" >' + shippingTypes[i] + ' - $' + price +'</option>');
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
            this.$addressFields.hide();
        } else {
            this.$addressFields.show();
        }

    }

}