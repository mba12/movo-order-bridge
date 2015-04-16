interface SalesTaxMethod{
     calculate(subtotal:number, discount:number, shippingRate:number, rate:number):number;
}

interface SalesTaxCalculatable{
     new():SalesTaxMethod;
     prototype: SalesTaxMethod;
}