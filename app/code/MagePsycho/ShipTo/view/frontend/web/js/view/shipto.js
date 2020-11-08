define([
        'uiComponent',
        'Magento_Customer/js/customer-data'
    ], function (Component, customerData) {
        'use strict';
        return Component.extend({
            initialize: function () {
                var sections = ['checkout-data'];
                customerData.invalidate(sections);
                customerData.reload(sections, true);

                this.shipto = customerData.get('shipto');
                this._super();
            }
        });
    }
);
