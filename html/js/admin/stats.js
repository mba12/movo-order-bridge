var Stats = (function () {
    function Stats() {
        this.setSelectors();
        this.initPusherEvents();
        this.initTextFit();
        this.initCouponDoughnuts();
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
    Stats.prototype.setSelectors = function () {
        this.$lastHour = $('.hour').find('.textFitted');
        this.$lastDay = $('.day').find('.textFitted');
        this.$lastWeek = $('.week').find('.textFitted');
        this.$lastMonth = $('.month').find('.textFitted');
        this.$errors = $('.errors').find('.textFitted');
        this.$coupons = $("#coupons");
        this.$couponLis = $("#coupons").find("li");
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
        this.updateCouponStats(response);
    };
    Stats.prototype.updateOrderStats = function (response) {
        $('.hour').find('.textFitted').html(response.lastHour);
        $('.day').find('.textFitted').html(response.lastDay);
        $('.week').find('.textFitted').html(response.lastWeek);
        $('.month').find('.textFitted').html(response.lastMonth);
        $('.errors').find('.textFitted').html(response.errors);
    };
    Stats.prototype.updateCouponStats = function (response) {
        for (var i = 0; i < response.coupons.length; i++) {
            var $li = $(this.$couponLis[i]);
            $li.find(".percent").attr('data-used', response.couponCounts[i]);
            $li.find(".percent").attr("data-left", response.coupons[i].limit - response.couponCounts[i]);
            $li.find(".used").html(response.couponCounts[i]);
            if (response.coupons[i].limit > 0) {
                $li.find(".detail").html(response.couponCounts[i] + " of " + response.coupons[i].limit + " used");
                this.initCouponDoughnuts();
            }
        }
    };
    Stats.prototype.initTextFit = function () {
        textFit($('.number, .no-limit'));
    };
    Stats.prototype.initCouponDoughnuts = function () {
        $('.doughnut').each(function (i, el) {
            var $item = $(el);
            var ctx = $item[0].getContext("2d");
            var used = parseInt($($item.parent()).find('.percent').data('used'));
            var left = parseInt($($item.parent()).find('.percent').data('left'));
            var data = [{ value: used, color: "#f6303e", label: used + " Used" }, {
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
    };
    return Stats;
})();
new Stats();
//# sourceMappingURL=stats.js.map