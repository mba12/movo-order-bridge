class ScreenBase {

    public $prevBtn:JQuery;
    public $nextBtn:JQuery;
    public $currentPage:JQuery;
    public ajaxCallPending:boolean = false;

    constructor(public pagination:Pagination) {
    }

    public setSelectors() {
        this.$prevBtn = $('.prev', this.$currentPage);
        this.$nextBtn = $('.next', this.$currentPage);
    }

    public initEvents() {
        this.$prevBtn.on('click', ()=>this.onPrevClick());
        this.$nextBtn.on('click', ()=>this.onNextClick());
        this.pagination.pageChanged.add((pageIndex)=>this.onPageChanged(pageIndex));
    }

    public onPrevClick():void {
        this.pagination.previous();
        this.pagination.showCurrentPage();
    }

    public onNextClick():void {
        var validation = new Validation($('[data-validate]', this.$currentPage).filter(':visible'));
        if (!validation.isValidForm()) {
            validation.showErrors();
            return;
        }
        validation.resetErrors();
        this.pagination.next();
        this.pagination.showCurrentPage();
    }

    public onPageChanged(pageIndex:number):void {

    }

}
