define([
    'Magento_Ui/js/grid/listing'
], function (Collection) {
    'use strict';

    return Collection.extend({
        defaults: {
            template: 'Magenest_Movie/ui/grid/listing'
        },
        getRowClass: function (col,row) {
            if(col.index == 'status'){
                if(row.status == 'complete') {
                    return 'complete';
                } else if(row.status == 'closed') {
                    return 'closed';
                } else if(row.status == 'processing') {
                    return 'processing';
                } else {
                    return 'pending';
                }
            }
        }
    });
});
