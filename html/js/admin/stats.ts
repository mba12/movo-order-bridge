/// <reference path="../definitions/jquery.d.ts" />
/// <reference path="../definitions/chart.d.ts" />

class Stats {

    private $lastHour:JQuery;
    private $lastDay:JQuery;
    private $lastWeek:JQuery;
    private $lastMonth:JQuery;
    private $errors:JQuery;
    private $coupons:JQuery;
    private $couponsUl:JQuery;
    private $couponLis:JQuery;

    constructor() {
        this.setSelectors();
        //this.initPusherEvents();
        this.initStatsRefresh();
        this.initTextFit();
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

    private initStatsRefresh():void {
        setInterval(()=> {
            this.reloadStats();
        }, 60000);
    }

    private setSelectors():void {
        this.$lastHour = $('.hour').find('.textFitted');
        this.$lastDay = $('.day').find('.textFitted');
        this.$lastWeek = $('.week').find('.textFitted');
        this.$lastMonth = $('.month').find('.textFitted');
        this.$errors = $('.errors').find('.textFitted');
        this.$coupons = $("#coupons");
        this.$couponsUl = $("#coupons").find('ul');
        this.$couponLis = this.$couponsUl.find("li");
    }

    private reloadStats():void {
        $.ajax({
            type: 'POST', url: "/admin/stats", success: (response)=> {
                this.onStatsLoaded(response);
            }
        });
    }

    private onStatsLoaded(response):void {
        this.updateOrderStats(response);
        this.drawCouponLis(response);
        this.updateCouponStats(response);
        this.removeUnusedCouponLis(response);
        this.initTextFit();
    }

    private updateOrderStats(response):void {
        $('.hour').find('.textFitted').html(response.lastHour);
        $('.day').find('.textFitted').html(response.lastDay);
        $('.week').find('.textFitted').html(response.lastWeek);
        $('.month').find('.textFitted').html(response.lastMonth);
        $('.errors').find('.textFitted').html(response.errors);
    }

    private drawCouponLis(response):void {
        var $lis:JQuery = this.$couponsUl.find('li');

        for (var i = 0; i < response.coupons.length; i++) {
            var $li:JQuery;
            if (response.coupons[i].limit > 0) {
                $li = $($('#coupon-limited-tpl').html());
            } else {
                $li = $($('#coupon-unlimited-tpl').html());
            }
            if ($lis[i]) {
                if ($($lis[i]).find('.coupon').html() != response.coupons[i].code) {
                    $(this.$couponLis[i]).html($li.html());
                }
            } else {
                this.$couponsUl.append($li);
            }
        }
    }

    private updateCouponStats(response):void {
        var $lis:JQuery = this.$couponsUl.find('li');
        for (var i = 0; i < response.coupons.length; i++) {
            var $li:JQuery = $($lis[i]);

            if (this.couponIsUnchanged($li, response, i)) continue;

            $li.find(".coupon").html(response.coupons[i].code);
            if (response.coupons[i].limit > 0) {
                $li.find(".percent").attr('data-used', response.couponCounts[i]);
                $li.find(".percent").attr("data-left", response.coupons[i].limit - response.couponCounts[i]);
                $li.find(".detail").html(response.couponCounts[i] + " of " + response.coupons[i].limit + " used");
                $li.find(".used").html(((response.couponCounts[i] / response.coupons[i].limit) * 100).toFixed(0));
            } else {
                $li.find(".detail").html("no limit");
                $li.find(".percent").attr('data-used', 0);
                $li.find(".percent").attr("data-left", 1);
                $li.find(".percent").html(response.couponCounts[i]);
            }
            this.initCouponDoughnuts($li,response, i)

        }
        //this.initCouponDoughnuts();
    }

    private couponIsUnchanged($li:JQuery, response, i:number):boolean {
        var numberIsUnchanged:boolean;
        if (response.coupons[i].limit > 0) {
            numberIsUnchanged = $li.find(".percent").attr('data-used') == response.couponCounts[i]
        } else {
            numberIsUnchanged = $li.find(".percent").find("span").html() == response.couponCounts[i]
        }
        return $li.find(".coupon").html() == response.coupons[i].code && numberIsUnchanged;
    }

    private removeUnusedCouponLis(response):void {
        var $lis:JQuery = this.$couponsUl.find('li');
        for (var i = 0; i < $lis.length; i++) {
            if (!response.coupons[i]) {
                $($lis[i]).remove();
            }
        }
    }


    private initTextFit():void {
        textFit($('.number, .no-limit'));
    }

    private initCouponDoughnuts($item:any, response:any,index:number):void {

        $item.find(".doughnut").remove();
        $item.find(".circle").append('<canvas class="doughnut" width="140" height="140"></canvas>');
        var ctx:any = (<any>$($item.find(".doughnut"))[0]).getContext("2d");
        var used:number;
        var left:number;
        if (response.coupons[index].limit > 0) {
             used = response.couponCounts[index];
             left = response.coupons[index].limit-response.couponCounts[index];
        } else {
             used = 0;
             left = 1;
        }

        setTimeout(function () {

            var data:any = [{value: used, color: "#f6303e", label: used + " Used"}, {
                value: left, color: "#e1e1e1", label: left + " Left"
            }];
            new Chart(ctx).Doughnut(data, {
                tooltipTemplate: "<%= label %>",
                percentageInnerCutout: 77,
                animationEasing: "easeInOutQuint",
                showTooltips: false
            });
        }, 310 * index);

    }
}

new Stats();

declare var Pusher:any;
declare var textFit;