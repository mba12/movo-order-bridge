class FixedRightModule {

    private $quantityInputField:JQuery;
    private $unitPrice:JQuery;
    private $form;
    private $subtotal:JQuery;
    private $salesTax:JQuery;
    private $shipping:JQuery;
    private $total:JQuery;
    private $shippingSelect:JQuery;
    private $shippingCountrySelect:JQuery;
    private $shippingStateSelect:JQuery;
    private $shippingZipCode:JQuery;

    public static MAX_UNITS:number = 8;
    private currentState:string = "";
    private currentZipcode:string = "";
    private salesTax:SalesTax = new SalesTax();
    private $discount:JQuery;

    private order:Order=Order.getInstance();

    constructor(public pagination:Pagination) {
        this.setSelectors();
        this.setUnitPrice();
        this.initEvents();
        this.initQuantityStepper();
        this.setQuantityFieldIfPassedIn();
        this.calculatePrice();
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
        this.$discount = $('#subtotal-fields').find('.discount');
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

    public calculatePrice():void {
        this.setUnitPrice();
        this.applyCoupon();
        this.setSubtotal();
        this.setSalesTax();
        this.setShipping();
        this.setTotal();
    }

    private setUnitPrice():void {

        var priceStr:string = '$' + this.order.getUnitPrice();
        this.$unitPrice.html(priceStr);
    }

    private applyCoupon():void {
        if (this.order.getDiscount()>0) {

            this.$discount.fadeIn();
            var discountStr:string = "-$" + parseFloat(<any>(Math.round(this.order.getDiscount() * 100) / 100)).toFixed(2);
            $('#subtotal-fields').find('.price').find('.discount').html(discountStr);
        } else {
            this.$discount.fadeOut();

        }

    }

    public hideDiscountFields():void {
        this.$discount.hide();
    }

    private setSubtotal():void {

        this.$subtotal.html('$' + this.order.getSubtotal().toFixed(2));
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

        this.salesTax.setLocation(this.$shippingZipCode.val(), this.$shippingStateSelect.val(), (response)=> {
            this.$salesTax.html('$' + this.getSalesTax().toFixed(2));
            if (callback) callback(response);
        })
    }

    private getSalesTax():number {
        return this.salesTax.total(this.order.getQuantity(), this.order.getUnitPrice(), this.order.getDiscount(), this.order.getShippingPrice(), this.$shippingStateSelect.val());
    }

    private setShipping():void {
        if (!this.$shippingSelect.val() || this.$shippingSelect.val() == '') {

            this.$shipping.html('--');
        } else {
            this.$shipping.html('$' + this.order.getShippingPrice().toFixed(2));
        }
    }

    public setTotal():void {
        var totalStr:string = '$' + (this.order.getSubtotal() + this.order.getShippingPrice() - this.order.getDiscount() + this.getSalesTax()).toFixed(2);
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

    public resetOrder():void{
        this.order.resetOrder();
        Coupon.reset();
        this.hideDiscountFields();
        $("#shipping-type option:selected").prop("selected", false);
        $("#shipping-type option:first").prop("selected", "selected");
        this.$quantityInputField.val("1");
        this.calculatePrice();

    }

}