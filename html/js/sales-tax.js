var SalesTax = (function () {
    function SalesTax() {
        this.rate = 0;
        this.state = "";
        this.zipcode = "";
        // private taxMethods = [new ExcludeShippingMethod(), new IncludeShippingMethod()];
        this.taxMethods = [new IncludeShippingMethod()];
    }
    SalesTax.prototype.setLocation = function (zipcode, state, callback) {
        var _this = this;
        if (zipcode == this.zipcode && state == this.state) {
            if (callback)
                callback({ rate: this.rate });
            return;
        }
        this.zipcode = zipcode;
        this.state = state;
        $.ajax({
            type: 'GET',
            url: "/tax/" + zipcode + "/" + state,
            success: function (response) {
                if (response.error) {
                    if (callback)
                        callback(response);
                    return;
                }
                _this.rate = response.rate;
                console.log("This is a test to compile: " + _this.rate);
                if (callback)
                    callback(response);
            },
            error: function (response) {
                if (callback)
                    callback({ error: "There was an error retrieving sales tax" });
            }
        });
    };
    SalesTax.prototype.total = function (subtotal, discount, shippingRate, state) {
        if (!state || state == "") {
            return 0;
        }
        return this.getTaxMethod(state).calculate(subtotal, discount, shippingRate, this.rate);
    };
    SalesTax.prototype.getTaxMethod = function (state) {
        state = state.trim();
        for (var i = 0; i < TAX_TABLE.length; i++) {
            var taxObj = TAX_TABLE[i];
            if (taxObj.state.trim() == state) {
                return this.taxMethods[taxObj.method];
            }
        }
        throw new Error("state not found in list");
    };
    return SalesTax;
})();
//# sourceMappingURL=sales-tax.js.map