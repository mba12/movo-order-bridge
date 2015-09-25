/// <reference path="definitions/jquery.d.ts" />
/// <reference path="definitions/greensock.d.ts" />
/// <reference path="forms/form-error.ts" />
/// <reference path="forms/validation.ts" />
/// <reference path="pagination.ts" />
/// <reference path="screen-base.ts" />
/// <reference path="fixed-right-module.ts" />
/// <reference path="products.ts" />
/// <reference path="loops.ts" />
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
var OrderForm = (function () {
    function OrderForm() {
        this.setSelectors();
        this.initEvents();
        var pagination = new Pagination();
        var fixedRightModule = new FixedRightModule(pagination);
        new ShippingInfo(pagination, fixedRightModule);
        new Products(pagination);
        new Loops(pagination, fixedRightModule);
        new BillingInfo(pagination);
        var payment = new Payment(pagination, fixedRightModule);
        payment.addTracker(new GoogleTrackOrder());
        payment.addTracker(new FacebookTrackOrder());
        new Summary(pagination, fixedRightModule);
        //pagination.gotoPage(1);
    }
    OrderForm.prototype.setSelectors = function () {
        this.$closeBtn = $('#close');
    };
    OrderForm.prototype.initEvents = function () {
        var _this = this;
        $('body').on('keydown', function (e) { return _this.onKeyPress(e); });
        this.$closeBtn.on('click', function () { return _this.onCloseClick(); });
    };
    OrderForm.prototype.onKeyPress = function (e) {
        if (e.which == 27) {
            this.closeForm();
        }
    };
    OrderForm.prototype.closeForm = function () {
        if (window.location !== window.parent.location) {
            // The page is in an iframe
            var parentUrl = (window.location != window.parent.location) ? document.referrer : document.location;
            parent.window.postMessage('close-order-lightbox', parentUrl);
        }
        else {
            // The page is not in an iframe
            //history.go(-1);
            window.location.href = "http://www.getmovo.com";
        }
    };
    OrderForm.prototype.onCloseClick = function () {
        this.closeForm();
    };
    return OrderForm;
})();
new OrderForm();
//# sourceMappingURL=order-form.js.map