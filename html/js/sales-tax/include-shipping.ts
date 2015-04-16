class IncludeShippingMethod implements SalesTaxMethod{
    calculate(subtotal:number, discount:number, shippingRate:number, rate:number):number {
        return (subtotal - discount + shippingRate) * rate;
    }

}