/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

define([
    'ko',
    'mage/url',
    'uiComponent',
    'mage/storage'
], function(ko, urlBuilder, Component, storage) {
    'use strict'
    var id = 1;

    return Component.extend({
        defaults: {
            template: 'Tigren_Kojs/product-test'
        },
        listProducts: ko.observableArray([]),
        getProductData: function() {
            var self = this;
            var url = urlBuilder.build('kojs/test/products?id=' + id);
            id++;

            return storage.post(url, '').done(function(response){
                self.listProducts.push(JSON.parse(response));
            }).fail(function(response){
                alert("Add failed!!!");
            })

        }
    })
})