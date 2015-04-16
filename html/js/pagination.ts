/// <reference path="definitions/js-signals.d.ts" />

class Pagination {
    private pages:JQuery[];
    private $currentPage:JQuery;
    private currentIndex:number = 0;
    private $navLis:JQuery;
    public pageChanged:Signal = new signals.Signal();

    constructor() {
        this.setSelectors();
        this.initPages();
        this.showCurrentPage();
    }

    private setSelectors():void {
        this.$navLis = $('#nav').find("li");
    }

    private initPages():void {
        this.pages = [
            $('#products'), $('#loops'), $('#billing-info'), $('#shipping-info'), $('#payment'), $('#summary')
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
        this.pageChanged.dispatch(this.currentIndex);
    }

    public previous():void {
        this.currentIndex--;
        if (this.currentIndex < 0) {
            this.currentIndex = 0;
        }
    }

    public next():void {
        this.currentIndex++;
        if (this.currentIndex > this.pages.length - 1) {
            this.currentIndex = this.pages.length - 1
        }
    }

    public gotoProductsPage():void {
        this.currentIndex = 0;
        this.showCurrentPage();
    }

    public gotoSummaryPage():void {
        this.currentIndex = 5;
        this.showCurrentPage();
    }

    public gotoShippingPage():void {
        this.currentIndex = 3;
        this.showCurrentPage();
    }

    public gotoPage(page):void {
        this.currentIndex = page;
        this.showCurrentPage();
    }
}