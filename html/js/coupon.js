var Coupon = (function () {
    function Coupon(fixedRightModule) {
        this.fixedRightModule = fixedRightModule;
        this.order = Order.getInstance();
        this.setSelectors();
        this.initEvents();
    }
    Coupon.prototype.setSelectors = function () {
        this.$coupon = $("#coupon");
        this.$form = $("#order-form");
        this.$couponButton = $("#submit-coupon-code");
        this.$couponInput = $("#coupon-code");
        this.$couponSuccess = $("#coupon-success");
        this.$couponBlankMsg = $('#coupon-error-messages').find('.coupon-blank');
        this.$couponInvalidMsg = $('#coupon-error-messages').find('.coupon-invalid');
        this.$couponAppliedMsg = $('#coupon-error-messages').find('.coupon-applied');
    };
    Coupon.prototype.initEvents = function () {
        var _this = this;
        this.$couponButton.click(function (e) { return _this.onCouponApply(e); });
    };
    Coupon.prototype.onCouponApply = function (event) {
        var _this = this;
        event.preventDefault();
        event.stopPropagation();
        var code = this.$couponInput.val();
        this.$couponBlankMsg.hide();
        this.$couponAppliedMsg.hide();
        this.$couponAppliedMsg.hide();
        if (code.length < 1) {
            this.$couponBlankMsg.show();
            return;
        }
        var $myForm = $("<form></form>");
        $myForm.attr("action", "coupons/" + this.$couponInput.val() + "/" + $('#quantity').val());
        $myForm.append('<input type="hidden" name="_token" value="' + $('input[name=_token]').val() + '"/>');
        $myForm.serialize();
        $myForm.on("submit", function (e) {
            var method = $myForm.find('input[name="_method"]').val() || "POST";
            var url = $myForm.prop("action");
            $.ajax({
                type: method,
                url: url,
                data: $myForm.serialize(),
                success: function (result) {
                    _this.onCouponResult(result);
                },
                error: function (result) {
                    _this.onCouponResult(result);
                }
            });
            e.preventDefault();
        });
        $myForm.submit();
    };
    Coupon.prototype.onCouponResult = function (result) {
        if (result.coupon) {
            this.$couponInput.attr("name", "code");
            this.order.coupon = result.coupon;
            this.showCouponSuccessText(result.coupon.code);
            this.updateFormWithCouponData(result.token);
            this.fixedRightModule.calculatePrice();
        }
        else {
            $("#coupon-error-messages").find(".coupon-error").show().html(result.error.message);
            //this.fixedRightModule.discount = 0;
            // if(!this.order.coupon){
            //  this.order.coupon = null;
            //  }
            this.fixedRightModule.calculatePrice();
            this.fixedRightModule.hideDiscountFields();
            this.hideCouponSuccessText();
        }
    };
    Coupon.prototype.showCouponSuccessText = function (code) {
        this.$couponSuccess.show().find(".code").html(code);
        $("#coupon-error-messages").find(".coupon-invalid").hide();
        $("#coupon-error-messages").find(".coupon-error").hide();
    };
    Coupon.prototype.hideCouponSuccessText = function () {
        this.$couponSuccess.hide();
    };
    Coupon.prototype.updateFormWithCouponData = function (token) {
        this.$form.append('<input type="hidden" name="coupon_instance" value="' + token + '"/>');
        $("#coupon-code").attr("name", "code");
    };
    Coupon.reset = function () {
        $("#coupon-code").val("");
        $("#coupon-success").hide();
    };
    return Coupon;
})();
//# sourceMappingURL=coupon.js.map