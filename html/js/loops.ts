class Loops extends ScreenBase {

    private $qty:JQuery;

    constructor($pagination:Pagination, public fixedRightModule:FixedRightModule) {
        super($pagination);
        this.setSelectors();
        this.initEvents();
        this.initQuantitySteppers();

        var loopsArray = [];
        $('#loops').find('.loop-input').each((i, el)=> {
            var $item:JQuery = $(el);
            if ($item.val() > -1) {
                loopsArray.push({
                    sku: $item.data('sku'),
                    name: $item.data('name'),
                    quantity: $item.val()
                });
            }
        });
    }

    public setSelectors() {
        this.$currentPage = $('#loops');
        this.$qty = this.$currentPage.find('.qty').find('input');
        super.setSelectors();
    }

    public initEvents() {
        super.initEvents();
    }

    private initQuantitySteppers():void {
        this.$qty.stepper({min: 0, max: 99});
    }

    public onPrevClick():void {
        this.$currentPage.find('.no-products').hide();
        super.onPrevClick();
    }

    public onNextClick():void {

        if(Order.getInstance().getSubtotal() > 0) {
            this.pagination.next();
            this.pagination.showCurrentPage();
            this.$currentPage.find('.no-products').hide();
        } else {
            this.$currentPage.find('.no-products').show();
        }
    }

}