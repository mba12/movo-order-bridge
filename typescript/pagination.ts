class Pagination {
    private pages:JQuery[];
    private $currentPage:JQuery;
    private currentIndex:number = 0;
    private $navLis:JQuery;

    constructor() {
        this.setSelectors();
        this.initPages();
    }

    private setSelectors():void {
        this.$navLis = $('#nav').find("li");
    }

    private initPages():void {
        this.pages = [
            $('#products'), $('#billing-info'), $('#shipping-info'), $('#payment')
        ];
        this.$currentPage = this.pages[this.currentIndex];
    }

    public showCurrentPage():void {
        this.$currentPage = this.pages[this.currentIndex];
        for (var i = 0; i < this.pages.length; i++) {
            $(this.pages[i]).hide();

        }
        this.$currentPage.show();
        this.$navLis.removeClass("active");
        $(this.$navLis[this.currentIndex]).addClass("active");
    }

    public previous():void {
        this.currentIndex--;
        if (this.currentIndex < 0) {
            this.currentIndex = 0;
        }
    }

    public next():void {
        var validation = new Validation($('[data-validate]', this.$currentPage));
        if (!validation.isValidForm()) {
            validation.showErrors();
            return;
        }

        this.currentIndex++;
        if (this.currentIndex > this.pages.length - 1) {
            this.currentIndex = this.pages.length - 1
        }
    }

}