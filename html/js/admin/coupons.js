/// <reference path="../definitions/jquery.d.ts" />
/// <reference path="../definitions/chart.d.ts" />
var Coupons = (function () {
    function Coupons() {
        this.initEvents();
        this.initDatePicker();
    }
    Coupons.prototype.initEvents = function () {
        var _this = this;
        $('.delete-button').find('.button').on('click', function (e) { return _this.onDeleteButtonClick(e); });
    };
    Coupons.prototype.onDeleteButtonClick = function (e) {
        if (!confirm("Delete Coupon?")) {
            e.preventDefault();
        }
    };
    Coupons.prototype.initDatePicker = function () {
        var $pickers = $('.datetimepicker');
        $pickers.datetimepicker();
    };
    return Coupons;
})();
new Coupons();
//# sourceMappingURL=coupons.js.map