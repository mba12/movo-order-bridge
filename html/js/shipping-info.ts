class ShippingInfo extends ScreenBase {

    private $shippingSelect:JQuery;
    private $quantityInputField:JQuery;
    private $useBillingAddressCheckbox:JQuery;
    private $addressFields:JQuery;
    private $billingPage:JQuery;
    private $shippingPage:JQuery;
    private $spinner:JQuery;

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

    constructor($pagination:Pagination, public fixedRightModule:FixedRightModule) {
        super($pagination);
        this.setSelectors();
        this.initEvents();
        this.initPriceSelect();
        this.setCountryToUnitedStates();
        this.showStateSelectOrInput();
    }

    public setSelectors() {
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
        this.$currentPage = this.$shippingPage;
        super.setSelectors();
        this.$spinner = this.$currentPage.find('.spinner');
    }

    public initEvents() {
        this.$quantityInputField.on('change blur', ()=>this.onQuantityChange());
        this.$useBillingAddressCheckbox.on('change', ()=>this.onUseBillingAddressCheckboxChange());
        //this.$billingPage.find('input, select').on('change', ()=>this.onBillingInputChange());
        this.$shippingCountry.on('change', ()=>this.onCountryChange());
        super.initEvents();
    }

    private initPriceSelect():void {
        var $form = $('#order-form');
        var shippingTypes:any = $form.data('shipping-types').split('|');
        var shippingRates:any = $form.data('shipping-rates').split('|');
        var shippingIds:any = $form.data('shipping-ids').split('|');
        var qty:number = parseInt(this.$quantityInputField.val());
        var startingIndex:number = qty > 1 ? 1 : 0;
        var endIndex:number = shippingRates.length-1;
        if(this.$shippingCountry.val() != 'US') {
            startingIndex = shippingTypes.length-1;
            endIndex = shippingRates.length;
        }
        this.$shippingSelect.empty();
        this.$shippingSelect.append('<option value="">-- Shipping type --</option>');
        for (var i = startingIndex; i < endIndex; i++) {
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

    private setCountryToUnitedStates():void {
        this.$shippingCountry.find("option[value='US']").attr("selected", "selected");
    }

    private onUseBillingAddressCheckboxChange():void {
        if (this.$useBillingAddressCheckbox.is(":checked")) {
            this.copyInBillingFieldValues();
            this.initPriceSelect();
        } else {
            this.resetAllFields();
        }
    }

    /*private onBillingInputChange():void {
        this.copyInBillingFieldValues();
        this.initPriceSelect();
    }*/

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
        this.$shippingAddress.val('');
        this.$shippingCity.val('');
        this.$shippingZip.val('');
    }

    private onCountryChange():void {
        this.initPriceSelect();
        this.showStateSelectOrInput();
    }

    private showStateSelectOrInput():void {
        if (this.$shippingCountry.val() == 'US') {
            $('#shipping-state-select').parent().show();
            $('#shipping-state-input').parent().hide();
        } else {
            $('#shipping-state-select').parent().hide();
            $('#shipping-state-input').parent().show();
        }
    }

    onNextClick():void {
        if(this.ajaxCallPending) {
            return;
        }
        this.$shippingCountry.removeClass('error');
        this.$currentPage.find('.error-messages').find('.country').hide();

        var validation = new Validation($('[data-validate]', this.$currentPage).filter(':visible'));
        validation.resetErrors();

        if (this.$shippingCountry.val() != 'US') {
            this.$shippingCountry.addClass('error');
            this.$currentPage.find('.error-messages').find('.country').show();
            return;
        }

        if (!validation.isValidForm()) {
            validation.showErrors();
            return;
        }
        this.ajaxCallPending = true;
        this.$spinner.fadeIn();
        this.$nextBtn.css({opacity:0.6, cursor:'default'});


        this.fixedRightModule.setSalesTax((result)=>{
            this.ajaxCallPending = false;
            this.$spinner.fadeOut();
            this.$nextBtn.css({opacity: 1, cursor:'pointer'});
            if(result.error){
                this.$currentPage.find('.error-messages').find('.sales-tax').show();
                return;
            }
            validation.resetErrors();
            this.pagination.next();
            this.pagination.showCurrentPage();
        });
    }

}