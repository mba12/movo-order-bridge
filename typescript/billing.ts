/// <reference path="jquery.d.ts" />
/// <reference path="stripe.d.ts" />
/// <reference path="forms/form-error.ts" />
/// <reference path="forms/validation.ts" />
/// <reference path="pagination.ts" />

class Billing {

    private $form:any;
    private $submitBtn:JQuery;
    private submitButtonDefaultValue:string;
    private stripeKey:string;
    private validation:Validation;
    private pagination:Pagination;

    constructor() {
        this.setSelectors();
        this.initStripe();
        this.initQuantityStepper();
        this.bindEvents();
        this.pagination = new Pagination();
        this.pagination.showCurrentPage();
        setInterval( ()=> {
//         this.pagination.next();
//         this.pagination.showCurrentPage();
         },3000);
        this.pagination.next();
        this.pagination.showCurrentPage();
        this.pagination.next();
        this.pagination.showCurrentPage();
        this.pagination.next();
        this.pagination.showCurrentPage();

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

    private initQuantityStepper():void {
        $('#fixed-right-module').find('input').stepper({ min: 1, max: 999});
    }

    private bindEvents() {
        this.$form.on('submit', $.proxy(this.onFormSubmit, this));
    }

    private onFormSubmit(e) {
        e.preventDefault();
        this.validation = new Validation($('[data-validate]'));
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
