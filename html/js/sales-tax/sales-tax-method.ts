interface SalesTaxMethod{
     calculate(quantity:number, unitPrice:number, discount:number, shippingRate:number, rate:number):number;
}

interface SalesTaxCalculatable{
     new():SalesTaxMethod;
     prototype: SalesTaxMethod;
}