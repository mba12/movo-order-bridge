class Coupon {

    private $coupon:JQuery;
    private $form:JQuery;
    private $couponButton:JQuery;
    private $couponInput:JQuery;
    private $couponBlankMsg:JQuery;
    private $couponInvalidMsg:JQuery;
    private $couponAppliedMsg:JQuery;

    constructor(public callback) {
        this.setSelectors();
        this.initEvents();
    }

    private setSelectors():void {
        this.$coupon = $("#coupon");
        this.$form = $("#order-form");
        this.$couponButton = $("#submit-coupon-code");
        this.$couponInput = $("#coupon-code");
        this.$couponBlankMsg = $('#coupon-error-messages').find('.coupon-blank');
        this.$couponInvalidMsg = $('#coupon-error-messages').find('.coupon-invalid');
        this.$couponAppliedMsg = $('#coupon-error-messages').find('.coupon-applied');
    }

    private initEvents():void {
        // this.$coupon.keypress((event)=>this.onKeyPress(event));
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
        $myForm.attr("action", "coupons/" + this.$couponInput.val()+"/"+$('#quantity').val());
        $myForm.append('<input type="hidden" name="_token" value="' + $('input[name=_token]').val() + '"/>');
        $myForm.serialize();
        $myForm.on("submit", (e)=> {
            var method:string = $myForm.find('input[name="_method"]').val() || "POST";
            var url = $myForm.prop("action");
            $.ajax({
                type: method, url: url, data: $myForm.serialize(), success: (result)=> {
                    this.$couponInput.attr("name", "code");
                    this.callback(result);

                }, error: (result)=> {
                    //this.errorCallback(result);
                }
            });
            e.preventDefault();
        })
        $myForm.submit();

    }

    private onSuccess(result):void {
        console.log(result);
    }

    private onError(result):void {
        console.log(result);
    }

}