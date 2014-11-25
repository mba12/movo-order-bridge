class Order{
    private static _instance:Order = null;

    public coupon: CouponData;
    private salesTax:SalesTax = new SalesTax();
    private currentState:string;
    private currentZipcode:string;

    private $form:JQuery;
    private $quantityInputField:JQuery;
    private $shippingSelect:JQuery;
    private $shippingCountrySelect:JQuery;
    private $shippingStateSelect:JQuery;
    private $shippingZipCode:JQuery;

    constructor() {
        if(Order._instance){
            throw new Error("Error: Instantiation failed: Use Order.getInstance() instead of new.");
        }
        Order._instance = this;
        this.setSelectors();
    }

    public static getInstance():Order
    {
        if(Order._instance === null) {
            Order._instance = new Order();
        }
        return Order._instance;
    }


    private setSelectors():void{
        this.$form = $('#order-form');
        this.$shippingSelect = $('#shipping-type');
        this.$shippingCountrySelect = $('#shipping-country');
        this.$shippingZipCode = $('#shipping-zip');
        this.$shippingStateSelect = $('#shipping-state-select');
        this.$quantityInputField=$("#quantity");
    }
    public resetOrder():void{
        this.coupon=null;
        this.currentState="";
        this.currentZipcode="";
    }

    public getUnitPrice():number {
        return parseFloat(this.$form.data('product-prices'))
    }

    public getDiscount():number {
        var discount:number=0;
        if (this.coupon) {
            if (this.getQuantity() >= this.coupon.min_units) {
                if (this.coupon.method == "$") {
                    discount= this.coupon.amount;
                } else {
                    discount = (this.coupon.amount / 100) * this.getQuantity() * this.getUnitPrice();
                }
            }

        }
        return  Math.round(discount);
    }

    public getQuantity():number {
        return Math.min(parseInt(this.$quantityInputField.val()), FixedRightModule.MAX_UNITS)
    }

    public getSubtotal():number {
        return this.getQuantity() * this.getUnitPrice();
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
            if (callback) callback(response);
        })
    }

    public getSalesTax():number {
        return this.salesTax.total(this.getQuantity(), this.getUnitPrice(), this.getDiscount(), this.getShippingPrice(), this.$shippingStateSelect.val());
    }

    public getShippingPrice():number {
        if (!this.$shippingSelect.val() || this.$shippingSelect.val() == '') {
            return 0;
        } else {
            return parseFloat(this.$shippingSelect.find('option:selected').data('price'));
        }
    }

    public getTotal():number {
        return this.getSubtotal() + this.getShippingPrice() - this.getDiscount() + this.getSalesTax();
    }
}