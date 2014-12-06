/// <reference path="../definitions/jquery.d.ts" />
/// <reference path="../definitions/chart.d.ts" />

class Stats {

    private $lastHour:JQuery;
    private $lastDay:JQuery;
    private $lastWeek:JQuery;
    private $lastMonth:JQuery;
    private $errors:JQuery;
    private $coupons:JQuery;
    private $couponLis:JQuery;
    constructor() {
        this.setSelectors();
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
        });
    }

    private setSelectors():void{
        this.$lastHour=$('.hour').find('.textFitted');
        this.$lastDay=$('.day').find('.textFitted');
        this.$lastWeek=$('.week').find('.textFitted');
        this.$lastMonth=$('.month').find('.textFitted');
        this.$errors=$('.errors').find('.textFitted');
        this.$coupons=$("#coupons");
        this.$couponLis=$("#coupons").find("li");
    }
    private reloadStats():void {
        $.ajax({
            type: 'POST',
            url: "/admin/stats",
            success: (response)=> {
               this.onStatsLoaded(response);
                console.log(response);
            }
        });
    }

    private onStatsLoaded(response):void{
        this.updateOrderStats(response);
        this.updateCouponStats(response);
    }

    private updateOrderStats(response):void{
        $('.hour').find('.textFitted').html(response.lastHour);
        $('.day').find('.textFitted').html(response.lastDay);
        $('.week').find('.textFitted').html(response.lastWeek);
        $('.month').find('.textFitted').html(response.lastMonth);
        $('.errors').find('.textFitted').html(response.errors);
    }

    private updateCouponStats(response):void{
        for (var i = 0; i < response.coupons.length; i++) {
            var $li = $(this.$couponLis[i]);
            $li.find(".percent").attr('data-used', response.couponCounts[i]);
            $li.find(".percent").attr("data-left", response.coupons[i].limit-response.couponCounts[i]);
            $li.find(".used").html(response.couponCounts[i]);
            if(response.coupons[i].limit>0){
                $li.find(".detail").html(response.couponCounts[i]+" of "+response.coupons[i].limit+" used")
                this.initCouponDoughnuts();
            }
        }
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

