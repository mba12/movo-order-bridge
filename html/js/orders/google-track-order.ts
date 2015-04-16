class GoogleTrackOrder implements Trackable {

    public track(data) {
        ga('ecommerce:addTransaction', {
            'id': data['charge-id'],                     // Transaction ID. Required
            'affiliation': 'movo',   // Affiliation or store name
            'revenue': data['order-total'],               // Grand Total
            'shipping': data['shipping-rate'],                  // Shipping
            'tax': data['tax']                     // Tax
        });
        for (var i = 0; i < data.items.length; i++) {
            var item=data.items[i];
            ga('ecommerce:addItem', {
                'id': data['charge-id'],                     // Transaction ID. Required
                'name': item.description,                // Product name. Required
                'sku': item.sku,                    // SKU/code
                'category': item.description,       // Category or variation
                'price': data['unit-price'],                 // Unit price
                'quantity': '1'                   // Quantity
            });

        }
        ga('ecommerce:send');
    }

}

declare var ga;