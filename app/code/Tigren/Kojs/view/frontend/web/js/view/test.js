/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

define([
    'jquery', 'uiComponent', 'ko'
    ],
    function ($, Component, ko) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Tigren_Kojs/knockout-test',
            },
            initialize: function () {
                this.customerName = ko.observableArray([]);
                this.customerData = ko.observable('');
                this._super();
            },
            addNewCustomer: function () {
                // if(this.customerData == null || this.customerData.length === 0 || this.customerData === ''){
                //     alert('Invalid input!!!');
                // }
                this.customerName.push({mort:this.customerData()});
                this.customerData('');
            }
        });
    }
);