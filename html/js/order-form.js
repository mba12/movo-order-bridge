var FormError = (function () {
    function FormError(input, message) {
        this.input = input;
        this.message = message;
    }
    return FormError;
})();
var Validation = (function () {
    function Validation($formInputs) {
        this.$formInputs = $formInputs;
    }
    Validation.prototype.isValidForm = function () {
        var _this = this;
        this.errors = [];
        var isValid = true;
        this.$formInputs.each(function (i, val) {
            var $input = $(val);
            if (!_this.isValidInput($input)) {
                isValid = false;
                _this.errors.push(new FormError($input));
            }
        });
        return isValid;
    };
    Validation.prototype.resetErrors = function () {
        var _this = this;
        this.$formInputs.each(function (i, val) {
            var $input = $(val);
            _this.hideInputErrors($input);
        });
    };
    Validation.prototype.showErrors = function () {
        this.resetErrors();
        for (var i = 0; i < this.errors.length; i++) {
            this.displayInputErrors(this.errors[i].input);
        }
    };
    Validation.prototype.hideInputErrors = function ($el) {
        if ($el.data("input-selector")) {
            $($el.data("input-selector")).removeClass("error");
        }
        else {
            $el.removeClass("error");
        }
        if ($el.data("error-selector")) {
            $($el.data("error-selector")).hide();
        }
    };
    Validation.prototype.displayInputErrors = function ($el) {
        if ($el.data("input-selector")) {
            var is = $($el.data("input-selector"));
            $($el.data("input-selector")).addClass("error");
        }
        else {
            $el.addClass("error");
        }
        if ($el.data("error-selector")) {
            $($el.data("error-selector")).show();
            if ($el.data("error-message")) {
                $($el.data("error-selector")).html($el.data("error-message"));
            }
        }
    };
    Validation.prototype.isValidInput = function ($el) {
        try {
            if (!$el.data("validate")) {
                return true;
            }
            var isValid = true;
            var value = $el.val();
            var data = $el.data("validate");
            var validators = this.extractValidatorStrings(data);
            for (var i = 0; i < validators.length; i++) {
                var validator = validators[i];
                if (!this.isValidEmail(value, validator)) {
                    isValid = false;
                }
                if (!this.isMinimumLength(value, validator)) {
                    isValid = false;
                }
                if (!this.isMaximumLength(value, validator)) {
                    isValid = false;
                }
                if (!this.isMatch(value, validator)) {
                    isValid = false;
                }
                if (!this.isChecked($el, validator)) {
                    isValid = false;
                }
                if (!this.isNumber(value, validator)) {
                    isValid = false;
                }
                if (!this.isMinValue(value, validator)) {
                    isValid = false;
                }
                if (!this.isMaxValue(value, validator)) {
                    isValid = false;
                }
            }
            return isValid;
        }
        catch (e) {
            return false;
        }
    };
    Validation.prototype.extractValidatorStrings = function (data) {
        return data.split("|");
    };
    Validation.prototype.fieldContainsPlaceholderText = function (input) {
        return input.val() == input.attr("placeholder");
    };
    Validation.prototype.isValidEmail = function (email, validator) {
        if (validator != "email")
            return true;
        var regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return regex.test(email);
    };
    Validation.prototype.isMinimumLength = function (value, validator) {
        if (validator.indexOf("min:") == -1)
            return true;
        var minimum = validator.split(":")[1];
        return value.length >= minimum;
    };
    Validation.prototype.isMaximumLength = function (value, validator) {
        if (validator.indexOf("max:") == -1)
            return true;
        var maximum = validator.split(":")[1];
        return value.length <= maximum;
    };
    Validation.prototype.isMatch = function (value, validator) {
        if (validator.indexOf("matches:") == -1)
            return true;
        var selector = validator.split(":")[1];
        return value == $(selector).val();
    };
    Validation.prototype.isChecked = function ($el, validator) {
        if (validator.indexOf("checked") == -1)
            return true;
        return $el.is(":checked");
    };
    Validation.prototype.isNumber = function (value, validator) {
        if (validator != "number")
            return true;
        return !isNaN(value);
    };
    Validation.prototype.isMinValue = function (value, validator) {
        if (validator.indexOf("minValue:") == -1)
            return true;
        var minimum = validator.split(":")[1];
        return !isNaN(parseInt(value)) && parseInt(value) >= minimum;
    };
    Validation.prototype.isMaxValue = function (value, validator) {
        if (validator.indexOf("maxValue:") == -1)
            return true;
        var maximum = validator.split(":")[1];
        return !isNaN(parseInt(value)) && parseInt(value) <= maximum;
    };
    return Validation;
})();
var Pagination = (function () {
    function Pagination() {
        this.currentIndex = 0;
        this.setSelectors();
        this.initPages();
        this.showCurrentPage();
    }
    Pagination.prototype.setSelectors = function () {
        this.$navLis = $('#nav').find("li");
    };
    Pagination.prototype.initPages = function () {
        this.pages = [
            $('#products'),
            $('#billing-info'),
            $('#shipping-info'),
            $('#payment'),
            $('#summary')
        ];
        this.$currentPage = this.pages[this.currentIndex];
    };
    Pagination.prototype.showCurrentPage = function () {
        this.$currentPage = this.pages[this.currentIndex];
        for (var i = 0; i < this.pages.length; i++) {
            $(this.pages[i]).hide();
        }
        this.$currentPage.show();
        this.$navLis.removeClass("active");
        $(this.$navLis[this.currentIndex]).addClass("active");
    };
    Pagination.prototype.previous = function () {
        this.currentIndex--;
        if (this.currentIndex < 0) {
            this.currentIndex = 0;
        }
    };
    Pagination.prototype.next = function () {
        this.currentIndex++;
        if (this.currentIndex > this.pages.length - 1) {
            this.currentIndex = this.pages.length - 1;
        }
    };
    Pagination.prototype.gotoProductsPage = function () {
        this.currentIndex = 0;
        this.showCurrentPage();
    };
    Pagination.prototype.gotoSummaryPage = function () {
        this.currentIndex = 4;
        this.showCurrentPage();
    };
    Pagination.prototype.gotoPage = function (page) {
        this.currentIndex = page;
        this.showCurrentPage();
    };
    return Pagination;
})();
var ScreenBase = (function () {
    function ScreenBase($pagination) {
        this.$pagination = $pagination;
    }
    ScreenBase.prototype.setSelectors = function () {
        this.$prevBtn = $('.prev', this.$currentPage);
        this.$nextBtn = $('.next', this.$currentPage);
    };
    ScreenBase.prototype.initEvents = function () {
        var _this = this;
        this.$prevBtn.on('click', function () { return _this.onPrevClick(); });
        this.$nextBtn.on('click', function () { return _this.onNextClick(); });
    };
    ScreenBase.prototype.onPrevClick = function () {
        this.$pagination.previous();
        this.$pagination.showCurrentPage();
    };
    ScreenBase.prototype.onNextClick = function () {
        var validation = new Validation($('[data-validate]', this.$currentPage).filter(':visible'));
        if (!validation.isValidForm()) {
            validation.showErrors();
            return;
        }
        validation.resetErrors();
        this.$pagination.next();
        this.$pagination.showCurrentPage();
    };
    return ScreenBase;
})();
var FixedRightModule = (function () {
    function FixedRightModule(pagination) {
        this.pagination = pagination;
        var _this = this;
        this.salesTax = 0;
        this.discount = 0;
        this.currentState = "";
        this.currentZipcode = "";
        this.setSelectors();
        this.setUnitPrice();
        this.initEvents();
        this.initQuantityStepper();
        this.setQuantityFieldIfPassedIn();
        this.calculatePrice();
        new Coupon(function (result) { return _this.onCouponSuccess(result); });
    }
    FixedRightModule.prototype.setSelectors = function () {
        this.$quantityInputField = $('#quantity');
        var $subtotalFields = $('#subtotal-fields');
        this.$form = $('#order-form');
        this.$unitPrice = $subtotalFields.find('.unit-price');
        this.$salesTax = $subtotalFields.find('.sales-tax');
        this.$subtotal = $subtotalFields.find('.subtotal');
        this.$shipping = $subtotalFields.find('.shipping');
        this.$total = $('#total').find('.price').find('li');
        this.$shippingSelect = $('#shipping-type');
        this.$shippingCountrySelect = $('#shipping-country');
        this.$shippingZipCode = $('#shipping-zip');
        this.$shippingStateSelect = $('#shipping-state-select');
    };
    FixedRightModule.prototype.initEvents = function () {
        var _this = this;
        this.$quantityInputField.on('change blur', function () { return _this.onQuantityChange(); });
        this.$quantityInputField.on('keypress', function (e) { return _this.onKeyPress(e); });
        this.$shippingSelect.on('change', function () { return _this.onShippingSelectChange(); });
        this.$shippingCountrySelect.on('change', function () { return _this.onShippingCountrySelectChange(); });
    };
    FixedRightModule.prototype.setQuantityFieldIfPassedIn = function () {
        var passedInQuantity = parseInt(this.getParameterByName('quantity'));
        if (passedInQuantity > 0) {
            this.$quantityInputField.val(passedInQuantity.toString());
        }
    };
    FixedRightModule.prototype.onCouponSuccess = function (result) {
        if (result) {
            this.coupon = result.coupon;
            this.$form.append('<input type="hidden" name="coupon_instance" value="' + result.token + '"/>');
            $("#coupon-code").attr("name", "code");
            this.calculatePrice();
        }
    };
    FixedRightModule.prototype.onQuantityChange = function () {
        this.calculatePrice();
        this.pagination.gotoProductsPage();
    };
    FixedRightModule.prototype.initQuantityStepper = function () {
        this.$quantityInputField.stepper({ min: 1, max: FixedRightModule.MAX_UNITS });
    };
    FixedRightModule.prototype.getParameterByName = function (name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"), results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    };
    FixedRightModule.prototype.onShippingSelectChange = function () {
        this.calculatePrice();
    };
    FixedRightModule.prototype.onShippingCountrySelectChange = function () {
        this.calculatePrice();
    };
    FixedRightModule.prototype.getQuantity = function () {
        return Math.min(parseInt(this.$quantityInputField.val()), FixedRightModule.MAX_UNITS);
    };
    FixedRightModule.prototype.calculatePrice = function () {
        this.setUnitPrice();
        this.applyCoupon();
        this.setSubtotal();
        this.setSalesTax();
        this.setShipping();
        this.setTotal();
    };
    FixedRightModule.prototype.setUnitPrice = function () {
        this.unitPriceAmt = parseFloat(this.$form.data('product-prices'));
        var priceStr = '$' + this.unitPriceAmt;
        this.$unitPrice.html(priceStr);
    };
    FixedRightModule.prototype.applyCoupon = function () {
        if (this.coupon) {
            if (this.getQuantity() >= this.coupon.min_units) {
                if (this.coupon.method == "$") {
                    this.discount = this.coupon.amount;
                }
                else {
                    this.discount = (this.coupon.amount / 100) * this.getQuantity() * this.unitPriceAmt;
                }
            }
        }
    };
    FixedRightModule.prototype.setSubtotal = function () {
        this.subtotalAmt = this.getQuantity() * this.unitPriceAmt - this.discount;
        this.$subtotal.html('$' + this.subtotalAmt.toFixed(2));
    };
    FixedRightModule.prototype.setSalesTax = function (callback) {
        var _this = this;
        if (this.$shippingCountrySelect.val() != "US") {
            return;
        }
        if (this.$shippingStateSelect.val() == "" || this.$shippingStateSelect.val() == this.currentState) {
            return;
        }
        if (this.$shippingZipCode.val() == "" || this.$shippingZipCode.val() == this.currentZipcode) {
            return;
        }
        var taxRate = 0;
        $.ajax({
            type: 'GET',
            url: "/tax/" + this.$shippingZipCode.val() + "/" + this.$shippingStateSelect.val(),
            success: function (taxRate) {
                if (callback)
                    callback(taxRate);
                if (taxRate.error) {
                    return;
                }
                _this.salesTax = (_this.getQuantity() * _this.unitPriceAmt - _this.discount) * taxRate.rate;
                _this.$salesTax.html('$' + _this.salesTax.toFixed(2));
            },
            error: function (response) {
                if (callback)
                    callback({ error: "There was an error retrieving sales tax" });
                ;
            }
        });
    };
    FixedRightModule.prototype.setShipping = function () {
        var foo = this.$shippingSelect.val();
        if (!this.$shippingSelect.val() || this.$shippingSelect.val() == '') {
            this.shippingAmt = 0;
            this.$shipping = this.$shipping.html('--');
        }
        else {
            this.shippingAmt = parseFloat(this.$shippingSelect.find('option:selected').data('price'));
            this.$shipping = this.$shipping.html('$' + this.shippingAmt.toFixed(2));
        }
    };
    FixedRightModule.prototype.setTotal = function () {
        var totalStr = '$' + (this.subtotalAmt + this.shippingAmt + this.salesTax).toFixed(2);
        this.$total.html(totalStr);
    };
    FixedRightModule.prototype.onKeyPress = function (e) {
        this.restrictInputToNumbers(e);
    };
    FixedRightModule.prototype.restrictInputToNumbers = function (evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
        var regex = /[0-9]|\./;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault)
                theEvent.preventDefault();
        }
    };
    FixedRightModule.MAX_UNITS = 8;
    return FixedRightModule;
})();
var __extends = this.__extends || function (d, b) {
    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    function __() { this.constructor = d; }
    __.prototype = b.prototype;
    d.prototype = new __();
};
var Products = (function (_super) {
    __extends(Products, _super);
    function Products($pagination) {
        _super.call(this, $pagination);
        this.setSelectors();
        this.initEvents();
        this.showSizeSelectsBasedOnQuantity();
        this.showHideTooManyUnitsMessage();
    }
    Products.prototype.setSelectors = function () {
        this.$products = $('.products');
        this.$quantityInputField = $('#fixed-right-module').find('input');
        this.$tooManyUnitsMsg = $('#too-many-units');
        this.$currentPage = $('#products');
        _super.prototype.setSelectors.call(this);
    };
    Products.prototype.initEvents = function () {
        var _this = this;
        this.$quantityInputField.on('change blur', function () { return _this.onQuantityChange(); });
        _super.prototype.initEvents.call(this);
    };
    Products.prototype.onQuantityChange = function () {
        this.showSizeSelectsBasedOnQuantity();
        this.showHideTooManyUnitsMessage();
    };
    Products.prototype.showSizeSelectsBasedOnQuantity = function () {
        var $selectGroups = this.$products.find('.select-group');
        var curQty = $selectGroups.length;
        var targetQty = Math.min(parseInt(this.$quantityInputField.val()), FixedRightModule.MAX_UNITS);
        var templateHtml = $('#product-select-tpl').html();
        if (curQty < targetQty) {
            for (var i = curQty; i < targetQty; i++) {
                templateHtml = templateHtml.replace(/#unitID/g, "unit" + (i + 1).toString());
                templateHtml = templateHtml.replace(/#unitNum/g, (i + 1).toString());
                this.$products.append($(templateHtml));
            }
        }
        else {
            for (var i = curQty; i > targetQty; i--) {
                $selectGroups.last().remove();
            }
        }
    };
    Products.prototype.showHideTooManyUnitsMessage = function () {
        if (parseInt(this.$quantityInputField.val()) >= FixedRightModule.MAX_UNITS) {
            this.$tooManyUnitsMsg.show();
        }
        else {
            this.$tooManyUnitsMsg.hide();
        }
    };
    return Products;
})(ScreenBase);
var BillingInfo = (function (_super) {
    __extends(BillingInfo, _super);
    function BillingInfo($pagination) {
        _super.call(this, $pagination);
        this.setSelectors();
        this.initEvents();
        this.setCountryToUnitedStates();
        this.showStateSelectOrInput();
    }
    BillingInfo.prototype.setSelectors = function () {
        this.$countrySelect = $('#billing-country');
        this.$stateSelect = $('#billing-state-select');
        this.$stateInput = $('#billing-state-input');
        this.$currentPage = $('#billing-info');
        _super.prototype.setSelectors.call(this);
    };
    BillingInfo.prototype.initEvents = function () {
        var _this = this;
        this.$countrySelect.on('change', function () { return _this.onCountryChange(); });
        _super.prototype.initEvents.call(this);
    };
    BillingInfo.prototype.setCountryToUnitedStates = function () {
        this.$countrySelect.find("option[value='US']").attr("selected", "selected");
    };
    BillingInfo.prototype.onCountryChange = function () {
        this.showStateSelectOrInput();
    };
    BillingInfo.prototype.showStateSelectOrInput = function () {
        if (this.$countrySelect.val() == 'US') {
            this.showStateSelect();
        }
        else {
            this.showStateInput();
        }
    };
    BillingInfo.prototype.showStateSelect = function () {
        this.$stateSelect.parent().show();
        this.$stateInput.parent().hide();
    };
    BillingInfo.prototype.showStateInput = function () {
        this.$stateInput.parent().show();
        this.$stateSelect.parent().hide();
    };
    return BillingInfo;
})(ScreenBase);
var ShippingInfo = (function (_super) {
    __extends(ShippingInfo, _super);
    function ShippingInfo($pagination, fixedRightModule) {
        _super.call(this, $pagination);
        this.fixedRightModule = fixedRightModule;
        this.setSelectors();
        this.initEvents();
        this.initPriceSelect();
        this.setCountryToUnitedStates();
        this.showStateSelectOrInput();
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
        this.$currentPage = this.$shippingPage;
        _super.prototype.setSelectors.call(this);
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
        var endIndex = shippingRates.length - 1;
        if (this.$shippingCountry.val() != 'US') {
            startingIndex = shippingTypes.length - 1;
            endIndex = shippingRates.length;
        }
        this.$shippingSelect.empty();
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
        this.fixedRightModule.setSalesTax(function (result) {
            if (result.error) {
                _this.$currentPage.find('.error-messages').find('.sales-tax').show();
                return;
            }
            validation.resetErrors();
            _this.$pagination.next();
            _this.$pagination.showCurrentPage();
        });
    };
    return ShippingInfo;
})(ScreenBase);
var Payment = (function (_super) {
    __extends(Payment, _super);
    function Payment($pagination) {
        _super.call(this, $pagination);
        this.setSelectors();
        this.initEvents();
        this.initStripe();
    }
    Payment.prototype.setSelectors = function () {
        this.$form = $('#order-form');
        this.$submitBtn = $('#submit-order');
        this.submitButtonDefaultValue = this.$submitBtn.val();
        this.$currentPage = $('#payment');
        _super.prototype.setSelectors.call(this);
    };
    Payment.prototype.initEvents = function () {
        this.$submitBtn.on("click", $.proxy(this.onFormSubmit, this));
        _super.prototype.initEvents.call(this);
    };
    Payment.prototype.initStripe = function () {
        this.stripeKey = $('meta[name="publishable-key"]').attr('content');
        Stripe.setPublishableKey(this.stripeKey);
    };
    Payment.prototype.onFormSubmit = function (e) {
        e.preventDefault();
        this.validation = new Validation($('[data-validate]', this.$currentPage).filter(':visible'));
        if (this.validation.isValidForm()) {
            console.log("valid form");
            this.$submitBtn.val("One moment...").attr('disabled', true);
            this.createStripeToken();
        }
        else {
            console.log("not valid");
            this.validation.showErrors();
        }
    };
    Payment.prototype.createStripeToken = function () {
        var data = this.$form.serialize();
        Stripe.createToken(this.$form, $.proxy(this.stripResponseHandler, this));
    };
    Payment.prototype.stripResponseHandler = function (status, response) {
        if (response.error) {
            this.$submitBtn.val(this.submitButtonDefaultValue).attr('disabled', false);
            return this.$form.find('.payment-errors').show().text(response.error.message);
        }
        this.createHiddenInput(response);
        this.submitForm();
    };
    Payment.prototype.createHiddenInput = function (response) {
        $('<input>', {
            type: 'hidden',
            name: 'token',
            'value': response.id
        }).appendTo(this.$form);
    };
    Payment.prototype.submitForm = function () {
        var _this = this;
        var formURL = this.$form.attr("action");
        var data = this.$form.serializeArray();
        var quantity = $('#quantity').val();
        for (var i = 0; i < quantity; i++) {
            var itemName = "unit" + (i + 1);
            var unitText = $("#" + itemName + " option:selected").text().trim();
            data.push({ "name": itemName + "Name", "value": unitText });
        }
        $.ajax({
            type: 'POST',
            url: formURL,
            data: data,
            success: function (response) {
                if (response.status == 200) {
                    _this.$pagination.gotoSummaryPage();
                }
                else if (response.status == 400) {
                    console.log("crap, something went wrong");
                }
            }
        });
    };
    Payment.prototype.onPrevClick = function () {
        _super.prototype.onPrevClick.call(this);
    };
    Payment.prototype.onNextClick = function () {
        var validation = new Validation($('[data-validate]', this.$currentPage));
        if (!validation.isValidForm()) {
            validation.showErrors();
            return;
        }
        validation.resetErrors();
    };
    return Payment;
})(ScreenBase);
var Coupon = (function () {
    function Coupon(callback) {
        this.callback = callback;
        this.setSelectors();
        this.initEvents();
    }
    Coupon.prototype.setSelectors = function () {
        this.$coupon = $("#coupon");
        this.$form = $("#order-form");
        this.$couponButton = $("#submit-coupon-code");
        this.$couponInput = $("#coupon-code");
        this.$couponResponse = $('.error-messages .coupon');
    };
    Coupon.prototype.initEvents = function () {
        var _this = this;
        this.$couponButton.click(function (e) { return _this.onCouponApply(e); });
    };
    Coupon.prototype.onCouponApply = function (event) {
        var _this = this;
        event.preventDefault();
        event.stopPropagation();
        var code = this.$couponInput.val();
        this.$couponResponse.hide();
        if (code.length < 1) {
            this.$couponResponse.show();
            return;
        }
        var $myForm = $("<form></form>");
        $myForm.attr("action", "coupons/" + this.$couponInput.val());
        $myForm.append('<input type="hidden" name="_token" value="' + $('input[name=_token]').val() + '"/>');
        $myForm.serialize();
        $myForm.on("submit", function (e) {
            var method = $myForm.find('input[name="_method"]').val() || "POST";
            var url = $myForm.prop("action");
            $.ajax({
                type: method,
                url: url,
                data: $myForm.serialize(),
                success: function (result) {
                    _this.$couponInput.attr("name", "code");
                    _this.callback(result);
                },
                error: function (result) {
                }
            });
            e.preventDefault();
        });
        $myForm.submit();
    };
    Coupon.prototype.onSuccess = function (result) {
        console.log(result);
    };
    Coupon.prototype.onError = function (result) {
        console.log(result);
    };
    return Coupon;
})();
var CouponData = (function () {
    function CouponData() {
    }
    return CouponData;
})();
var OrderForm = (function () {
    function OrderForm() {
        this.setSelectors();
        this.initEvents();
        var pagination = new Pagination();
        var fixedRightModule = new FixedRightModule(pagination);
        new ShippingInfo(pagination, fixedRightModule);
        new Products(pagination);
        new BillingInfo(pagination);
        new Payment(pagination);
    }
    OrderForm.prototype.setSelectors = function () {
        this.$closeBtn = $('#close');
    };
    OrderForm.prototype.initEvents = function () {
        var _this = this;
        $('body').on('keydown', function (e) { return _this.onKeyPress(e); });
        this.$closeBtn.on('click', function () { return _this.onCloseClick(); });
    };
    OrderForm.prototype.onKeyPress = function (e) {
        if (e.which == 27) {
            this.closeForm();
        }
    };
    OrderForm.prototype.closeForm = function () {
        var parentUrl = (window.location != window.parent.location) ? document.referrer : document.location;
        parent.window.postMessage('close-order-lightbox', parentUrl);
    };
    OrderForm.prototype.onCloseClick = function () {
        this.closeForm();
    };
    return OrderForm;
})();
new OrderForm();
//# sourceMappingURL=order-form.js.map