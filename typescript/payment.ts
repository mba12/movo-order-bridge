/// <reference path="stripe.d.ts" />

class Payment extends ScreenBase {

    private $form:any;
    private $submitBtn:JQuery;
    private submitButtonDefaultValue:string;
    private stripeKey:string;
    private validation:Validation;

    constructor($pagination:Pagination) {
        super($pagination);
        this.setSelectors();
        this.initEvents();
        this.initStripe();
    }

    public setSelectors() {
        this.$form = $('#order-form');
        this.$submitBtn = $('#submit-order');
        this.submitButtonDefaultValue = this.$submitBtn.val();
        this.$currentPage = $('#payment');
        super.setSelectors();
    }

    public initEvents() {
        this.$form.on('submit', $.proxy(this.onFormSubmit, this));
        super.initEvents();
    }

    private initStripe() {
        this.stripeKey = $('meta[name="publishable-key"]').attr('content');
        Stripe.setPublishableKey(this.stripeKey);
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
            type: 'hidden', name: 'token', 'value': response.id
        }).appendTo(this.$form);
    }

    private submitForm() {
        this.$form[0].submit();
    }

    onPrevClick():void {
        super.onPrevClick();
    }

    onNextClick():void {
        var validation = new Validation($('[data-validate]', this.$currentPage));
        if (!validation.isValidForm()) {
            validation.showErrors();
            return;
        }
        validation.resetErrors();

        // TODO: submit form here
    }

}
