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
            $('#shipping-type'),
            $('#shipping-address'),
            $('#billing-address'),
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
    return Pagination;
})();
var Billing = (function () {
    function Billing() {
        var _this = this;
        this.setSelectors();
        this.initStripe();
        this.initQuantityStepper();
        this.bindEvents();
        this.pagination = new Pagination();
        this.pagination.showCurrentPage();
        setInterval(function () {
            _this.pagination.next();
            _this.pagination.showCurrentPage();
        }, 3000);
    }
    Billing.prototype.setSelectors = function () {
        this.$form = $('#order-form');
        this.$submitBtn = this.$form.find('input[type=submit]');
        this.submitButtonDefaultValue = this.$submitBtn.val();
    };
    Billing.prototype.initStripe = function () {
        this.stripeKey = $('meta[name="publishable-key"]').attr('content');
        Stripe.setPublishableKey(this.stripeKey);
    };
    Billing.prototype.initQuantityStepper = function () {
        $('#fixed-right-module').find('input').stepper({ min: 1, max: 999 });
    };
    Billing.prototype.bindEvents = function () {
        this.$form.on('submit', $.proxy(this.onFormSubmit, this));
    };
    Billing.prototype.onFormSubmit = function (e) {
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
    Billing.prototype.createStripeToken = function () {
        Stripe.createToken(this.$form, $.proxy(this.stripResponseHandler, this));
    };
    Billing.prototype.stripResponseHandler = function (status, response) {
        if (response.error) {
            this.$submitBtn.val(this.submitButtonDefaultValue).attr('disabled', false);
            return this.$form.find('.payment-errors').show().text(response.error.message);
        }
        this.createHiddenInput(response);
        this.submitForm();
    };
    Billing.prototype.createHiddenInput = function (response) {
        $('<input>', {
            type: 'hidden',
            name: 'token',
            'value': response.id
        }).appendTo(this.$form);
    };
    Billing.prototype.submitForm = function () {
        this.$form[0].submit();
    };
    return Billing;
})();
new Billing();
//# sourceMappingURL=billing.js.map