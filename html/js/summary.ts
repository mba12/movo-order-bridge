class Summary extends ScreenBase {

    private $createNewOrderBtn:JQuery;

    constructor($pagination:Pagination, public fixedRightModule:FixedRightModule) {
        super($pagination);
        this.setSelectors();
        this.initEvents();
    }

    public setSelectors() {
        super.setSelectors();
        this.$createNewOrderBtn = $('#create-new-order');
    }

    public initEvents() {
        //super.initEvents();
        this.$createNewOrderBtn.on('click', (e)=>this.onCreateNewOrderBtnClick(e));
    }

    private onCreateNewOrderBtnClick(e):void {
        e.preventDefault();
        this.fixedRightModule.resetOrder();
        this.pagination.gotoProductsPage();
    }

}