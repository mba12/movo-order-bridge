var __extends = this.__extends || function (d, b) {
    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    function __() { this.constructor = d; }
    __.prototype = b.prototype;
    d.prototype = new __();
};
var BillingInfo = (function (_super) {
    __extends(BillingInfo, _super);
    function BillingInfo($pagination) {
        _super.call(this, $pagination);
        this.setSelectors();
        this.initEvents();
        this.setCountryToUnitedStates();
        this.showStateSelectOrInput();
    }
    BillingInfo.prototype.setSelectors = function () {
        this.$countrySelect = $('#billing-country');
        this.$stateSelect = $('#billing-state-select');
        this.$stateInput = $('#billing-state-input');
        this.$currentPage = $('#billing-info');
        _super.prototype.setSelectors.call(this);
    };
    BillingInfo.prototype.initEvents = function () {
        var _this = this;
        this.$countrySelect.on('change', function () { return _this.onCountryChange(); });
        _super.prototype.initEvents.call(this);
    };
    BillingInfo.prototype.setCountryToUnitedStates = function () {
        this.$countrySelect.find("option[value='US']").attr("selected", "selected");
    };
    BillingInfo.prototype.onCountryChange = function () {
        this.showStateSelectOrInput();
    };
    BillingInfo.prototype.showStateSelectOrInput = function () {
        if (this.$countrySelect.val() == 'US') {
            this.showStateSelect();
        }
        else {
            this.showStateInput();
        }
    };
    BillingInfo.prototype.showStateSelect = function () {
        this.$stateSelect.parent().show();
        this.$stateInput.parent().hide();
    };
    BillingInfo.prototype.showStateInput = function () {
        this.$stateInput.parent().show();
        this.$stateSelect.parent().hide();
    };
    return BillingInfo;
})(ScreenBase);
//# sourceMappingURL=billing-info.js.map