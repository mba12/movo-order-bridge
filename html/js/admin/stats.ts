/// <reference path="../definitions/jquery.d.ts" />
/// <reference path="../definitions/chart.d.ts" />

class Stats {

    constructor() {
        this.initPusherEvents();
        this.initTextFit();
        this.initCouponDoughnuts();
        this.reloadStats();
    }

    private initPusherEvents():void {
        var pusherKey = $('meta[name="pusher-key"]').attr('content');
        var pusher = new Pusher(pusherKey);
        var channel = pusher.subscribe("orderChannel");
        channel.bind("completedOrder", (data)=> {
            this.reloadStats();
            console.log("order completed");
        });
    }

    private reloadStats():void {
        $.ajax({
            type: 'POST',
            url: "/admin/stats",
            success: (response)=> {
                console.log(response.orderCount);
                $('.order-count').find('.count').html(response.orderCount);
                $('.error-count').find('.count').html(response.errorCount);
            }
        });
    }

    private initTextFit():void {
        textFit($('.number, .no-limit'));
    }

    private initCouponDoughnuts():void {
        $('.doughnut').each((i, el)=> {
            var $item:any = $(el);
            var ctx:any = $item[0].getContext("2d");
            var used:number = parseInt($($item.parent()).find('.percent').data('used'));
            var left:number = parseInt($($item.parent()).find('.percent').data('left'));
            var data:any = [{value: used, color: "#f6303e", label: used + " Used"}, {
                value: left,
                color: "#e1e1e1",
                label: left + " Left"
            }];
            setTimeout(function () {
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

new Stats();

declare var Pusher:any;
declare var textFit;

