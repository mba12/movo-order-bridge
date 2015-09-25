var __extends = this.__extends || function (d, b) {
    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    function __() { this.constructor = d; }
    __.prototype = b.prototype;
    d.prototype = new __();
};
var Summary = (function (_super) {
    __extends(Summary, _super);
    function Summary($pagination, fixedRightModule) {
        _super.call(this, $pagination);
        this.fixedRightModule = fixedRightModule;
        this.setSelectors();
        this.initEvents();
    }
    Summary.prototype.setSelectors = function () {
        this.$createNewOrderBtn = $('#create-new-order');
    };
    Summary.prototype.initEvents = function () {
        var _this = this;
        //super.initEvents();
        this.$createNewOrderBtn.on('click', function (e) { return _this.onCreateNewOrderBtnClick(e); });
    };
    Summary.prototype.onCreateNewOrderBtnClick = function (e) {
        e.preventDefault();
        //this.fixedRightModule.resetOrder();
        //this.pagination.gotoProductsPage();
        location.reload();
    };
    return Summary;
})(ScreenBase);
//# sourceMappingURL=summary.js.map