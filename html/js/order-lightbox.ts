/// <reference path="jquery.d.ts" />
class OrderLightbox {

    private $orderLightbox:JQuery;

    constructor() {
        this.setSelectors();
        this.initEvents();
    }

    private setSelectors():void {
    }

    private initEvents():void {
        $('a[href="https://orders.getmovo.com"]').on('click', (e)=>this.onBuyNowClick(e));
        $(document).on('keyup', (e)=>this.onKeyPress(e));
    }
    
    private onKeyPress(e):void {
        if (e.which == 27) {
            this.fadeOutLightbox();
        }
        console.log('keyup from ligthbox');
        /*$(document).bind('keypress', (event)=> {
            if (event.which === 126) {
                this.onBuyNowClick();
            }
        });*/

    }

    private onBuyNowClick(e):void {
        try {
            e.preventDefault();
        } catch(e) {

        }

        this.apendLightboxMarkup();
    }

    private apendLightboxMarkup():void {
        $('#order-lightbox').remove();
        $('body')
            .append('<div id="order-lightbox"><iframe src="https://orders.getmovo.com"></iframe></div>')
            .addClass('order-lightbox-open');
        this.$orderLightbox = $('#order-lightbox').fadeIn();
    }

    private fadeOutLightbox():void {
        this.$orderLightbox.fadeOut(300, ()=> {
            this.$orderLightbox.remove();
            $('body').removeClass('order-lightbox-open');
        });
    }
    
    

}

new OrderLightbox();
