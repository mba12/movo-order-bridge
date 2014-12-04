class TrackOrder implements Trackable {

    constructor() {

    }

    public track(data) {
        //_gaq.push(['_addTrans', data.transactionID, data.affiliation, data.total, data.tax, data.shippingCost, data.city, data.state, data.country]);
        //_gaq.push(['_addItem', data.transactionID, data.sku, data.productName, data.category, data.unitPrice, data.quantity]);
        //_gaq.push(['_trackTrans']);
    }

}

declare var _gaq;