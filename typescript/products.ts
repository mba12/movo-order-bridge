class Products {

    private $products:JQuery;
    private $quantityInputField:JQuery;
    private $tooManyUnitsMsg:JQuery;
    private static MAX_UNITS:number = 8;
    constructor() {
        this.setSelectors();
        this.initEvents();
        this.initQuantityStepper();
        this.setQuantityFieldIfPassedIn();
        this.showSizeSelectsBasedOnQuantity();
        this.showHideTooManyUnitsMessage();
    }

    private setSelectors() {
        this.$products = $('.products');
        this.$quantityInputField = $('#fixed-right-module').find('input');
        this.$tooManyUnitsMsg = $('#too-many-units');
    }

    private initEvents() {
        this.$quantityInputField.on('change', ()=>this.onQuantityChange());
    }

    private setQuantityFieldIfPassedIn():void {
        var passedInQuantity:number = parseInt(this.getParameterByName('quantity'));
        if(passedInQuantity > 0) {
            this.$quantityInputField.val(passedInQuantity.toString());
        }
    }

    private onQuantityChange():void {
        this.showSizeSelectsBasedOnQuantity();
        this.showHideTooManyUnitsMessage();
    }

    private showSizeSelectsBasedOnQuantity():void {
        var $selectGroups:JQuery = this.$products.find('.select-group');
        var curQty:number = $selectGroups.length;
        var targetQty:number = Math.min(parseInt(this.$quantityInputField.val()), Products.MAX_UNITS);
        var templateHtml:string = $('#product-select-tpl').html();
        if (curQty < targetQty) {
            for (var i = curQty; i < targetQty; i++) {
                templateHtml = templateHtml.replace('X', (i+1).toString());
                this.$products.append($(templateHtml));
            }
        } else {
            for (var i = curQty; i > targetQty; i--) {
                $selectGroups.last().remove();
            }
        }
    }

    private showHideTooManyUnitsMessage():void {
        if (parseInt(this.$quantityInputField.val()) > 8) {
            this.$tooManyUnitsMsg.show();
        } else {
            this.$tooManyUnitsMsg.hide();
        }
    }

    private initQuantityStepper():void {
        this.$quantityInputField.stepper({ min: 1, max: 1000});
    }

    private getParameterByName(name):any {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"), results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

}

new Products();
