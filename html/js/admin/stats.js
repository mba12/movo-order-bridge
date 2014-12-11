/// <reference path="../definitions/jquery.d.ts" />
/// <reference path="../definitions/chart.d.ts" />
var Stats = (function () {
    function Stats() {
        this.setSelectors();
        //this.initPusherEvents();
        this.initStatsRefresh();
        this.initTextFit();
        this.reloadStats();
    }
    Stats.prototype.initPusherEvents = function () {
        var _this = this;
        var pusherKey = $('meta[name="pusher-key"]').attr('content');
        var pusher = new Pusher(pusherKey);
        var channel = pusher.subscribe("orderChannel");
        channel.bind("completedOrder", function (data) {
            _this.reloadStats();
        });
    };
    Stats.prototype.initStatsRefresh = function () {
        var _this = this;
        setInterval(function () {
            _this.reloadStats();
        }, 60000);
    };
    Stats.prototype.setSelectors = function () {
        this.$lastHour = $('.hour').find('.textFitted');
        this.$lastDay = $('.day').find('.textFitted');
        this.$lastWeek = $('.week').find('.textFitted');
        this.$lastMonth = $('.month').find('.textFitted');
        this.$errors = $('.errors').find('.textFitted');
        this.$coupons = $("#coupons");
        this.$couponsUl = $("#coupons").find('ul');
        this.$couponLis = this.$couponsUl.find("li");
    };
    Stats.prototype.reloadStats = function () {
        var _this = this;
        $.ajax({
            type: 'POST',
            url: "/admin/stats",
            success: function (response) {
                _this.onStatsLoaded(response);
            }
        });
    };
    Stats.prototype.onStatsLoaded = function (response) {
        this.updateOrderStats(response);
        this.drawCouponLis(response);
        this.updateCouponStats(response);
        this.removeUnusedCouponLis(response);
        this.initTextFit();
    };
    Stats.prototype.updateOrderStats = function (response) {
        $('.hour').find('.textFitted').html(response.lastHour);
        $('.day').find('.textFitted').html(response.lastDay);
        $('.week').find('.textFitted').html(response.lastWeek);
        $('.month').find('.textFitted').html(response.lastMonth);
        $('.errors').find('.textFitted').html(response.errors);
    };
    Stats.prototype.drawCouponLis = function (response) {
        var $lis = this.$couponsUl.find('li');
        for (var i = 0; i < response.coupons.length; i++) {
            var $li;
            if (response.coupons[i].limit > 0) {
                $li = $($('#coupon-limited-tpl').html());
            }
            else {
                $li = $($('#coupon-unlimited-tpl').html());
            }
            if ($lis[i]) {
                if ($($lis[i]).find('.coupon').html() != response.coupons[i].code) {
                    $(this.$couponLis[i]).html($li.html());
                }
            }
            else {
                this.$couponsUl.append($li);
            }
        }
    };
    Stats.prototype.updateCouponStats = function (response) {
        var $lis = this.$couponsUl.find('li');
        for (var i = 0; i < response.coupons.length; i++) {
            var $li = $($lis[i]);
            if (this.couponIsUnchanged($li, response, i))
                continue;
            $li.find(".coupon").html(response.coupons[i].code);
            if (response.coupons[i].limit > 0) {
                $li.find(".percent").attr('data-used', response.couponCounts[i]);
                $li.find(".percent").attr("data-left", response.coupons[i].limit - response.couponCounts[i]);
                $li.find(".detail").html(response.couponCounts[i] + " of " + response.coupons[i].limit + " used");
                $li.find(".used").html(((response.couponCounts[i] / response.coupons[i].limit) * 100).toFixed(0));
            }
            else {
                $li.find(".detail").html("no limit");
                $li.find(".percent").attr('data-used', 0);
                $li.find(".percent").attr("data-left", 1);
                $li.find(".percent").html(response.couponCounts[i]);
            }
            this.initCouponDoughnuts($li, response, i);
        }
        //this.initCouponDoughnuts();
    };
    Stats.prototype.couponIsUnchanged = function ($li, response, i) {
        var numberIsUnchanged;
        if (response.coupons[i].limit > 0) {
            numberIsUnchanged = $li.find(".percent").attr('data-used') == response.couponCounts[i];
        }
        else {
            numberIsUnchanged = $li.find(".percent").find("span").html() == response.couponCounts[i];
        }
        return $li.find(".coupon").html() == response.coupons[i].code && numberIsUnchanged;
    };
    Stats.prototype.removeUnusedCouponLis = function (response) {
        var $lis = this.$couponsUl.find('li');
        for (var i = 0; i < $lis.length; i++) {
            if (!response.coupons[i]) {
                $($lis[i]).remove();
            }
        }
    };
    Stats.prototype.initTextFit = function () {
        textFit($('.number, .no-limit'));
    };
    Stats.prototype.initCouponDoughnuts = function ($item, response, index) {
        $item.find(".doughnut").remove();
        $item.find(".circle").append('<canvas class="doughnut" width="140" height="140"></canvas>');
        var ctx = $($item.find(".doughnut"))[0].getContext("2d");
        var used;
        var left;
        if (response.coupons[index].limit > 0) {
            used = response.couponCounts[index];
            left = response.coupons[index].limit - response.couponCounts[index];
        }
        else {
            used = 0;
            left = 1;
        }
        setTimeout(function () {
            var data = [{ value: used, color: "#f6303e", label: used + " Used" }, {
                value: left,
                color: "#e1e1e1",
                label: left + " Left"
            }];
            new Chart(ctx).Doughnut(data, {
                tooltipTemplate: "<%= label %>",
                percentageInnerCutout: 77,
                animationEasing: "easeInOutQuint",
                showTooltips: false
            });
        }, 310 * index);
    };
    return Stats;
})();
new Stats();
//# sourceMappingURL=stats.js.map