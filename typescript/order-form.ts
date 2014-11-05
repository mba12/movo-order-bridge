/// <reference path="jquery.d.ts" />
/// <reference path="forms/form-error.ts" />
/// <reference path="forms/validation.ts" />
/// <reference path="pagination.ts" />
/// <reference path="fixed-right-module.ts" />
/// <reference path="products.ts" />
/// <reference path="billing-info.ts" />
/// <reference path="shipping-info.ts" />
/// <reference path="payment.ts" />

class OrderForm {

    private pagination:Pagination;
    private $nextBtns:JQuery;
    private $previousBtns:JQuery;

    constructor() {
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
//        this.onNextButtonClick();
    }

    private setSelectors() {
        this.$nextBtns = $('.prev-next .next');
        this.$previousBtns = $('.prev-next .prev');
    }

    private initEvents() {
        this.$nextBtns.on('click', ()=>this.onNextButtonClick());
        this.$previousBtns.on('click', ()=>this.onPreviousButtonClick());
    }

    private onNextButtonClick():void {
        this.pagination.next();
        this.pagination.showCurrentPage();
    }

    private onPreviousButtonClick():void {
        this.pagination.previous();
        this.pagination.showCurrentPage();
    }
}

new OrderForm();
