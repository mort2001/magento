/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

define([
    'underscore',
    'uiRegistry',
    'Magento_Ui/js/form/components/fieldset'
], function (_, uiRegistry, fieldset) {
    'use strict';

    return fieldset.extend({
        defaults: {
            hideProduct: '',
            allowDirectLinks: ''
        },

        /**
         * Show or Hide fieldset
         */
        doHideShow: function () {
            if (uiRegistry.get(this.hideProduct).value() == 0
                || uiRegistry.get(this.allowDirectLinks).value() == 1
            ) {
                this.visible(true);
            } else {
                this.visible(false);
            }
        }
    });
});
