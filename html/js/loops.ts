class Loops extends ScreenBase {

    private $qty:JQuery;

    constructor($pagination:Pagination) {
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
        console.log(loopsArray);
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

}