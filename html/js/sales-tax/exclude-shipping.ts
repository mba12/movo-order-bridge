class ExcludeShippingMethod implements SalesTaxMethod{

    calculate(quantity:number, unitPrice:number, discount:number, shippingRate:number, rate:number):number {
        return ((quantity * unitPrice) - discount) * rate;
    }

}