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
            ;
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
    }
    Pagination.prototype.setSelectors = function () {
        this.$navLis = $('#nav').find("li");
    };
    Pagination.prototype.initPages = function () {
        this.pages = [
            $('#products'),
            $('#billing-info'),
            $('#shipping-info'),
            $('#payment')
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
        var validation = new Validation($('[data-validate]', this.$currentPage));
        if (!validation.isValidForm()) {
            validation.showErrors();
            return;
        }
        this.currentIndex++;
        if (this.currentIndex > this.pages.length - 1) {
            this.currentIndex = this.pages.length - 1;
        }
    };
    Pagination.prototype.gotoProductsPage = function () {
        this.currentIndex = 0;
        this.showCurrentPage();
    };
    return Pagination;
})();
var FixedRightModule = (function () {
    function FixedRightModule(pagination) {
        this.pagination = pagination;
        this.unitPriceAmt = parseFloat($('form').data('product-prices'));
        this.setSelectors();
        this.initEvents();
        this.initQuantityStepper();
        this.setQuantityFieldIfPassedIn();
        this.calculatePrice();
    }
    FixedRightModule.prototype.setSelectors = function () {
        this.$quantityInputField = $('#fixed-right-module').find('input');
        var $subtotalFields = $('#subtotal-fields');
        this.$unitPrice = $subtotalFields.find('.unit-price');
        this.$subtotal = $subtotalFields.find('.subtotal');
        this.$shipping = $subtotalFields.find('.shipping');
        this.$total = $('#total').find('.price').find('li');
        this.$shippingSelect = $('#shipping-type');
    };
    FixedRightModule.prototype.initEvents = function () {
        var _this = this;
        this.$quantityInputField.on('change blur', function () { return _this.onQuantityChange(); });
        this.$quantityInputField.on('keypress', function (e) { return _this.onKeyPress(e); });
        this.$shippingSelect.on('change', function () { return _this.onShippingSelectChange(); });
    };
    FixedRightModule.prototype.setQuantityFieldIfPassedIn = function () {
        var passedInQuantity = parseInt(this.getParameterByName('quantity'));
        if (passedInQuantity > 0) {
            this.$quantityInputField.val(passedInQuantity.toString());
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
    FixedRightModule.prototype.getQuantity = function () {
        return Math.min(parseInt(this.$quantityInputField.val()), FixedRightModule.MAX_UNITS);
    };
    FixedRightModule.prototype.calculatePrice = function () {
        this.setUnitPrice();
        this.setSubtotal();
        this.setShipping();
        this.setTotal();
    };
    FixedRightModule.prototype.setUnitPrice = function () {
        var priceStr = '$' + this.unitPriceAmt;
        this.$unitPrice.html(priceStr);
    };
    FixedRightModule.prototype.setSubtotal = function () {
        this.subtotalAmt = this.getQuantity() * this.unitPriceAmt;
        this.$subtotal.html('$' + this.subtotalAmt.toFixed(2));
    };
    FixedRightModule.prototype.setShipping = function () {
        if (this.$shippingSelect.val() == '') {
            this.shippingAmt = 0;
            this.$shipping = this.$shipping.html('--');
        }
        else {
            this.shippingAmt = parseFloat(this.$shippingSelect.find('option:selected').data('price'));
            this.$shipping = this.$shipping.html('$' + this.shippingAmt.toFixed(2));
        }
    };
    FixedRightModule.prototype.setTotal = function () {
        var totalStr = '$' + (this.subtotalAmt + this.shippingAmt).toFixed(2);
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
var Products = (function () {
    function Products() {
        this.setSelectors();
        this.initEvents();
        this.showSizeSelectsBasedOnQuantity();
        this.showHideTooManyUnitsMessage();
    }
    Products.prototype.setSelectors = function () {
        this.$products = $('.products');
        this.$quantityInputField = $('#fixed-right-module').find('input');
        this.$tooManyUnitsMsg = $('#too-many-units');
    };
    Products.prototype.initEvents = function () {
        var _this = this;
        this.$quantityInputField.on('change blur', function () { return _this.onQuantityChange(); });
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
                templateHtml = templateHtml.replace('X', (i + 1).toString());
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
})();
new Products();
var BillingInfo = (function () {
    function BillingInfo() {
        this.setSelectors();
        this.initEvents();
        this.setCountrySelectToUS();
    }
    BillingInfo.prototype.setSelectors = function () {
        this.$countrySelect = $('#billing-country');
    };
    BillingInfo.prototype.initEvents = function () {
    };
    BillingInfo.prototype.setCountrySelectToUS = function () {
        this.$countrySelect.find("option[value='US']").attr("selected", "selected");
    };
    return BillingInfo;
})();
var ShippingInfo = (function () {
    function ShippingInfo() {
        this.setSelectors();
        this.initEvents();
        this.initPriceSelect();
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
    };
    ShippingInfo.prototype.initEvents = function () {
        var _this = this;
        this.$quantityInputField.on('change blur', function () { return _this.onQuantityChange(); });
        this.$useBillingAddressCheckbox.on('change', function () { return _this.onUseBillingAddressCheckboxChange(); });
        this.$billingPage.find('input, select').on('change', function () { return _this.onBillingInputChange(); });
    };
    ShippingInfo.prototype.initPriceSelect = function () {
        var $form = $('form');
        var shippingTypes = $form.data('shipping-types').split('|');
        var shippingRates = $form.data('shipping-rates').split('|');
        var shippingIds = $form.data('shipping-ids').split('|');
        var qty = parseInt(this.$quantityInputField.val());
        var startingIndex = qty > 1 ? 1 : 0;
        this.$shippingSelect.append('<option value="">-- Shipping type --</option>');
        for (var i = startingIndex; i < shippingTypes.length - 1; i++) {
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
    ShippingInfo.prototype.onUseBillingAddressCheckboxChange = function () {
        var _this = this;
        if (this.$useBillingAddressCheckbox.is(":checked")) {
            this.$addressFields.slideUp(300, function () {
                _this.copyInBillingFieldValues();
            });
        }
        else {
            this.resetAllFields();
            this.$addressFields.slideDown();
        }
    };
    ShippingInfo.prototype.onBillingInputChange = function () {
        if (this.$useBillingAddressCheckbox.is(":checked")) {
            this.copyInBillingFieldValues();
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
    return ShippingInfo;
})();
var Payment = (function () {
    function Payment() {
        this.setSelectors();
        this.initStripe();
        this.initEvents();
    }
    Payment.prototype.setSelectors = function () {
        this.$form = $('#order-form');
        this.$submitBtn = $('#submit-order');
        this.submitButtonDefaultValue = this.$submitBtn.val();
    };
    Payment.prototype.initStripe = function () {
        this.stripeKey = $('meta[name="publishable-key"]').attr('content');
        Stripe.setPublishableKey(this.stripeKey);
    };
    Payment.prototype.initEvents = function () {
        this.$form.on('submit', $.proxy(this.onFormSubmit, this));
    };
    Payment.prototype.onFormSubmit = function (e) {
        e.preventDefault();
        this.validation = new Validation($('[data-validate]'));
        if (this.validation.isValidForm()) {
            this.$submitBtn.val("One moment...").attr('disabled', true);
            this.createStripeToken();
        }
        else {
            this.validation.showErrors();
        }
    };
    Payment.prototype.createStripeToken = function () {
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
        this.$form[0].submit();
    };
    return Payment;
})();
new Payment();
var OrderForm = (function () {
    function OrderForm() {
        this.setSelectors();
        this.initEvents();
        this.pagination = new Pagination();
        this.pagination.showCurrentPage();
        new ShippingInfo();
        new FixedRightModule(this.pagination);
        new Products();
        new BillingInfo();
        new Payment();
        this.onNextButtonClick();
    }
    OrderForm.prototype.setSelectors = function () {
        this.$nextBtns = $('.prev-next .next');
        this.$previousBtns = $('.prev-next .prev');
    };
    OrderForm.prototype.initEvents = function () {
        var _this = this;
        this.$nextBtns.on('click', function () { return _this.onNextButtonClick(); });
        this.$previousBtns.on('click', function () { return _this.onPreviousButtonClick(); });
    };
    OrderForm.prototype.onNextButtonClick = function () {
        this.pagination.next();
        this.pagination.showCurrentPage();
    };
    OrderForm.prototype.onPreviousButtonClick = function () {
        this.pagination.previous();
        this.pagination.showCurrentPage();
    };
    return OrderForm;
})();
new OrderForm();
//# sourceMappingURL=order-form.js.map