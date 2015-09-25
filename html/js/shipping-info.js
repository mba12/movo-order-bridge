var __extends = this.__extends || function (d, b) {
    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    function __() { this.constructor = d; }
    __.prototype = b.prototype;
    d.prototype = new __();
};
var ShippingInfo = (function (_super) {
    __extends(ShippingInfo, _super);
    function ShippingInfo($pagination, fixedRightModule) {
        _super.call(this, $pagination);
        this.fixedRightModule = fixedRightModule;
        this.setSelectors();
        this.initEvents();
        this.setCountryToUnitedStates();
        this.initPriceSelect();
        this.showStateSelectOrInput();
        this.show3pmMessageIfNecessary();
    }
    ShippingInfo.prototype.setSelectors = function () {
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
        this.$salesTaxError = this.$shippingPage.find(".error-messages").find(".sales-tax");
        this.$currentPage = this.$shippingPage;
        _super.prototype.setSelectors.call(this);
        this.$spinner = this.$currentPage.find('.spinner');
        this.$after3pm = $('#after-3pm');
    };
    ShippingInfo.prototype.initEvents = function () {
        var _this = this;
        this.$quantityInputField.on('change blur', function () { return _this.onQuantityChange(); });
        this.$useBillingAddressCheckbox.on('change', function () { return _this.onUseBillingAddressCheckboxChange(); });
        this.$shippingCountry.on('change', function () { return _this.onCountryChange(); });
        _super.prototype.initEvents.call(this);
    };
    ShippingInfo.prototype.initPriceSelect = function () {
        var $form = $('#order-form');
        var shippingTypes = $form.data('shipping-types').split('|');
        var shippingRates = $form.data('shipping-rates').split('|');
        var shippingIds = $form.data('shipping-ids').split('|');
        var qty = parseInt(this.$quantityInputField.val());
        var startingIndex = qty > 1 ? 1 : 0;
        var endIndex = shippingRates.length - 0;
        /*if(this.$shippingCountry.val() != 'US') {
            startingIndex = shippingTypes.length-1;
            endIndex = shippingRates.length;
        }*/
        this.emptyShippingSelect();
        this.$shippingSelect.append('<option value="">-- Shipping type --</option>');
        for (var i = startingIndex; i < endIndex; i++) {
            var price = shippingRates[i];
            this.$shippingSelect.append('<option value="' + shippingIds[i] + '" data-price="' + price + '" >' + shippingTypes[i] + ' - $' + price + '</option>');
        }
    };
    ShippingInfo.prototype.emptyShippingSelect = function () {
        this.$shippingSelect.empty();
    };
    ShippingInfo.prototype.onQuantityChange = function () {
        this.emptyShippingSelect();
        this.initPriceSelect();
    };
    ShippingInfo.prototype.setCountryToUnitedStates = function () {
        this.$shippingCountry.find("option[value='US']").attr("selected", "selected");
    };
    ShippingInfo.prototype.onUseBillingAddressCheckboxChange = function () {
        if (this.$useBillingAddressCheckbox.is(":checked")) {
            this.copyInBillingFieldValues();
            this.initPriceSelect();
        }
        else {
            this.resetAllFields();
        }
    };
    ShippingInfo.prototype.copyInBillingFieldValues = function () {
        this.$shippingFirstName.val(this.$billingFirstName.val());
        this.$shippingLastName.val(this.$billingLastName.val());
        this.$shippingPhone.val(this.$billingPhone.val());
        this.$shippingCountry.val(this.$billingCountry.val());
        this.$shippingAddress.val(this.$billingAddress.val());
        this.$shippingCity.val(this.$billingCity.val());
        this.$shippingState.val(this.$billingState.val());
        this.$shippingZip.val(this.$billingZip.val());
    };
    ShippingInfo.prototype.resetAllFields = function () {
        this.$shippingFirstName.val('');
        this.$shippingLastName.val('');
        this.$shippingPhone.val('');
        this.$shippingAddress.val('');
        this.$shippingCity.val('');
        this.$shippingZip.val('');
    };
    ShippingInfo.prototype.onCountryChange = function () {
        this.initPriceSelect();
        this.showStateSelectOrInput();
    };
    ShippingInfo.prototype.showStateSelectOrInput = function () {
        if (this.$shippingCountry.val() == 'US') {
            $('#shipping-state-select').parent().show();
            $('#shipping-state-input').parent().hide();
        }
        else {
            $('#shipping-state-select').parent().hide();
            $('#shipping-state-input').parent().show();
        }
    };
    ShippingInfo.prototype.onNextClick = function () {
        var _this = this;
        if (this.ajaxCallPending) {
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
        this.$nextBtn.css({ opacity: 0.6, cursor: 'default' });
        this.fixedRightModule.setSalesTax(function (result) {
            _this.ajaxCallPending = false;
            _this.$spinner.fadeOut();
            _this.$nextBtn.css({ opacity: 1, cursor: 'pointer' });
            if (!result || result.error) {
                _this.$currentPage.find('.error-messages').find('.sales-tax').show();
                return;
            }
            _this.fixedRightModule.setTotal();
            validation.resetErrors();
            _this.$salesTaxError.hide();
            _this.pagination.next();
            _this.pagination.showCurrentPage();
        });
    };
    ShippingInfo.prototype.show3pmMessageIfNecessary = function () {
        if ($('body').hasClass('after3pm')) {
            this.$after3pm.show();
        }
        else {
            this.$after3pm.hide();
        }
    };
    return ShippingInfo;
})(ScreenBase);
//# sourceMappingURL=shipping-info.js.map