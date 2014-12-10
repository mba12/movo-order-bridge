class Products extends ScreenBase {

    private $products:JQuery;
    private $quantityInputField:JQuery;
    private $tooManyUnitsMsg:JQuery;

    constructor($pagination:Pagination) {
        super($pagination);
        this.setSelectors();
        this.initEvents();
        this.showSizeSelectsBasedOnQuantity();
        this.showHideTooManyUnitsMessage();
    }

    public setSelectors() {
        this.$products = $('.products');
        this.$quantityInputField = $('#fixed-right-module').find('input');
        this.$tooManyUnitsMsg = $('#too-many-units');
        this.$currentPage = $('#products');
        super.setSelectors();
    }

    public initEvents() {
        this.$quantityInputField.on('change blur', ()=>this.onQuantityChange());
        super.initEvents();
    }

    private onQuantityChange():void {
        this.showSizeSelectsBasedOnQuantity();
        this.showHideTooManyUnitsMessage();
    }

    private showSizeSelectsBasedOnQuantity():void {
        var $selectGroups:JQuery = this.$products.find('.select-group');
        var curQty:number = $selectGroups.length;
        var targetQty:number = Math.min(parseInt(this.$quantityInputField.val()), FixedRightModule.MAX_UNITS);
        var templateHtml:string = $('#product-select-tpl').html();
        if (curQty < targetQty) {
            for (var i = curQty; i < targetQty; i++) {
                templateHtml=templateHtml.replace(/#unitID/g, "unit"+(i+1).toString());
                templateHtml=templateHtml.replace(/#unitNum/g, (i+1).toString());
                this.$products.append($(templateHtml));
            }
        } else {
            for (var i = curQty; i > targetQty; i--) {
                $selectGroups.last().remove();
            }
        }
    }

    private showHideTooManyUnitsMessage():void {
        if (parseInt(this.$quantityInputField.val()) >= FixedRightModule.MAX_UNITS) {
            this.$quantityInputField.val(FixedRightModule.MAX_UNITS.toString());
            this.$tooManyUnitsMsg.show();
        } else {
            this.$tooManyUnitsMsg.hide();
        }
    }

    private disableQuantityStepper():void {
        $('#fixed-right-module').find('.stepper').addClass('disabled');
        $('#fixed-right-module').find('input').attr('disabled');
    }

    private enableQuantityStepper():void {
        $('#fixed-right-module').find('.stepper').removeClass('disabled');
        $('#fixed-right-module').find('input').removeProp('disabled');
    }

    public onPageChanged(pageIndex:number):void {
        if(pageIndex == 0) {
            this.enableQuantityStepper();
        } else {
            this.disableQuantityStepper();
        }
    }

}
