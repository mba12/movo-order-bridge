class SalesTax {
    public rate:number = 0;

    public state:string = "";
    public zipcode:string = "";

    private taxMethods = [new ExcludeShippingMethod(), new IncludeShippingMethod()]

    constructor() {

    }

    public setLocation(zipcode:string, state:string, callback?:any) {
        if (zipcode == this.zipcode && state == this.state) {
            if (callback) callback({rate: this.rate});
            return;
        }
        this.zipcode = zipcode;
        this.state = state;
        $.ajax({
            type: 'GET', url: "/tax/" + zipcode + "/" + state, success: (response)=> {
                if (response.error) {
                    if (callback) callback(response);
                    return;
                }
                this.rate = response.rate;
                if (callback) callback(response);
            }, error: (response)=> {
                if (callback) callback({error: "There was an error retrieving sales tax"});
            }
        });
    }

    public total(subtotal:number, discount:number, shippingRate:number, state:string):number {
        if (!state || state == "") {
            return 0;
        }
        return this.getTaxMethod(state).calculate(subtotal, discount, shippingRate, this.rate);
    }

    private getTaxMethod(state:string):SalesTaxMethod {
        state = state.trim();
        for (var i = 0; i < TAX_TABLE.length; i++) {
            var taxObj = TAX_TABLE[i];
            if (taxObj.state.trim() == state) {
                return this.taxMethods[taxObj.method];
            }
        }

        throw new Error("state not found in list");
    }

}

declare var TAX_TABLE;