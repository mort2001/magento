/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

/**
 * Amasty Groupcat Sample Product Element
 */
define([
    'uiElement'
], function (Element) {
    'use strict';

    return Element.extend({
        defaults: {
            hidePrice: 0,
            hideCart: 0,
            hideWishlist: 0,
            hideCompare: 0
        },

        initObservable: function () {
            this._super().observe([
                'hidePrice',
                'hideCart',
                'hideWishlist',
                'hideCompare'
            ]);

            return this;
        }
    });
});
