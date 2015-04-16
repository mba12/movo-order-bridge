class Coupon {

    private $coupon:JQuery;
    private $form:JQuery;
    private $couponButton:JQuery;
    private $couponInput:JQuery;
    private $couponBlankMsg:JQuery;
    private $couponInvalidMsg:JQuery;
    private $couponAppliedMsg:JQuery;
    private $couponSuccess:JQuery;
    private order:Order = Order.getInstance();

    constructor(public fixedRightModule:FixedRightModule) {
        this.setSelectors();
        this.initEvents();
    }

    private setSelectors():void {
        this.$coupon = $("#coupon");
        this.$form = $("#order-form");
        this.$couponButton = $("#submit-coupon-code");
        this.$couponInput = $("#coupon-code");
        this.$couponSuccess = $("#coupon-success");
        this.$couponBlankMsg = $('#coupon-error-messages').find('.coupon-blank');
        this.$couponInvalidMsg = $('#coupon-error-messages').find('.coupon-invalid');
        this.$couponAppliedMsg = $('#coupon-error-messages').find('.coupon-applied');
    }

    private initEvents():void {
        this.$couponButton.click((e)=>this.onCouponApply(e))
    }

    private onCouponApply(event):void {
        event.preventDefault();
        event.stopPropagation();

        var code:string = this.$couponInput.val();
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
        $myForm.on("submit", (e)=> {
            var method:string = $myForm.find('input[name="_method"]').val() || "POST";
            var url = $myForm.prop("action");
            $.ajax({
                type: method, url: url, data: $myForm.serialize(), success: (result)=> {
                    this.onCouponResult(result);
                }, error: (result)=> {
                    this.onCouponResult(result);
                }
            });
            e.preventDefault();
        })
        $myForm.submit();

    }

    private onCouponResult(result):void {
        if (result.coupon) {
            this.$couponInput.attr("name", "code");
            this.order.coupon = result.coupon;
            this.showCouponSuccessText(result.coupon.code);
            this.updateFormWithCouponData(result.token);
            this.fixedRightModule.calculatePrice();
        } else {
            $("#coupon-error-messages").find(".coupon-error").show().html(result.error.message);
            //this.fixedRightModule.discount = 0;
            // if(!this.order.coupon){
            //  this.order.coupon = null;
            //  }
            this.fixedRightModule.calculatePrice();
            this.fixedRightModule.hideDiscountFields();
            this.hideCouponSuccessText();
        }
    }

    private showCouponSuccessText(code):void {
        this.$couponSuccess.show().find(".code").html(code);
        $("#coupon-error-messages").find(".coupon-invalid").hide();
        $("#coupon-error-messages").find(".coupon-error").hide();
    }

    private hideCouponSuccessText():void {
        this.$couponSuccess.hide();
    }

    private updateFormWithCouponData(token:string):void {
        this.$form.append('<input type="hidden" name="coupon_instance" value="' + token + '"/>')
        $("#coupon-code").attr("name", "code");
    }

    public static reset() {
        $("#coupon-code").val("");
        $("#coupon-success").hide();
    }

}