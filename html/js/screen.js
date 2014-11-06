var OrderForm = (function () {
    function OrderForm() {
        this.setSelectors();
        this.initEvents();
        this.pagination = new Pagination();
        this.pagination.showCurrentPage();
        new ShippingInfo();
        new FixedRightModule(this.pagination);
        new Products();
        new BillingInfo();
        new Payment();
    }
    OrderForm.prototype.setSelectors = function () {
        this.$nextBtns = $('.prev-next .next');
        this.$previousBtns = $('.prev-next .prev');
    };
    OrderForm.prototype.initEvents = function () {
        var _this = this;
        this.$nextBtns.on('click', function () { return _this.onNextButtonClick(); });
        this.$previousBtns.on('click', function () { return _this.onPreviousButtonClick(); });
    };
    OrderForm.prototype.onNextButtonClick = function () {
        this.pagination.next();
        this.pagination.showCurrentPage();
    };
    OrderForm.prototype.onPreviousButtonClick = function () {
        this.pagination.previous();
        this.pagination.showCurrentPage();
    };
    return OrderForm;
})();
new OrderForm();
//# sourceMappingURL=screen.js.map