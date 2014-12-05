/// <reference path="../definitions/jquery.d.ts" />
/// <reference path="../definitions/chart.d.ts" />
var Stats = (function () {
    function Stats() {
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
            console.log("order completed");
        });
    };
    Stats.prototype.reloadStats = function () {
        $.ajax({
            type: 'POST',
            url: "/admin/stats",
            success: function (response) {
                console.log(response.orderCount);
                $('.order-count').find('.count').html(response.orderCount);
                $('.error-count').find('.count').html(response.errorCount);
            }
        });
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