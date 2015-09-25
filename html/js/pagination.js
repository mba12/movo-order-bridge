/// <reference path="definitions/js-signals.d.ts" />
var Pagination = (function () {
    function Pagination() {
        this.currentIndex = 0;
        this.pageChanged = new signals.Signal();
        this.setSelectors();
        this.initPages();
        this.showCurrentPage();
    }
    Pagination.prototype.setSelectors = function () {
        this.$navLis = $('#nav').find("li");
    };
    Pagination.prototype.initPages = function () {
        this.pages = [
            $('#products'),
            $('#loops'),
            $('#billing-info'),
            $('#shipping-info'),
            $('#payment'),
            $('#summary')
        ];
        this.$currentPage = this.pages[this.currentIndex];
    };
    Pagination.prototype.showCurrentPage = function () {
        this.$currentPage = this.pages[this.currentIndex];
        for (var i = 0; i < this.pages.length; i++) {
            $(this.pages[i]).hide();
        }
        this.$currentPage.show();
        this.$navLis.removeClass("active");
        $(this.$navLis[this.currentIndex]).addClass("active");
        this.pageChanged.dispatch(this.currentIndex);
    };
    Pagination.prototype.previous = function () {
        this.currentIndex--;
        if (this.currentIndex < 0) {
            this.currentIndex = 0;
        }
    };
    Pagination.prototype.next = function () {
        this.currentIndex++;
        if (this.currentIndex > this.pages.length - 1) {
            this.currentIndex = this.pages.length - 1;
        }
    };
    Pagination.prototype.gotoProductsPage = function () {
        this.currentIndex = 0;
        this.showCurrentPage();
    };
    Pagination.prototype.gotoSummaryPage = function () {
        this.currentIndex = 5;
        this.showCurrentPage();
    };
    Pagination.prototype.gotoShippingPage = function () {
        this.currentIndex = 3;
        this.showCurrentPage();
    };
    Pagination.prototype.gotoPage = function (page) {
        this.currentIndex = page;
        this.showCurrentPage();
    };
    return Pagination;
})();
//# sourceMappingURL=pagination.js.map