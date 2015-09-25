var FixedRightModule = (function () {
    function FixedRightModule(pagination) {
        this.pagination = pagination;
        this.currentState = "";
        this.currentZipcode = "";
        this.salesTax = new SalesTax();
        this.order = Order.getInstance();
        this.setSelectors();
        this.setUnitPrice();
        this.initEvents();
        this.initQuantityStepper();
        this.setQuantityFieldIfPassedIn();
        this.calculatePrice();
    }
    FixedRightModule.prototype.setSelectors = function () {
        this.$quantityInputField = $('#quantity');
        var $subtotalFields = $('#subtotal-fields');
        this.$form = $('#order-form');
        this.$unitPrice = $subtotalFields.find('.unit-price');
        this.$salesTax = $subtotalFields.find('.sales-tax');
        this.$subtotal = $subtotalFields.find('.subtotal');
        this.$shipping = $subtotalFields.find('.shipping');
        this.$total = $('#total').find('.price').find('li');
        this.$shippingSelect = $('#shipping-type');
        this.$shippingCountrySelect = $('#shipping-country');
        this.$shippingZipCode = $('#shipping-zip');
        this.$shippingStateSelect = $('#shipping-state-select');
        this.$discount = $('#subtotal-fields').find('.discount');
        this.$loopInputFields = $('#loops').find('.loop-input');
    };
    FixedRightModule.prototype.initEvents = function () {
        var _this = this;
        this.$quantityInputField.on('change blur', function () { return _this.onQuantityChange(); });
        this.$quantityInputField.on('keypress', function (e) { return _this.onKeyPress(e); });
        this.$shippingSelect.on('change', function () { return _this.onShippingSelectChange(); });
        this.$shippingCountrySelect.on('change', function () { return _this.onShippingCountrySelectChange(); });
        this.$loopInputFields.on('change', function () { return _this.onLoopInputChange(); });
    };
    FixedRightModule.prototype.setQuantityFieldIfPassedIn = function () {
        var passedInQuantity = parseInt(this.getParameterByName('quantity'));
        if (passedInQuantity > 0) {
            this.$quantityInputField.val(passedInQuantity.toString());
        }
    };
    FixedRightModule.prototype.onQuantityChange = function () {
        this.calculatePrice();
        this.pagination.gotoProductsPage();
    };
    FixedRightModule.prototype.initQuantityStepper = function () {
        this.$quantityInputField.stepper({ min: 0, max: FixedRightModule.MAX_UNITS });
    };
    FixedRightModule.prototype.getParameterByName = function (name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"), results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    };
    FixedRightModule.prototype.onShippingSelectChange = function () {
        this.calculatePrice();
    };
    FixedRightModule.prototype.onShippingCountrySelectChange = function () {
        this.calculatePrice();
    };
    FixedRightModule.prototype.onLoopInputChange = function () {
        this.calculatePrice();
    };
    FixedRightModule.prototype.calculatePrice = function () {
        this.setUnitPrice();
        this.applyCoupon();
        this.setSubtotal();
        this.setSalesTax();
        this.setShipping();
        this.setTotal();
    };
    FixedRightModule.prototype.setUnitPrice = function () {
        //var priceStr:string = '$' + this.order.getUnitPrice();
        //this.$unitPrice.html(priceStr);
    };
    FixedRightModule.prototype.applyCoupon = function () {
        if (this.order.getDiscount() > 0) {
            this.$discount.fadeIn();
            var discountStr = "-$" + parseFloat((Math.round(this.order.getDiscount() * 100) / 100)).toFixed(2);
            $('#subtotal-fields').find('.price').find('.discount').html(discountStr);
        }
        else {
            this.$discount.fadeOut();
        }
    };
    FixedRightModule.prototype.hideDiscountFields = function () {
        this.$discount.hide();
    };
    FixedRightModule.prototype.setSubtotal = function () {
        this.$subtotal.html('$' + this.order.getSubtotal().toFixed(2));
    };
    FixedRightModule.prototype.setSalesTax = function (callback) {
        var _this = this;
        if (this.$shippingCountrySelect.val() != "US") {
            return;
        }
        if (this.$shippingStateSelect.val() == "" || this.$shippingStateSelect.val() == this.currentState) {
            return;
        }
        if (this.$shippingZipCode.val() == "" || this.$shippingZipCode.val() == this.currentZipcode) {
            return;
        }
        this.salesTax.setLocation(this.$shippingZipCode.val(), this.$shippingStateSelect.val(), function (response) {
            _this.$salesTax.html('$' + _this.getSalesTax().toFixed(2));
            _this.setTotal();
            if (callback)
                callback(response);
        });
    };
    FixedRightModule.prototype.getSalesTax = function () {
        return this.salesTax.total(this.order.getSubtotal(), this.order.getDiscount(), this.order.getShippingPrice(), this.$shippingStateSelect.val());
    };
    FixedRightModule.prototype.setShipping = function () {
        if (!this.$shippingSelect.val() || this.$shippingSelect.val() == '') {
            this.$shipping.html('--');
        }
        else {
            this.$shipping.html('$' + this.order.getShippingPrice().toFixed(2));
        }
    };
    FixedRightModule.prototype.setTotal = function () {
        var totalStr = '$' + (this.order.getSubtotal() + this.order.getShippingPrice() - this.order.getDiscount() + this.getSalesTax()).toFixed(2);
        this.$total.html(totalStr);
    };
    FixedRightModule.prototype.onKeyPress = function (e) {
        this.restrictInputToNumbers(e);
    };
    FixedRightModule.prototype.restrictInputToNumbers = function (evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
        var regex = /[0-9]|\./;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault)
                theEvent.preventDefault();
        }
    };
    FixedRightModule.prototype.resetOrder = function () {
        this.order.resetOrder();
        Coupon.reset();
        this.hideDiscountFields();
        $("#shipping-type option:selected").prop("selected", false);
        $("#shipping-type option:first").prop("selected", "selected");
        this.$quantityInputField.val("1");
        this.calculatePrice();
    };
    FixedRightModule.MAX_UNITS = 8;
    return FixedRightModule;
})();
//# sourceMappingURL=fixed-right-module.js.map