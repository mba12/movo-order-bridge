/// <reference path="definitions/jquery.d.ts" />
var OrderLightbox = (function () {
    function OrderLightbox() {
        this.setSelectors();
        this.loadLightbox();
        this.initEvents();
    }
    OrderLightbox.prototype.setSelectors = function () {
        this.$body = $('body');
    };
    OrderLightbox.prototype.initEvents = function () {
        var _this = this;
        $('a[href="https://orders.getmovo.com"]').on('click', function (e) { return _this.onBuyNowClick(e); });
        $(document).on('keyup', function (e) { return _this.onKeyPress(e); });
        // used for cross-domain call from orders.getmovo.com iframe
        if (window.addEventListener) {
            addEventListener("message", function (e) { return _this.messageListener(e); }, false);
        }
        else {
            attachEvent("onmessage", function (e) { return _this.messageListener(e); });
        }
    };
    OrderLightbox.prototype.messageListener = function (event) {
        if (event.origin !== "https://orders.getmovo.com")
            return;
        if (event.data == 'close-order-lightbox') {
            this.hideLightbox();
        }
    };
    OrderLightbox.prototype.loadLightbox = function () {
        if (!cssua.ua.mobile) {
            this.$body.append('<iframe src="https://orders.getmovo.com" id="order-lightbox"></iframe>');
            this.$orderLightbox = $('#order-lightbox');
        }
    };
    OrderLightbox.prototype.onKeyPress = function (e) {
        if (e.which == 27) {
            this.hideLightbox();
        }
    };
    OrderLightbox.prototype.onBuyNowClick = function (e) {
        e.preventDefault();
        if (cssua.ua.mobile) {
            window.location.href = 'https://orders.getmovo.com';
        }
        else {
            this.showLightbox();
        }
    };
    OrderLightbox.prototype.showLightbox = function () {
        this.$body.addClass('order-lightbox-open');
        this.$orderLightbox = this.$orderLightbox.fadeIn();
    };
    OrderLightbox.prototype.hideLightbox = function () {
        var _this = this;
        this.$orderLightbox.fadeOut(300, function () {
            _this.$body.removeClass('order-lightbox-open');
        });
    };
    return OrderLightbox;
})();
new OrderLightbox();
//# sourceMappingURL=order-lightbox.js.map