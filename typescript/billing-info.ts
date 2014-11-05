class BillingInfo {

    private $countrySelect:JQuery;

    constructor() {
        this.setSelectors();
        this.initEvents();
        this.setCountrySelectToUS();
    }

    private setSelectors():void {
        this.$countrySelect = $('#billing-country');
    }

    private initEvents():void {

    }

    private setCountrySelectToUS():void {
        this.$countrySelect.find("option[value='US']").attr("selected", "selected");
    }

}