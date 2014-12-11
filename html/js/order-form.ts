/// <reference path="definitions/jquery.d.ts" />
/// <reference path="definitions/greensock.d.ts" />
/// <reference path="forms/form-error.ts" />
/// <reference path="forms/validation.ts" />
/// <reference path="pagination.ts" />
/// <reference path="screen-base.ts" />
/// <reference path="fixed-right-module.ts" />
/// <reference path="products.ts" />
/// <reference path="billing-info.ts" />
/// <reference path="shipping-info.ts" />
/// <reference path="payment.ts" />
/// <reference path="summary.ts" />
/// <reference path="coupon.ts" />
/// <reference path="sales-tax.ts" />
/// <reference path="sales-tax/sales-tax-method.ts" />
/// <reference path="sales-tax/include-shipping.ts" />
/// <reference path="sales-tax/exclude-shipping.ts" />
/// <reference path="coupon-data.ts" />
/// <reference path="orders/order.ts" />
/// <reference path="orders/tracking-interface.ts" />
/// <reference path="orders/google-track-order.ts" />
/// <reference path="orders/facebook-track-order.ts" />

class OrderForm {

    private $closeBtn:JQuery;

    constructor() {
        this.setSelectors();
        this.initEvents();
        var pagination = new Pagination();
        var fixedRightModule:FixedRightModule= new FixedRightModule(pagination);
        new ShippingInfo(pagination,fixedRightModule);
        new Products(pagination);
        new BillingInfo(pagination);
        var payment:Payment=new Payment(pagination,fixedRightModule);
        payment.addTracker(new GoogleTrackOrder());
        payment.addTracker(new FacebookTrackOrder());
        new Summary(pagination,fixedRightModule);
        //pagination.gotoPage(3);

        setInterval(function(){
            $('body').removeClass('ios-scroll-fix');
            $('body').addClass('ios-scroll-fix');
        }, 5000);
    }

    private setSelectors():void {
        this.$closeBtn = $('#close');
    }

    private initEvents():void {
        $('body').on('keydown', (e)=>this.onKeyPress(e));
        this.$closeBtn.on('click', ()=>this.onCloseClick());
    }

    private onKeyPress(e):void {
        if (e.which == 27) {
            this.closeForm();
        }
    }

    private closeForm():void {
        var parentUrl:any = (window.location != window.parent.location) ? document.referrer : document.location;
        parent.window.postMessage('close-order-lightbox', parentUrl);
    }

    private onCloseClick():void {
        this.closeForm();
    }

}

new OrderForm();
declare var TAX_RATES;
