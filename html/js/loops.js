var __extends = this.__extends || function (d, b) {
    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    function __() { this.constructor = d; }
    __.prototype = b.prototype;
    d.prototype = new __();
};
var Loops = (function (_super) {
    __extends(Loops, _super);
    function Loops($pagination, fixedRightModule) {
        _super.call(this, $pagination);
        this.fixedRightModule = fixedRightModule;
        this.setSelectors();
        this.initEvents();
        this.initQuantitySteppers();
        var loopsArray = [];
        $('#loops').find('.loop-input').each(function (i, el) {
            var $item = $(el);
            if ($item.val() > -1) {
                loopsArray.push({
                    sku: $item.data('sku'),
                    name: $item.data('name'),
                    quantity: $item.val()
                });
            }
        });
    }
    Loops.prototype.setSelectors = function () {
        this.$currentPage = $('#loops');
        this.$qty = this.$currentPage.find('.qty').find('input');
        _super.prototype.setSelectors.call(this);
    };
    Loops.prototype.initEvents = function () {
        _super.prototype.initEvents.call(this);
    };
    Loops.prototype.initQuantitySteppers = function () {
        this.$qty.stepper({ min: 0, max: 99 });
    };
    Loops.prototype.onPrevClick = function () {
        this.$currentPage.find('.no-products').hide();
        _super.prototype.onPrevClick.call(this);
    };
    Loops.prototype.onNextClick = function () {
        if (Order.getInstance().getSubtotal() > 0) {
            this.pagination.next();
            this.pagination.showCurrentPage();
            this.$currentPage.find('.no-products').hide();
        }
        else {
            this.$currentPage.find('.no-products').show();
        }
    };
    return Loops;
})(ScreenBase);
//# sourceMappingURL=loops.js.map