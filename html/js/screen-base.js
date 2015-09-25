var ScreenBase = (function () {
    function ScreenBase(pagination) {
        this.pagination = pagination;
        this.ajaxCallPending = false;
    }
    ScreenBase.prototype.setSelectors = function () {
        this.$prevBtn = $('.prev', this.$currentPage);
        this.$nextBtn = $('.next', this.$currentPage);
    };
    ScreenBase.prototype.initEvents = function () {
        var _this = this;
        this.$prevBtn.on('click', function () { return _this.onPrevClick(); });
        this.$nextBtn.on('click', function () { return _this.onNextClick(); });
        this.pagination.pageChanged.add(function (pageIndex) { return _this.onPageChanged(pageIndex); });
    };
    ScreenBase.prototype.onPrevClick = function () {
        var validation = new Validation($('[data-validate]', this.$currentPage).filter(':visible'));
        validation.resetErrors();
        this.pagination.previous();
        this.pagination.showCurrentPage();
    };
    ScreenBase.prototype.onNextClick = function () {
        var validation = new Validation($('[data-validate]', this.$currentPage).filter(':visible'));
        if (!validation.isValidForm()) {
            validation.showErrors();
            return;
        }
        validation.resetErrors();
        this.pagination.next();
        this.pagination.showCurrentPage();
    };
    ScreenBase.prototype.onPageChanged = function (pageIndex) {
    };
    return ScreenBase;
})();
//# sourceMappingURL=screen-base.js.map