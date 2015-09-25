var __extends = this.__extends || function (d, b) {
    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    function __() { this.constructor = d; }
    __.prototype = b.prototype;
    d.prototype = new __();
};
var Products = (function (_super) {
    __extends(Products, _super);
    function Products($pagination) {
        _super.call(this, $pagination);
        this.setSelectors();
        this.initEvents();
        this.showSizeSelectsBasedOnQuantity();
        this.showHideTooManyUnitsMessage();
    }
    Products.prototype.setSelectors = function () {
        this.$products = $('.products');
        this.$quantityInputField = $('#fixed-right-module').find('input');
        this.$tooManyUnitsMsg = $('#too-many-units');
        this.$currentPage = $('#products');
        _super.prototype.setSelectors.call(this);
    };
    Products.prototype.initEvents = function () {
        var _this = this;
        this.$quantityInputField.on('change blur', function () { return _this.onQuantityChange(); });
        _super.prototype.initEvents.call(this);
    };
    Products.prototype.onQuantityChange = function () {
        this.showSizeSelectsBasedOnQuantity();
        this.showHideTooManyUnitsMessage();
    };
    Products.prototype.showSizeSelectsBasedOnQuantity = function () {
        var $selectGroups = this.$products.find('.select-group');
        var curQty = $selectGroups.length;
        var targetQty = Math.min(parseInt(this.$quantityInputField.val()), FixedRightModule.MAX_UNITS);
        var templateHtml = $('#product-select-tpl').html();
        if (curQty < targetQty) {
            for (var i = curQty; i < targetQty; i++) {
                templateHtml = templateHtml.replace(/#unitID/g, "unit" + (i + 1).toString());
                templateHtml = templateHtml.replace(/#unitNum/g, (i + 1).toString());
                this.$products.append($(templateHtml));
            }
        }
        else {
            for (var i = curQty; i > targetQty; i--) {
                $selectGroups.last().remove();
            }
        }
    };
    Products.prototype.showHideTooManyUnitsMessage = function () {
        if (parseInt(this.$quantityInputField.val()) >= FixedRightModule.MAX_UNITS) {
            this.$quantityInputField.val(FixedRightModule.MAX_UNITS.toString());
            this.$tooManyUnitsMsg.show();
        }
        else {
            this.$tooManyUnitsMsg.hide();
        }
    };
    Products.prototype.disableQuantityStepper = function () {
        $('#fixed-right-module').find('.stepper').addClass('disabled');
        $('#fixed-right-module').find('input').attr('disabled');
    };
    Products.prototype.enableQuantityStepper = function () {
        $('#fixed-right-module').find('.stepper').removeClass('disabled');
        $('#fixed-right-module').find('input').removeProp('disabled');
    };
    Products.prototype.onPageChanged = function (pageIndex) {
        if (pageIndex == 0) {
            this.enableQuantityStepper();
        }
        else {
            this.disableQuantityStepper();
        }
    };
    return Products;
})(ScreenBase);
//# sourceMappingURL=products.js.map