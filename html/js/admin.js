var Admin = (function () {
    function Admin() {
        this.initPusherEvents();
    }
    Admin.prototype.initPusherEvents = function () {
        var pusherKey = $('meta[name="pusher-key"]').attr('content');
        var pusher = new Pusher(pusherKey);
        var channel = pusher.subscribe("orderChannel");
        channel.bind("userStartedOrder", function (data) {
            console.log("user started order");
        });
    };
    return Admin;
})();
new Admin();
//# sourceMappingURL=admin.js.map