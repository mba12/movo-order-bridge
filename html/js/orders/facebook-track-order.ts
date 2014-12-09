class FacebookTrackOrder implements Trackable {

    public track(data) {
        window['_fbq'].push(['track', '6021218673084', {'value': data['order-total'], 'currency': 'USD'}]);
    }
}
