/// <reference path="definitions/stripe.d.ts" />

class Payment extends ScreenBase {

    private $form:any;
    private $submitBtn:JQuery;
    private submitButtonDefaultValue:string;
    private stripeKey:string;
    private validation:Validation;
    private $spinner:JQuery;
    private $customError:JQuery;
    private $cardError:JQuery;

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
        this.$spinner = this.$currentPage.find('.spinner');
        this.$customError = this.$form.find('.custom-error');
        this.$cardError = this.$currentPage.find('.card-error');
    }

    public initEvents() {
        this.$submitBtn.on("click", $.proxy(this.onFormSubmit, this));
        super.initEvents();
    }

    private initStripe() {
        this.stripeKey = $('meta[name="publishable-key"]').attr('content');
        Stripe.setPublishableKey(this.stripeKey);
    }

    private onFormSubmit(e) {
        e.preventDefault();
        this.validation = new Validation($('[data-validate]', this.$currentPage).filter(':visible'));
        if (this.validation.isValidForm()) {
            console.log("valid form");
            this.$submitBtn.val("One moment...").attr('disabled', <any>true);
            this.showSpinner();
            this.createStripeToken();
        } else {
            console.log("not valid");
            this.validation.showErrors();
        }
    }

    private createStripeToken() {
        var data = this.$form.serialize();
        Stripe.createToken(this.$form, $.proxy(this.stripResponseHandler, this));
    }

    private stripResponseHandler(status, response) {
        if (response.error) {
            this.$submitBtn.val(this.submitButtonDefaultValue).attr('disabled', <any>false);
            this.hideSpinner();
            return this.$customError.show().text(response.error.message);
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
        if (this.ajaxCallPending) {
            return;
        }
        this.sendDataToServer();
    }

    private showSpinner():void {
        this.$spinner.fadeIn();
        this.$nextBtn.css({opacity: 0.6, cursor: 'default'});
    }

    private hideSpinner():void {
        this.$spinner.fadeOut();
        this.$nextBtn.css({opacity: 1, cursor: 'pointer'});
    }

    private sendDataToServer():void {
        this.ajaxCallPending = true;
        var formURL = this.$form.attr("action");
        var data = this.$form.serializeArray();
        var quantity = $('#quantity').val();
        for (var i = 0; i < quantity; i++) {
            var itemName:string = "unit" + (i + 1);
            var unitText:string = $("#" + itemName + " option:selected").text().trim();
            data.push({"name": itemName + "Name", "value": unitText});
        }
        $.ajax({
            type: 'POST', url: formURL,
            data: data,
            success: (response)=> {
                this.ajaxCallPending = false;
                this.hideSpinner();
                if (response.status == 200) {
                    $('#credit-card-number, #cvc').val('');
                    this.pagination.gotoSummaryPage();
                } else if (response.status == 400) {
                    this.$cardError.show();
                }
            },
            error: (response)=> {
                this.ajaxCallPending = false;
                this.hideSpinner();
                this.$cardError.show();
            }
        });
    }

    onNextClick():void {
        var validation = new Validation($('[data-validate]', this.$currentPage));
        if (!validation.isValidForm()) {
            validation.showErrors();
            return;
        }
        validation.resetErrors();
    }

}