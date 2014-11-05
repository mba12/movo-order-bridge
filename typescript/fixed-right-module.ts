class FixedRightModule {

    private $quantityInputField:JQuery;
    private $unitPrice:JQuery;
    private unitPriceAmt:number = parseFloat($('form').data('product-prices'));
    private $subtotal:JQuery;
    private subtotalAmt:number;
    private $shipping:JQuery;
    private shippingAmt:number;
    private $total:JQuery;
    private $shippingSelect:JQuery;
    public static MAX_UNITS:number = 8;

    constructor(public pagination:Pagination) {
        this.setSelectors();
        this.initEvents();
        this.initQuantityStepper();
        this.setQuantityFieldIfPassedIn();
        this.calculatePrice();
    }

    private setSelectors() {
        this.$quantityInputField = $('#fixed-right-module').find('input');
        var $subtotalFields = $('#subtotal-fields');
        this.$unitPrice = $subtotalFields.find('.unit-price');
        this.$subtotal = $subtotalFields.find('.subtotal');
        this.$shipping = $subtotalFields.find('.shipping');
        this.$total = $('#total').find('.price').find('li');
        this.$shippingSelect = $('#shipping-type');
    }

    private initEvents() {
        this.$quantityInputField.on('change blur', ()=>this.onQuantityChange());
        this.$quantityInputField.on('keypress', (e)=>this.onKeyPress(e));
        this.$shippingSelect.on('change', ()=>this.onShippingSelectChange());
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
        this.$quantityInputField.stepper({ min: 1, max: FixedRightModule.MAX_UNITS});
    }

    private getParameterByName(name):any {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"), results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    private onShippingSelectChange():void {
        this.calculatePrice();
    }

    private getQuantity():number {
        return Math.min(parseInt(this.$quantityInputField.val()), FixedRightModule.MAX_UNITS)
    }

    private calculatePrice():void {
        this.setUnitPrice();
        this.setSubtotal();
        this.setShipping();
        this.setTotal();
    }

    private setUnitPrice():void {
        var priceStr:string = '$' + this.unitPriceAmt;
        this.$unitPrice.html(priceStr);
    }

    private setSubtotal():void {
        this.subtotalAmt = this.getQuantity() * this.unitPriceAmt;
        this.$subtotal.html('$' + this.subtotalAmt.toFixed(2));
    }

    private setShipping():void {
        if (this.$shippingSelect.val() == '') {
            this.shippingAmt = 0;
            this.$shipping = this.$shipping.html('--');
        } else {
            this.shippingAmt = parseFloat(this.$shippingSelect.find('option:selected').data('price'));
            this.$shipping = this.$shipping.html('$' + this.shippingAmt.toFixed(2));
        }
    }

    private setTotal():void {
        var totalStr:string = '$' + (this.subtotalAmt + this.shippingAmt).toFixed(2);
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
