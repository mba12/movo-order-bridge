/// <reference path="jquery.d.ts" />
/// <reference path="stripe.d.ts" />
/// <reference path="forms/form-error.ts" />
/// <reference path="forms/validation.ts" />

class Billing {

    private $form:any;
    private $submitBtn:JQuery;
    private submitButtonDefaultValue:string;
    private stripeKey:string;
    private validation:Validation;
    constructor() {
        this.validation=new Validation($('[data-validate]'));
        this.setSelectors();
        this.initStripe();
        this.bindEvents();

    }

    private setSelectors() {
        this.$form = $('#order-form');
        this.$submitBtn = this.$form.find('input[type=submit]');
        this.submitButtonDefaultValue = this.$submitBtn.val();
    }

    private initStripe() {
        this.stripeKey = $('meta[name="publishable-key"]').attr('content');
        Stripe.setPublishableKey(this.stripeKey);
    }


    private bindEvents() {
        this.$form.on('submit', $.proxy(this.onFormSubmit, this));
    }

    private onFormSubmit(e) {
        e.preventDefault();
        if (this.validation.isValidForm()) {
            this.$submitBtn.val("One moment...").attr('disabled', <any>true);
            this.createStripeToken();
        } else {
            this.validation.showErrors();
        }
    }

    private createStripeToken() {
        Stripe.createToken(this.$form, $.proxy(this.stripResponseHandler, this));
    }


    private stripResponseHandler(status, response) {
        if (response.error) {

            this.$submitBtn.val(this.submitButtonDefaultValue).attr('disabled', <any>false);
            return this.$form.find('.payment-errors').show().text(response.error.message);
        }

        this.createHiddenInput(response);
        this.submitForm();
    }

    private createHiddenInput(response) {
        $('<input>', {
            type: 'hidden',
            name: 'token',
            'value': response.id
        }).appendTo(this.$form);
    }

    private submitForm() {
       this.$form[0].submit();
    }
}

new Billing();

