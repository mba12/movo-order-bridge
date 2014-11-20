class SalesTax{
    public rate:number=0;
    public state:string="";
    public zipcode:string="";
    constructor(){

    }

    public setLocation(zipcode:string, state:string, callback?:any){
        if(zipcode==this.zipcode && state==this.state){
            if (callback) callback({});
            return;
        }
        this.zipcode=zipcode;
        this.state=state;
        $.ajax({
            type: 'GET',
            url: "/tax/" + zipcode + "/" + state,
            success: (response)=> {

                if (response.error) {
                    return;
                }
                this.rate=response.rate;
                if (callback) callback(response);
            },
            error: (response)=> {
                if (callback) callback({error: "There was an error retrieving sales tax"});
            }
        });
    }

    public total(quantity:number,unitPrice:number,  discount:number, state?:string):number{
        var totalTax:number= (quantity * unitPrice - discount) * this.rate;
        return totalTax;
    }
}