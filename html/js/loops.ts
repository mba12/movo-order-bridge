class Loops extends ScreenBase {

    constructor($pagination:Pagination) {
        super($pagination);
        this.setSelectors();
        this.initEvents();
    }

    public setSelectors() {
        this.$currentPage = $('#loops');
        super.setSelectors();
    }

    public initEvents() {
        super.initEvents();
    }



}