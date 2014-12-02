class SalesTax {
    public rate:number = 0;

    public state:string = "";
    public zipcode:string = "";

    constructor() {

    }
    public setLocation(zipcode:string, state:string, callback?:any) {
        if (zipcode == this.zipcode && state == this.state) {
            if (callback) callback({rate:this.rate});
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

    public total(quantity:number, unitPrice:number, discount:number, shippingRate:number, state:string):number {
        if(!state||state=="") {
            return 0;
        }
        var method:number = this.getTaxMethod(state);
        var totalTax:number;
        switch (method) {
            case 0:
                totalTax = ((quantity * unitPrice) - discount) * this.rate;
                break;
            case 1:
                totalTax = ((quantity * unitPrice) - discount + shippingRate) * this.rate;
                break;
        }
        return totalTax;
    }

    private getTaxMethod(state:string):number {
        for (var i = 0; i < TAX_TABLE.length; i++) {
            var taxObj=TAX_TABLE[i];
            if (taxObj.state.trim() == state.trim()){
                return taxObj.method;
            } 
        }

        throw new Error("state not found in list");
    }

}

declare var TAX_TABLE;