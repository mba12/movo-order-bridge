var ShippingInfo = (function () {
    function ShippingInfo() {
        this.setSelectors();
        this.initEvents();
        this.initPriceSelect();
    }
    ShippingInfo.prototype.setSelectors = function () {
        this.$shippingSelect = $('#shipping-type');
    };
    ShippingInfo.prototype.initEvents = function () {
    };
    ShippingInfo.prototype.initPriceSelect = function () {
        var $form = $('form');
        var shippingTypes = $form.data('shipping-types').split('|');
        var shippingRates = $form.data('shipping-rates').split('|');
        var shippingIds = $form.data('shipping-ids').split('|');
        for (var i = 0; i < shippingTypes.length - 1; i++) {
            this.$shippingSelect.append('<option value="' + shippingIds[i] + '">' + shippingTypes[i] + ' - $' + shippingRates[i] + '</option>');
        }
    };
    return ShippingInfo;
})();
//# sourceMappingURL=shipping-info.js.map