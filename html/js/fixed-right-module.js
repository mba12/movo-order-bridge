var FixedRightModule = (function () {
    function FixedRightModule() {
        this.setSelectors();
        this.initEvents();
        this.initQuantityStepper();
        this.setQuantityFieldIfPassedIn();
        this.showSizeSelectsBasedOnQuantity();
        this.showHideTooManyUnitsMessage();
        this.calculatePrice();
    }
    FixedRightModule.prototype.setSelectors = function () {
        this.$products = $('.products');
        this.$quantityInputField = $('#fixed-right-module').find('input');
        this.$tooManyUnitsMsg = $('#too-many-units');
    };
    FixedRightModule.prototype.initEvents = function () {
        var _this = this;
        this.$quantityInputField.on('change blur', function () { return _this.onQuantityChange(); });
    };
    FixedRightModule.prototype.setQuantityFieldIfPassedIn = function () {
        var passedInQuantity = parseInt(this.getParameterByName('quantity'));
        if (passedInQuantity > 0) {
            this.$quantityInputField.val(passedInQuantity.toString());
        }
    };
    FixedRightModule.prototype.onQuantityChange = function () {
        var _this = this;
        setTimeout(function () {
            _this.showSizeSelectsBasedOnQuantity();
            _this.showHideTooManyUnitsMessage();
        }, 100);
    };
    FixedRightModule.prototype.showSizeSelectsBasedOnQuantity = function () {
        var $selectGroups = this.$products.find('.select-group');
        var curQty = $selectGroups.length;
        var targetQty = Math.min(parseInt(this.$quantityInputField.val()), Products.MAX_UNITS);
        var templateHtml = $('#product-select-tpl').html();
        if (curQty < targetQty) {
            for (var i = curQty; i < targetQty; i++) {
                templateHtml = templateHtml.replace('X', (i + 1).toString());
                this.$products.append($(templateHtml));
            }
        }
        else {
            for (var i = curQty; i > targetQty; i--) {
                $selectGroups.last().remove();
            }
        }
    };
    FixedRightModule.prototype.showHideTooManyUnitsMessage = function () {
        if (parseInt(this.$quantityInputField.val()) >= Products.MAX_UNITS) {
            this.$tooManyUnitsMsg.show();
        }
        else {
            this.$tooManyUnitsMsg.hide();
        }
    };
    FixedRightModule.prototype.initQuantityStepper = function () {
        this.$quantityInputField.stepper({ min: 1, max: Products.MAX_UNITS });
    };
    FixedRightModule.prototype.getParameterByName = function (name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"), results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    };
    FixedRightModule.prototype.calculatePrice = function () {
    };
    FixedRightModule.MAX_UNITS = 8;
    return FixedRightModule;
})();
new FixedRightModule();
//# sourceMappingURL=fixed-right-module.js.map