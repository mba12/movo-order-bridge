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
//# sourceMappingURL=payment.js.map