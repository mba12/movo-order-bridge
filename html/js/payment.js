/// <reference path="definitions/stripe.d.ts" />
var __extends = this.__extends || function (d, b) {
    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    function __() { this.constructor = d; }
    __.prototype = b.prototype;
    d.prototype = new __();
};
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
            //console.log("valid form");
            this.$submitBtn.val("One moment...").attr('disabled', true);
            this.showSpinner();
            this.createStripeToken();
        }
        else {
            //console.log("not valid");
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
        var loopsArray = [];
        $('#loops').find('.loop-input').each(function (i, el) {
            var $item = $(el);
            if ($item.val() > 0) {
                loopsArray.push({
                    sku: $item.data('sku'),
                    name: $item.data('name'),
                    quantity: $item.val()
                });
            }
        });
        data.push({
            "name": 'loops',
            "value": JSON.stringify(loopsArray)
        });
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
                else if (response.status == 503) {
                    _this.criticalError(response);
                }
                else if (response.status == 400) {
                    if (response.error_code >= 2000) {
                        _this.$submitBtn.hide();
                        _this.$prevBtn.hide();
                    }
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
    Payment.prototype.criticalError = function (response) {
        this.$customError.show().text(response.message);
        this.$submitBtn.hide();
        this.$prevBtn.hide();
    };
    Payment.prototype.trackOrder = function (data) {
        var environment = $('meta[name="environment"]').attr('content');
        if (environment != "production")
            return;
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
        //this.fixedRightModule.discount = null;
        $('#coupon-success').hide();
        $('.error-messages').find("li").hide();
    };
    return Payment;
})(ScreenBase);
//# sourceMappingURL=payment.js.map