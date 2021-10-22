define([
    'Magento_Ui/js/grid/listing'
], function (Collection) {
    'use strict';

    return Collection.extend({
        defaults: {
            template: 'Leeit_OrderGridColors/ui/grid/list'
        },
        getRowClass: function (row) {
            return row.state;
        }
    });
});
