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
], function (ko, urlBuilder, Component, storage) {
    'use strict';
    var id = 1;

    return Component.extend({
        defaults: {
            // template: 'Tigren_Kojs/product-test',
            firstName: 'Mort',
            role: 'Back-End Dev',
            location: 'VN',
            twitter: 'mort',
            status: ko.observable('OnOff'),
            bio: ko.observable(''),
            exports: {
                firstName: '${ $.provider }:firstName',
                role: '${ $.provider }:role',
                location: '${ $.provider }:location',
                twitter: '${ $.provider }:twitter'
            },
            listens: {
                '${ $.provider }:status': 'statusChanged',
                '${ $.provider }:bio': 'bioChanged'
            }
        },
        listProducts: ko.observableArray([]),
        getProductData: function () {
            var self = this;
            var url = urlBuilder.build('kojs/test/products?id=' + id);
            id++;

            return storage.post(url, '').done(function (response) {
                self.listProducts.push(JSON.parse(response));
            }).fail(function () {
                alert('Add failed!!!');
            });

        },
        statusChanged: function (newValue) {
            console.log('status changed to:', newValue);
        },

        bioChanged: function (newValue) {
            console.log('bio changed to:', newValue);
        },
        // oldBio: function () {
        //     console.log('Old bio changed to: ' + this.bio);
        // }
    });
});