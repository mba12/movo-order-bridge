/// <reference path="../definitions/jquery.d.ts" />
/// <reference path="../definitions/chart.d.ts" />

class Manual {

    constructor() {
        this.initEvents();
        this.initDatePicker();
    }

    private initEvents():void {
        $('.clear-button').find('.button').on('click', (e)=>this.onClearButtonClick(e));
    }

    private onClearButtonClick(e):void {
        if ( ! confirm("Clear order?")) {
            e.preventDefault();
        }
    }

    private initDatePicker():void{
        var $pickers:JQuery = $('.datetimepicker');
        $pickers.datetimepicker();
    }

    private onSkuQtyButtonClick(e):void {
        if ( ! confirm("Clear order?")) {
            e.preventDefault();
        }
    }

}

interface JQuery{
    datetimepicker():any;
}

new Manual();