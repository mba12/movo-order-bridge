/// <reference path="jquery.d.ts" />
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

    constructor() {
        var pagination = new Pagination();
        var fixedRightModule:FixedRightModule= new FixedRightModule(pagination);
        new ShippingInfo(pagination,fixedRightModule);
        new Products(pagination);
        new BillingInfo(pagination);
        new Payment(pagination);

        //pagination.gotoPage(3);
    }

}

new OrderForm();
declare var TAX_RATES;

