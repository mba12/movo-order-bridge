/// <reference path="../definitions/jquery.d.ts" />
/// <reference path="../definitions/chart.d.ts" />
/// <reference path="../definitions/greensock.d.ts" />

class Admin {

    constructor() {
        var $pickers:JQuery= $('.datetimepicker');
        $pickers.datetimepicker();
        textFit($('.number'));
        this.initCouponDoughnuts();
    }

    private initCouponDoughnuts():void {
        $('.doughnut').each((i, el)=> {
            var $item:any = $(el);
            var ctx:any = $item[0].getContext("2d");
            var used:number = parseInt($($item.parent()).find('.percent').data('used'));
            var left:number = parseInt($($item.parent()).find('.percent').data('left'));
            var data:any = [
                { value: used, color: "#f6303e", label: used + " Used" },
                { value: left, color: "#e1e1e1", label: left + " Left" }
            ];
            setTimeout(function(){
                new Chart(ctx).Doughnut(data, {
                    tooltipTemplate: "<%= label %>",
                    percentageInnerCutout: 77,
                    animationEasing: "easeInOutQuint",
                    showTooltips: false
                });
            }, 325 * i);
        });
    }
}

new Admin();

interface JQuery{
    datetimepicker():any;
}

declare var textFit;

