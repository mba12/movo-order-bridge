class FixedRightModule {

    private $quantityInputField:JQuery;
    private $unitPrice:JQuery;
    private $form;
    private unitPriceAmt:number;
    private $subtotal:JQuery;
    private $salesTax:JQuery;
    private subtotalAmt:number;
    private salesTax:number = 0;
    private $shipping:JQuery;
    private shippingAmt:number;
    private $total:JQuery;
    private $shippingSelect:JQuery;
    private $shippingCountrySelect:JQuery;
    private $shippingStateSelect:JQuery;
    private $shippingZipCode:JQuery;
    public static MAX_UNITS:number = 8;
    private coupon:CouponData;
    private discount:number = 0;
    private currentState:string = "";
    private currentZipcode:string = "";

    constructor(public pagination:Pagination) {
        this.setSelectors();
        this.setUnitPrice();
        this.initEvents();
        this.initQuantityStepper();
        this.setQuantityFieldIfPassedIn();
        this.calculatePrice();
        new Coupon((result)=>this.onCouponSuccess(result));
    }

    private setSelectors() {
        this.$quantityInputField = $('#quantity');
        var $subtotalFields = $('#subtotal-fields');
        this.$form = $('#order-form');
        this.$unitPrice = $subtotalFields.find('.unit-price');
        this.$salesTax = $subtotalFields.find('.sales-tax');
        this.$subtotal = $subtotalFields.find('.subtotal');
        this.$shipping = $subtotalFields.find('.shipping');
        this.$total = $('#total').find('.price').find('li');
        this.$shippingSelect = $('#shipping-type');
        this.$shippingCountrySelect = $('#shipping-country');
        this.$shippingZipCode = $('#shipping-zip');
        this.$shippingStateSelect = $('#shipping-state-select');
    }

    private initEvents() {
        this.$quantityInputField.on('change blur', ()=>this.onQuantityChange());
        this.$quantityInputField.on('keypress', (e)=>this.onKeyPress(e));
        this.$shippingSelect.on('change', ()=>this.onShippingSelectChange());
        this.$shippingCountrySelect.on('change', ()=>this.onShippingCountrySelectChange());
    }

    private setQuantityFieldIfPassedIn():void {
        var passedInQuantity:number = parseInt(this.getParameterByName('quantity'));
        if (passedInQuantity > 0) {
            this.$quantityInputField.val(passedInQuantity.toString());
        }
    }

    private onCouponSuccess(result):void {
        if (result) {
            this.coupon = result.coupon;
            this.$form.append('<input type="hidden" name="coupon_instance" value="' + result.token + '"/>')
            $("#coupon-code").attr("name", "code");
            this.calculatePrice();
        }

        //TODO make not input
    }

    private onQuantityChange():void {
        this.calculatePrice();
        this.pagination.gotoProductsPage();
    }

    private initQuantityStepper():void {
        this.$quantityInputField.stepper({min: 1, max: FixedRightModule.MAX_UNITS});
    }

    private getParameterByName(name):any {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"), results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    private onShippingSelectChange():void {
        this.calculatePrice();
    }

    private onShippingCountrySelectChange():void {
        this.calculatePrice();
    }


    private getQuantity():number {
        return Math.min(parseInt(this.$quantityInputField.val()), FixedRightModule.MAX_UNITS)
    }

    public  calculatePrice():void {
        this.setUnitPrice();
        this.applyCoupon();
        this.setSubtotal();
        this.setSalesTax();
        this.setShipping();
        this.setTotal();
    }

    private setUnitPrice():void {
        this.unitPriceAmt = parseFloat(this.$form.data('product-prices'))
        var priceStr:string = '$' + this.unitPriceAmt;
        this.$unitPrice.html(priceStr);
    }

    private applyCoupon():void {
        if (this.coupon) {
            if (this.getQuantity() >= this.coupon.min_units) {
                if (this.coupon.method == "$") {
                    this.discount = this.coupon.amount;
                } else {
                    this.discount = (this.coupon.amount / 100) * this.getQuantity() * this.unitPriceAmt;

                }
            }

        }
    }

    private setSubtotal():void {
        this.subtotalAmt = this.getQuantity() * this.unitPriceAmt - this.discount;
        this.$subtotal.html('$' + this.subtotalAmt.toFixed(2));
    }

    public setSalesTax(callback?:any):void {
        if (this.$shippingCountrySelect.val() != "US") {
            return;
        }
        if (this.$shippingStateSelect.val() == "" || this.$shippingStateSelect.val() == this.currentState) {
            return;
        }
        if (this.$shippingZipCode.val() == "" || this.$shippingZipCode.val() == this.currentZipcode) {
            return;
        }
        var taxRate:number = 0;
        $.ajax({
            type: 'GET',
            url: "/tax/" + this.$shippingZipCode.val() + "/" + this.$shippingStateSelect.val(),
            success: (taxRate)=> {
                if(callback) callback(taxRate);
                if (taxRate.error) {
                    return;
                }
                this.salesTax = (this.getQuantity() * this.unitPriceAmt - this.discount) * taxRate.rate;
                this.$salesTax.html('$' + this.salesTax.toFixed(2));
            },
            error: (response)=> {
                if(callback) callback({error:"There was an error retrieving sales tax"});;
            }
        });
    }


    private setShipping():void {
        var foo = this.$shippingSelect.val();
        if (!this.$shippingSelect.val() || this.$shippingSelect.val() == '') {
            this.shippingAmt = 0;
            this.$shipping = this.$shipping.html('--');
        } else {
            this.shippingAmt = parseFloat(this.$shippingSelect.find('option:selected').data('price'));
            this.$shipping = this.$shipping.html('$' + this.shippingAmt.toFixed(2));
        }
    }

    private setTotal():void {
        var totalStr:string = '$' + (this.subtotalAmt + this.shippingAmt + this.salesTax).toFixed(2);
        this.$total.html(totalStr);
    }

    private onKeyPress(e):void {
        this.restrictInputToNumbers(e);
    }

    private restrictInputToNumbers(evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
        var regex = /[0-9]|\./;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault) theEvent.preventDefault();
        }
    }

}
