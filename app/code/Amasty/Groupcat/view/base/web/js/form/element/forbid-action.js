/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

define([
    'underscore',
    'uiRegistry',
    'Magento_Ui/js/form/element/single-checkbox'
], function (_, uiRegistry, select) {
    'use strict';

    return select.extend({
        /**
         * Show field on actions tab
         */
        onUpdate: function () {
            if (this.visible() && uiRegistry.get(this.checkField).value() === this.showFieldOnValue) {
                uiRegistry.get(this.showField).show();
            }
        }
    });
});
