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
                imports: {
                    status: '${ $.provider }:status',
                    defaultStatus: '${ $.provider }:status',
                },
                // status: ko.observable(),
                // bio: ko.observable(''),

                tracks: {
                    status: true,
                    bio: true
                },
                links: {
                    bio: '${ $.provider }:bio'
                }
            },
            initialize: function () {
                this.customerName = ko.observableArray([]);
                this.customerData = ko.observable('');
                this._super();
            },
            addNewCustomer: function () {
                this.customerName.push({ mort: this.customerData() });
                this.customerData('');
            },
            getFBHandle: function () {
                return "Thành Dương";
            },

            getFBUrl: function () {
                return 'https://fb.com/' + this.facebook;
            },

            getButtonText: function () {
                return this.status === 'Online' ? 'Go Offline' : 'Go Online';
            },

            setStatus: function () {
                return this.status === 'Online' ? this.status= 'Offline' : this.status = 'Online';
            },
            setDefaultStatus: function () {
                // return this.status = 'zzZ';
                return this.status = this.defaultStatus;
            },
            getButtonDefaultText: function () {
                return 'Back to Default Status';
            }
        });
    }
);