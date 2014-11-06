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

class OrderForm {

    constructor() {
        var pagination = new Pagination();

        new ShippingInfo(pagination);
        new FixedRightModule(pagination);
        new Products(pagination);
        new BillingInfo(pagination);
        new Payment(pagination);
    }

}

new OrderForm();
