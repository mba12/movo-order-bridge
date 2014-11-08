/// <reference path="jquery.d.ts" />

class Admin {

    constructor() {
        this.initPusherEvents();
    }

    private initPusherEvents():void {
        var pusherKey = $('meta[name="pusher-key"]').attr('content');
        var pusher = new Pusher(pusherKey);
        var channel = pusher.subscribe("orderChannel");
        channel.bind("userStartedOrder", (data)=> {
            console.log("user started order");
        })

    }
}

new Admin();

declare var Pusher:any;
