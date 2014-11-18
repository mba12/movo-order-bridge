/// <reference path="jquery.d.ts" />
/// <reference path="greensock.d.ts" />
/// <reference path="forms/form-error.ts" />
/// <reference path="forms/validation.ts" />
/// <reference path="pagination.ts" />
/// <reference path="screen-base.ts" />
/// <reference path="fixed-right-module.ts" />
/// <reference path="products.ts" />
/// <reference path="billing-info.ts" />
/// <reference path="shipping-info.ts" />
/// <reference path="payment.ts" />
/// <reference path="coupon.ts" />
/// <reference path="coupon-data.ts" />


class OrderForm {

    private $contentBox:JQuery;

    constructor() {
        this.setSelectors();
        this.initEvents();
        this.setInitialFormScale();
        var pagination = new Pagination();
        var fixedRightModule:FixedRightModule= new FixedRightModule(pagination);
        new ShippingInfo(pagination,fixedRightModule);
        new Products(pagination);
        new BillingInfo(pagination);
        new Payment(pagination);
    }

    private setSelectors():void {
        this.$contentBox = $('#form-content-box');
    }

    private initEvents():void {
        $(window).on('load', ()=>this.onWindowLoad());
        $('document').on('keyup', (e)=>this.onKeyPress(e));
    }

    private onWindowLoad():void {
        this.animateInForm();
    }

    private setInitialFormScale():void {
        TweenMax.set(this.$contentBox, {css: {scale: 0.5}});
    }

    private animateInForm():void {
        TweenMax.to(this.$contentBox, 1, {css: {scale: 1, opacity: 1}, ease: Power3.easeInOut});
    }

    private onKeyPress(e):void {
        if (e.which == 27) {
            console.log('keyup from form');
            //$(document).trigger('keyup');
        }
        console.log('form key up');
    }

}

new OrderForm();
declare var TAX_RATES;

