(function () {
    var StripeBilling = {


        init: function () {
            this.setSelectors();
            this.initStripe();
            this.bindEvents();
        },

        setSelectors: function () {
            this.$form = $('#order-form');
            this.$submitBtn = this.$form.find('input[type=submit]');
            this.submitButtonDefaultValue=this.$submitBtn.val();
        },

        initStripe: function () {
            this.stripeKey = $('meta[name="publishable-key"]').attr('content');
            Stripe.setPublishableKey(this.stripeKey);
        },

        bindEvents: function () {
            this.$form.on('submit', $.proxy(this.onFormSubmit, this));
        },

        onFormSubmit: function (e) {
            e.preventDefault();
            this.$submitBtn.val("One moment...").attr('disabled', true);

            this.createStripeToken();
        },

        createStripeToken: function () {
            Stripe.createToken(this.$form, $.proxy(this.stripResponseHandler, this));
        },

        stripResponseHandler: function (status, response) {
            if (response.error) {

                this.$submitBtn.val(this.submitButtonDefaultValue).attr('disabled', false);
                return this.$form.find('.payment-errors').show().text(response.error.message);
            }

            this.createHiddenInput(response);
            this.submitForm();
        },

        createHiddenInput: function (response) {
            $('<input>', {
                type: 'hidden',
                name: 'token',
                'value': response.id
            }).appendTo(this.$form);
        },

        submitForm: function () {
             this.$form[0].submit();
        }


    };

    StripeBilling.init();
})();
