define(['Magento_Ui/js/grid/columns/column'], function (Column) {
    'use strict';

    return Column.extend({
        defaults: {
            bodyTmpl: 'Magenest_Movie/ui/grid/cells/rating'
        }, getRowClass: function (row, index) {
            if (row.rating >= index) {
                return 'checked';
            }
        }
    });
});
