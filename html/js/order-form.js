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
            $($el.data("error-selector"), $el.closest('section')).show();
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
        this.pageChanged = new signals.Signal();
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
        this.pageChanged.dispatch(this.currentIndex);
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
    Pagination.prototype.gotoShippingPage = function () {
        this.currentIndex = 2;
        this.showCurrentPage();
    };
    Pagination.prototype.gotoPage = function (page) {
        this.currentIndex = page;
        this.showCurrentPage();
    };
    return Pagination;
})();
var ScreenBase = (function () {
    function ScreenBase(pagination) {
        this.pagination = pagination;
        this.ajaxCallPending = false;
    }
    ScreenBase.prototype.setSelectors = function () {
        this.$prevBtn = $('.prev', this.$currentPage);
        this.$nextBtn = $('.next', this.$currentPage);
    };
    ScreenBase.prototype.initEvents = function () {
        var _this = this;
        this.$prevBtn.on('click', function () { return _this.onPrevClick(); });
        this.$nextBtn.on('click', function () { return _this.onNextClick(); });
        this.pagination.pageChanged.add(function (pageIndex) { return _this.onPageChanged(pageIndex); });
    };
    ScreenBase.prototype.onPrevClick = function () {
        var validation = new Validation($('[data-validate]', this.$currentPage).filter(':visible'));
        validation.resetErrors();
        this.pagination.previous();
        this.pagination.showCurrentPage();
    };
    ScreenBase.prototype.onNextClick = function () {
        var validation = new Validation($('[data-validate]', this.$currentPage).filter(':visible'));
        if (!validation.isValidForm()) {
            validation.showErrors();
            return;
        }
        validation.resetErrors();
        this.pagination.next();
        this.pagination.showCurrentPage();
    };
    ScreenBase.prototype.onPageChanged = function (pageIndex) {
    };
    return ScreenBase;
})();
var FixedRightModule = (function () {
    function FixedRightModule(pagination) {
        this.pagination = pagination;
        this.currentState = "";
        this.currentZipcode = "";
        this.salesTax = new SalesTax();
        this.order = Order.getInstance();
        this.setSelectors();
        this.setUnitPrice();
        this.initEvents();
        this.initQuantityStepper();
        this.setQuantityFieldIfPassedIn();
        this.calculatePrice();
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
        this.$discount = $('#subtotal-fields').find('.discount');
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
    FixedRightModule.prototype.calculatePrice = function () {
        this.setUnitPrice();
        this.applyCoupon();
        this.setSubtotal();
        this.setSalesTax();
        this.setShipping();
        this.setTotal();
    };
    FixedRightModule.prototype.setUnitPrice = function () {
        var priceStr = '$' + this.order.getUnitPrice();
        this.$unitPrice.html(priceStr);
    };
    FixedRightModule.prototype.applyCoupon = function () {
        if (this.order.getDiscount() > 0) {
            this.$discount.fadeIn();
            var discountStr = "-$" + parseFloat((Math.round(this.order.getDiscount() * 100) / 100)).toFixed(2);
            $('#subtotal-fields').find('.price').find('.discount').html(discountStr);
        }
        else {
            this.$discount.fadeOut();
        }
    };
    FixedRightModule.prototype.hideDiscountFields = function () {
        this.$discount.hide();
    };
    FixedRightModule.prototype.setSubtotal = function () {
        this.$subtotal.html('$' + this.order.getSubtotal().toFixed(2));
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
        this.salesTax.setLocation(this.$shippingZipCode.val(), this.$shippingStateSelect.val(), function (response) {
            _this.$salesTax.html('$' + _this.getSalesTax().toFixed(2));
            if (callback)
                callback(response);
        });
    };
    FixedRightModule.prototype.getSalesTax = function () {
        return this.salesTax.total(this.order.getQuantity(), this.order.getUnitPrice(), this.order.getDiscount(), this.order.getShippingPrice(), this.$shippingStateSelect.val());
    };
    FixedRightModule.prototype.setShipping = function () {
        if (!this.$shippingSelect.val() || this.$shippingSelect.val() == '') {
            this.$shipping.html('--');
        }
        else {
            this.$shipping.html('$' + this.order.getShippingPrice().toFixed(2));
        }
    };
    FixedRightModule.prototype.setTotal = function () {
        var totalStr = '$' + (this.order.getSubtotal() + this.order.getShippingPrice() - this.order.getDiscount() + this.getSalesTax()).toFixed(2);
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
    FixedRightModule.prototype.resetOrder = function () {
        this.order.resetOrder();
        Coupon.reset();
        this.hideDiscountFields();
        $("#shipping-type option:selected").prop("selected", false);
        $("#shipping-type option:first").prop("selected", "selected");
        this.$quantityInputField.val("1");
        this.calculatePrice();
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
            this.$quantityInputField.val(FixedRightModule.MAX_UNITS.toString());
            this.$tooManyUnitsMsg.show();
        }
        else {
            this.$tooManyUnitsMsg.hide();
        }
    };
    Products.prototype.disableQuantityStepper = function () {
        $('#fixed-right-module').find('.stepper').addClass('disabled');
        $('#fixed-right-module').find('input').attr('disabled');
    };
    Products.prototype.enableQuantityStepper = function () {
        $('#fixed-right-module').find('.stepper').removeClass('disabled');
        $('#fixed-right-module').find('input').removeProp('disabled');
    };
    Products.prototype.onPageChanged = function (pageIndex) {
        if (pageIndex == 0) {
            this.enableQuantityStepper();
        }
        else {
            this.disableQuantityStepper();
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
        var endIndex = shippingRates.length - 1;
        if (this.$shippingCountry.val() != 'US') {
            startingIndex = shippingTypes.length - 1;
            endIndex = shippingRates.length;
        }
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
var Payment = (function (_super) {
    __extends(Payment, _super);
    function Payment($pagination, fixedRightModule) {
        _super.call(this, $pagination);
        this.fixedRightModule = fixedRightModule;
        this.trackables = [];
        this.setSelectors();
        this.initEvents();
        this.initStripe();
        new Coupon(this.fixedRightModule);
    }
    Payment.prototype.setSelectors = function () {
        this.$form = $('#order-form');
        this.$submitBtn = $('#submit-order');
        this.submitButtonDefaultValue = this.$submitBtn.val();
        this.$currentPage = $('#payment');
        _super.prototype.setSelectors.call(this);
        this.$spinner = this.$currentPage.find('.spinner');
        this.$customError = this.$form.find('.custom-error');
        this.$cardError = this.$currentPage.find('.card-error');
        this.$editShipping = $('#edit-shipping');
        this.$shippingName = $('#shipping-confirmation').find(".name");
        this.$shippingStreet = $('#shipping-confirmation').find(".street");
        this.$shippingCityStateZip = $('#shipping-confirmation').find(".cityStateZip");
    };
    Payment.prototype.initEvents = function () {
        var _this = this;
        this.$submitBtn.on("click", $.proxy(this.onFormSubmit, this));
        this.$editShipping.on('click', function () { return _this.onEditShippingClick(); });
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
            this.showSpinner();
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
    Payment.prototype.addTracker = function (tracker) {
        this.trackables.push(tracker);
    };
    Payment.prototype.stripResponseHandler = function (status, response) {
        if (response.error) {
            this.$submitBtn.val(this.submitButtonDefaultValue).attr('disabled', false);
            this.hideSpinner();
            return this.$customError.show().text(response.error.message);
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
        if (this.ajaxCallPending) {
            return;
        }
        this.sendDataToServer();
    };
    Payment.prototype.showSpinner = function () {
        this.$spinner.fadeIn();
        this.$nextBtn.css({ opacity: 0.6, cursor: 'default' });
    };
    Payment.prototype.hideSpinner = function () {
        this.$spinner.fadeOut();
        this.$nextBtn.css({ opacity: 1, cursor: 'pointer' });
    };
    Payment.prototype.sendDataToServer = function () {
        var _this = this;
        this.ajaxCallPending = true;
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
                _this.ajaxCallPending = false;
                _this.hideSpinner();
                if (response.status == 200) {
                    _this.resetPage();
                    _this.trackOrder(response.data);
                    _this.pagination.gotoSummaryPage();
                }
                else if (response.status == 400) {
                    _this.$cardError.show();
                }
            },
            error: function (response) {
                _this.ajaxCallPending = false;
                _this.hideSpinner();
                _this.$cardError.show();
            }
        });
    };
    Payment.prototype.trackOrder = function (data) {
        for (var i = 0; i < this.trackables.length; i++) {
            this.trackables[i].track(data);
        }
    };
    Payment.prototype.displayShippingAddress = function () {
        this.$shippingName.html($("#shipping-first-name").val() + " " + $("#shipping-last-name").val());
        this.$shippingStreet.html($("#shipping-address").val());
        this.$shippingCityStateZip.html($("#shipping-city").val() + ", " + $("#shipping-state-select").val() + " " + $("#shipping-zip").val());
    };
    Payment.prototype.onEditShippingClick = function () {
        this.pagination.gotoShippingPage();
    };
    Payment.prototype.onNextClick = function () {
        var validation = new Validation($('[data-validate]', this.$currentPage));
        if (!validation.isValidForm()) {
            validation.showErrors();
            return;
        }
        validation.resetErrors();
    };
    Payment.prototype.onPageChanged = function (pageIndex) {
        this.displayShippingAddress();
        _super.prototype.onPageChanged.call(this, pageIndex);
        this.$cardError.hide();
    };
    Payment.prototype.resetPage = function () {
        $('#credit-card-number, #cvc, #coupon-code').val('');
        $('#coupon-success').hide();
        $('.error-messages').find("li").hide();
    };
    return Payment;
})(ScreenBase);
var Summary = (function (_super) {
    __extends(Summary, _super);
    function Summary($pagination, fixedRightModule) {
        _super.call(this, $pagination);
        this.fixedRightModule = fixedRightModule;
        this.setSelectors();
        this.initEvents();
    }
    Summary.prototype.setSelectors = function () {
        this.$createNewOrderBtn = $('#create-new-order');
    };
    Summary.prototype.initEvents = function () {
        var _this = this;
        this.$createNewOrderBtn.on('click', function (e) { return _this.onCreateNewOrderBtnClick(e); });
    };
    Summary.prototype.onCreateNewOrderBtnClick = function (e) {
        e.preventDefault();
        this.fixedRightModule.resetOrder();
        this.pagination.gotoProductsPage();
    };
    return Summary;
})(ScreenBase);
var Coupon = (function () {
    function Coupon(fixedRightModule) {
        this.fixedRightModule = fixedRightModule;
        this.order = Order.getInstance();
        this.setSelectors();
        this.initEvents();
    }
    Coupon.prototype.setSelectors = function () {
        this.$coupon = $("#coupon");
        this.$form = $("#order-form");
        this.$couponButton = $("#submit-coupon-code");
        this.$couponInput = $("#coupon-code");
        this.$couponSuccess = $("#coupon-success");
        this.$couponBlankMsg = $('#coupon-error-messages').find('.coupon-blank');
        this.$couponInvalidMsg = $('#coupon-error-messages').find('.coupon-invalid');
        this.$couponAppliedMsg = $('#coupon-error-messages').find('.coupon-applied');
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
        this.$couponBlankMsg.hide();
        this.$couponAppliedMsg.hide();
        this.$couponAppliedMsg.hide();
        if (code.length < 1) {
            this.$couponBlankMsg.show();
            return;
        }
        var $myForm = $("<form></form>");
        $myForm.attr("action", "coupons/" + this.$couponInput.val() + "/" + $('#quantity').val());
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
                    _this.onCouponResult(result);
                },
                error: function (result) {
                    _this.onCouponResult(result);
                }
            });
            e.preventDefault();
        });
        $myForm.submit();
    };
    Coupon.prototype.onCouponResult = function (result) {
        if (result.coupon) {
            this.$couponInput.attr("name", "code");
            this.order.coupon = result.coupon;
            this.showCouponSuccessText(result.coupon.code);
            this.updateFormWithCouponData(result.token);
            this.fixedRightModule.calculatePrice();
        }
        else {
            $("#coupon-error-messages").find(".coupon-error").show().html(result.error.message);
            this.fixedRightModule.calculatePrice();
            this.fixedRightModule.hideDiscountFields();
            this.hideCouponSuccessText();
        }
    };
    Coupon.prototype.showCouponSuccessText = function (code) {
        this.$couponSuccess.show().find(".code").html(code);
        $("#coupon-error-messages").find(".coupon-invalid").hide();
        $("#coupon-error-messages").find(".coupon-error").hide();
    };
    Coupon.prototype.hideCouponSuccessText = function () {
        this.$couponSuccess.hide();
    };
    Coupon.prototype.updateFormWithCouponData = function (token) {
        this.$form.append('<input type="hidden" name="coupon_instance" value="' + token + '"/>');
        $("#coupon-code").attr("name", "code");
    };
    Coupon.reset = function () {
        $("#coupon-code").val("");
        $("#coupon-success").hide();
    };
    return Coupon;
})();
var SalesTax = (function () {
    function SalesTax() {
        this.rate = 0;
        this.state = "";
        this.zipcode = "";
        this.taxMethods = [new ExcludeShippingMethod(), new IncludeShippingMethod()];
    }
    SalesTax.prototype.setLocation = function (zipcode, state, callback) {
        var _this = this;
        if (zipcode == this.zipcode && state == this.state) {
            if (callback)
                callback({ rate: this.rate });
            return;
        }
        this.zipcode = zipcode;
        this.state = state;
        $.ajax({
            type: 'GET',
            url: "/tax/" + zipcode + "/" + state,
            success: function (response) {
                if (response.error) {
                    if (callback)
                        callback(response);
                    return;
                }
                _this.rate = response.rate;
                if (callback)
                    callback(response);
            },
            error: function (response) {
                if (callback)
                    callback({ error: "There was an error retrieving sales tax" });
            }
        });
    };
    SalesTax.prototype.total = function (quantity, unitPrice, discount, shippingRate, state) {
        if (!state || state == "") {
            return 0;
        }
        return this.getTaxMethod(state).calculate(quantity, unitPrice, discount, shippingRate, this.rate);
    };
    SalesTax.prototype.getTaxMethod = function (state) {
        state = state.trim();
        for (var i = 0; i < TAX_TABLE.length; i++) {
            var taxObj = TAX_TABLE[i];
            if (taxObj.state.trim() == state) {
                return this.taxMethods[taxObj.method];
            }
        }
        throw new Error("state not found in list");
    };
    return SalesTax;
})();
var IncludeShippingMethod = (function () {
    function IncludeShippingMethod() {
    }
    IncludeShippingMethod.prototype.calculate = function (quantity, unitPrice, discount, shippingRate, rate) {
        return ((quantity * unitPrice) - discount + shippingRate) * rate;
    };
    return IncludeShippingMethod;
})();
var ExcludeShippingMethod = (function () {
    function ExcludeShippingMethod() {
    }
    ExcludeShippingMethod.prototype.calculate = function (quantity, unitPrice, discount, shippingRate, rate) {
        return ((quantity * unitPrice) - discount) * rate;
    };
    return ExcludeShippingMethod;
})();
var CouponData = (function () {
    function CouponData() {
    }
    return CouponData;
})();
var Order = (function () {
    function Order() {
        this.salesTax = new SalesTax();
        if (Order._instance) {
            throw new Error("Error: Instantiation failed: Use Order.getInstance() instead of new.");
        }
        Order._instance = this;
        this.setSelectors();
    }
    Order.getInstance = function () {
        if (Order._instance === null) {
            Order._instance = new Order();
        }
        return Order._instance;
    };
    Order.prototype.setSelectors = function () {
        this.$form = $('#order-form');
        this.$shippingSelect = $('#shipping-type');
        this.$shippingCountrySelect = $('#shipping-country');
        this.$shippingZipCode = $('#shipping-zip');
        this.$shippingStateSelect = $('#shipping-state-select');
        this.$quantityInputField = $("#quantity");
    };
    Order.prototype.resetOrder = function () {
        this.coupon = null;
        this.currentState = "";
        this.currentZipcode = "";
    };
    Order.prototype.getUnitPrice = function () {
        return parseFloat(this.$form.data('product-prices'));
    };
    Order.prototype.getDiscount = function () {
        var discount = 0;
        if (this.coupon) {
            if (this.getQuantity() >= this.coupon.min_units) {
                if (this.coupon.method == "$") {
                    discount = this.coupon.amount;
                }
                else {
                    discount = (this.coupon.amount / 100) * this.getQuantity() * this.getUnitPrice();
                }
            }
        }
        return Math.round(discount);
    };
    Order.prototype.getQuantity = function () {
        return Math.min(parseInt(this.$quantityInputField.val()), FixedRightModule.MAX_UNITS);
    };
    Order.prototype.getSubtotal = function () {
        return this.getQuantity() * this.getUnitPrice();
    };
    Order.prototype.setSalesTax = function (callback) {
        if (this.$shippingCountrySelect.val() != "US") {
            return;
        }
        if (this.$shippingStateSelect.val() == "" || this.$shippingStateSelect.val() == this.currentState) {
            return;
        }
        if (this.$shippingZipCode.val() == "" || this.$shippingZipCode.val() == this.currentZipcode) {
            return;
        }
        this.salesTax.setLocation(this.$shippingZipCode.val(), this.$shippingStateSelect.val(), function (response) {
            if (callback)
                callback(response);
        });
    };
    Order.prototype.getSalesTax = function () {
        return this.salesTax.total(this.getQuantity(), this.getUnitPrice(), this.getDiscount(), this.getShippingPrice(), this.$shippingStateSelect.val());
    };
    Order.prototype.getShippingPrice = function () {
        if (!this.$shippingSelect.val() || this.$shippingSelect.val() == '') {
            return 0;
        }
        else {
            return parseFloat(this.$shippingSelect.find('option:selected').data('price'));
        }
    };
    Order.prototype.getTotal = function () {
        return this.getSubtotal() + this.getShippingPrice() - this.getDiscount() + this.getSalesTax();
    };
    Order._instance = null;
    return Order;
})();
var GoogleTrackOrder = (function () {
    function GoogleTrackOrder() {
    }
    GoogleTrackOrder.prototype.track = function (data) {
        ga('ecommerce:addTransaction', {
            'id': data['charge-id'],
            'affiliation': 'movo',
            'revenue': data['order-total'],
            'shipping': data['shipping-rate'],
            'tax': data['tax']
        });
        for (var i = 0; i < data.items.length; i++) {
            var item = data.items[i];
            ga('ecommerce:addItem', {
                'id': data['charge-id'],
                'name': item.description,
                'sku': item.sku,
                'category': item.description,
                'price': data['unit-price'],
                'quantity': '1'
            });
        }
        ga('ecommerce:send');
    };
    return GoogleTrackOrder;
})();
var FacebookTrackOrder = (function () {
    function FacebookTrackOrder() {
    }
    FacebookTrackOrder.prototype.track = function (data) {
        window['_fbq'].push(['track', '6021218673084', { 'value': data['order-total'], 'currency': 'USD' }]);
    };
    return FacebookTrackOrder;
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
        var payment = new Payment(pagination, fixedRightModule);
        payment.addTracker(new GoogleTrackOrder());
        payment.addTracker(new FacebookTrackOrder());
        new Summary(pagination, fixedRightModule);
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