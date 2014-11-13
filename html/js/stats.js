var Stats = (function () {
    function Stats() {
        this.initPusherEvents();
        console.log("logging...");
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
                $('.order-count').html(response.orderCount);
            }
        });
    };
    return Stats;
})();
new Stats();
//# sourceMappingURL=stats.js.map