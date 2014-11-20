/// <reference path="definitions/jquery.d.ts" />
class OrderLightbox {

    private $orderLightbox:JQuery;
    private $body:JQuery;

    constructor() {
        this.setSelectors();
        this.loadLightbox();
        this.initEvents();
    }

    private setSelectors():void {
        this.$body = $('body');
    }

    private initEvents():void {
        $('a[href="https://orders.getmovo.com"]').on('click', (e)=>this.onBuyNowClick(e));
        $(document).on('keyup', (e)=>this.onKeyPress(e));

        // used for cross-domain call from orders.getmovo.com iframe
        if (window.addEventListener) {
            addEventListener("message", (e)=>this.messageListener(e), false);
        } else {
            attachEvent("onmessage", (e)=>this.messageListener(e));
        }
    }

    private messageListener(event) {
        if (event.origin !== "https://orders.getmovo.com")
        return;
        if(event.data == 'close-order-lightbox') {
            this.hideLightbox();
        }
    }

    private loadLightbox():void {
        this.$body.append('<iframe src="https://orders.getmovo.com" id="order-lightbox"></iframe>');
        this.$orderLightbox = $('#order-lightbox');
    }

    private onKeyPress(e):void {
        if (e.which == 27) {
            this.hideLightbox();
        }
    }

    private onBuyNowClick(e):void {
        e.preventDefault();
        this.showLightbox();
    }

    private showLightbox():void {
        this.$body.addClass('order-lightbox-open');
        this.$orderLightbox = this.$orderLightbox.fadeIn();
    }

    private hideLightbox():void {
        this.$orderLightbox.fadeOut(300, ()=> {
            this.$body.removeClass('order-lightbox-open');
        });
    }

}

new OrderLightbox();
