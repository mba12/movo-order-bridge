class ShippingInfo {

    private $shippingSelect:JQuery;

    constructor() {
        this.setSelectors();
        this.initEvents();
        this.initPriceSelect();
    }

    private setSelectors():void {
        this.$shippingSelect = $('#shipping-type');
    }

    private initEvents():void {

    }

    private initPriceSelect():void {
        var $form = $('form');
        var shippingTypes:any = $form.data('shipping-types').split('|');
        var shippingRates:any = $form.data('shipping-rates').split('|');
        var shippingIds:any = $form.data('shipping-ids').split('|');
        for(var i=0; i<shippingTypes.length-1; i++) {
            var price = shippingRates[i];
            this.$shippingSelect.append('<option value="' + shippingIds[i] + '" data-price="' + price + '" >' + shippingTypes[i] + ' - $' + price +'</option>');
        }
    }

}