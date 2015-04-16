/// <reference path="../definitions/jquery.d.ts" />
/// <reference path="../definitions/chart.d.ts" />

class Coupons {

    constructor() {
        this.initEvents();
        this.initDatePicker();
    }

    private initEvents():void {
        $('.delete-button').find('.button').on('click', (e)=>this.onDeleteButtonClick(e));
    }

    private onDeleteButtonClick(e):void {
        if ( ! confirm("Delete Coupon?")) {
            e.preventDefault();
        }
    }

    private initDatePicker():void{
        var $pickers:JQuery = $('.datetimepicker');
        $pickers.datetimepicker();
    }

}

interface JQuery{
    datetimepicker():any;
}

new Coupons();