/// <reference path="definitions/jquery.d.ts" />

class Stats {

    constructor() {
        this.initPusherEvents();
        console.log("logging...");
        this.reloadStats();
    }

    private initPusherEvents():void {
        var pusherKey = $('meta[name="pusher-key"]').attr('content');
        var pusher = new Pusher(pusherKey);
        var channel = pusher.subscribe("orderChannel");
        channel.bind("completedOrder", (data)=> {
            this.reloadStats();
            console.log("order completed");
        })

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
}

new Stats();

declare var Pusher:any;
