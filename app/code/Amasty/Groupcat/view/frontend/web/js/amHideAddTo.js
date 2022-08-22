/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

define([
    "jquery",
    "Magento_Ui/js/modal/modal"
], function ($) {
    $.widget('mage.amHideAddTo', {
        options: {},
        _create: function () {
            if (this.element) {
                var parent = this.element.parents(this.options['parent']);
                if (!parent) {
                    return;
                }
                if (this.options['hide_compare'] === '1') {
                    jQuery(parent[2]).find('a.tocompare').remove();
                }
                if (this.options['hide_wishlist'] === '1') {
                    jQuery(parent[2]).find('a.towishlist').remove();
                }
            }
        }
    });

    return $.mage.amHideAddTo;
});
