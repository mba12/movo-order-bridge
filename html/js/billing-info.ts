class BillingInfo extends ScreenBase {

    private $countrySelect:JQuery;
    private $stateSelect:JQuery;
    private $stateInput:JQuery;

    constructor($pagination:Pagination) {
        super($pagination);
        this.setSelectors();
        this.initEvents();
        this.setCountryToUnitedStates();
        this.showStateSelectOrInput();
    }

    public setSelectors() {
        this.$countrySelect = $('#billing-country');
        this.$stateSelect = $('#billing-state-select');
        this.$stateInput = $('#billing-state-input');
        this.$currentPage = $('#billing-info');
        super.setSelectors();
    }

    public initEvents() {
        this.$countrySelect.on('change', ()=>this.onCountryChange());
        super.initEvents();
    }

    private setCountryToUnitedStates():void {
        this.$countrySelect.find("option[value='US']").attr("selected", "selected");
    }

    private onCountryChange():void {
        this.showStateSelectOrInput();
    }

    private showStateSelectOrInput():void {
        if (this.$countrySelect.val() == 'US') {
            this.showStateSelect();
        } else {
            this.showStateInput();
        }
    }

    private showStateSelect():void {
        this.$stateSelect.parent().show();
        this.$stateInput.parent().hide();
    }

    private showStateInput():void {
        this.$stateInput.parent().show();
        this.$stateSelect.parent().hide();
    }

}