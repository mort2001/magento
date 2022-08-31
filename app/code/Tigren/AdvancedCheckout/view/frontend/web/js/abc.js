/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

define([
    'jquery',
    'mage/translate',
    'underscore',
    'Tigren_AdvancedCheckout/js/model/url-builder',
    'mage/storage',
    'Magento_Customer/js/customer-data',
    'Magento_Catalog/js/product/view/product-ids-resolver',
    'Magento_Catalog/js/product/view/product-info-resolver',
    'jquery-ui-modules/widget'
], function ($, $t, _, urlBuilder, storage, customerData, idsResolver, productInfoResolver) {
    'use strict';

    $.widget('mage.catalogAddToCart', {
        options: {
            processStart: null,
            processStop: null,
            bindSubmit: true,
            minicartSelector: '[data-block="minicart"]',
            messagesSelector: '[data-placeholder="messages"]',
            productStatusSelector: '.stock.available',
            addToCartButtonSelector: '.action.tocart',
            addToCartButtonDisabledClass: 'disabled',
            addToCartButtonTextWhileAdding: '',
            addToCartButtonTextAdded: '',
            addToCartButtonTextDefault: '',
            productInfoResolver: productInfoResolver
        },
        /** @inheritdoc */
        _create: function () {
            if (this.options.bindSubmit) {
                this._bindSubmit();
            }
            $(this.options.addToCartButtonSelector).prop('disabled', false);
        },

        /**
         * @private
         */
        _bindSubmit: function () {
            var self = this;

            if (this.element.data('catalog-addtocart-initialized')) {
                return;
            }

            this.element.data('catalog-addtocart-initialized', 1);
            this.element.on('submit', function (e) {
                e.preventDefault();
                self.submitForm($(this));
            });
        },

        /**
         * @private
         */
        _redirect: function (url) {
            var urlParts;
            var locationParts;
            var forceReload;

            urlParts = url.split('#');
            locationParts = window.location.href.split('#');
            forceReload = urlParts[0] === locationParts[0];

            window.location.assign(url);

            if (forceReload) {
                window.location.reload();
            }
        },

        /**
         * @return {Boolean}
         */
        isLoaderEnabled: function () {
            return this.options.processStart && this.options.processStop;
        },

        /**
         * Handler for the form 'submit' event
         *
         * @param {jQuery} form
         */
        submitForm: function (form) {
            this.ajaxSubmit(form);
        },

        /**
         * @param {jQuery} form
         */
        ajaxSubmit: function (form) {
            var self = this;
            var productIds = idsResolver(form);
            var productInfo = self.options.productInfoResolver(form);
            var formData;

            $(self.options.minicartSelector).trigger('contentLoading');
            self.disableAddToCartButton(form);
            formData = new FormData(form[0]);
            $.ajax({
                url: form.prop('action'),
                data: formData,
                type: 'post',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,

                /** @inheritdoc */
                beforeSend: function () {
                    if (self.isLoaderEnabled()) {
                        $('body').trigger(self.options.processStart);
                    }
                },

                /** @inheritdoc */
                success: function (res) {
                    var eventData;
                    var parameters;
                    console.log(res);
                    $(document).trigger('ajax:addToCart', {
                        'sku': form.data().productSku,
                        'productIds': productIds,
                        'productInfo': productInfo,
                        'form': form,
                        'response': res
                    });

                    if (self.isLoaderEnabled()) {
                        $('body').trigger(self.options.processStop);
                    }

                    if (res.backUrl) {
                        eventData = {
                            'form': form,
                            'redirectParameters': []
                        };
                        // trigger global event, so other modules will be able add parameters to redirect url
                        $('body').trigger('catalogCategoryAddToCartRedirect', eventData);

                        if (eventData.redirectParameters.length > 0 &&
                            window.location.href.split(/[?#]/)[0] === res.backUrl
                        ) {
                            parameters = res.backUrl.split('#');
                            parameters.push(eventData.redirectParameters.join('&'));
                            res.backUrl = parameters.join('#');
                        }

                        self._redirect(res.backUrl);

                        return;
                    }

                    if (res.messages) {
                        $(self.options.messagesSelector).html(res.messages);
                    }

                    if (res.minicart) {
                        $(self.options.minicartSelector).replaceWith(res.minicart);
                        $(self.options.minicartSelector).trigger('contentUpdated');
                    }

                    if (res.product && res.product.statusText) {
                        $(self.options.productStatusSelector).removeClass('available').addClass('unavailable').find('span').html(res.product.statusText);
                    }
                    var productSku = form.data().productSku;
                    self.enableAddToCartButton(productSku, form);

                },

                /** @inheritdoc */
                error: function (res) {
                    $(document).trigger('ajax:addToCart:error', {
                        'sku': form.data().productSku,
                        'productIds': productIds,
                        'productInfo': productInfo,
                        'form': form,
                        'response': res
                    });
                },

                /** @inheritdoc */
                complete: function (res) {
                    if (res.state() === 'rejected') {
                        location.reload();
                    }
                }
            });
        },

        /**
         * @param {String} form
         */
        disableAddToCartButton: function (form) {
            var addToCartButtonTextWhileAdding = this.options.addToCartButtonTextWhileAdding || $t('Adding...');
            var addToCartButton = $(form).find(this.options.addToCartButtonSelector);

            addToCartButton.addClass(this.options.addToCartButtonDisabledClass);
            addToCartButton.find('span').text(addToCartButtonTextWhileAdding);
            addToCartButton.prop('title', addToCartButtonTextWhileAdding);
        },

        /**
         * @param productSku
         * @param {String} form
         */
        enableAddToCartButton: function (productSku, form) {
            self = this;
            $.ajax({
                url: '/tigren_advanced/show/index',
                type: 'post',
                data: {
                    productSku: productSku
                },
                dataType: 'json',
                beforeSend: function (data) {
                    console.log(data);
                    $('body').trigger('processStart');
                },
                success: function (data) {
                    if (data.isShowPopup === true) {
                        $('body').trigger('processStop');
                        var popup = $('<div class="add-to-cart-modal-popup"/>').html('<span> You has been added to cart by allow multi orders.</span>').modal({
                            modalClass: 'add-to-cart-popup',
                            title: $.mage.__('Notification'),
                            buttons: [
                                {
                                    text: 'Clear Cart',
                                    click: function (status) {
                                        status = {status: true};
                                        storage.post(
                                            urlBuilder.createUrl('/tigren/advanced/deleteCart', {}),
                                            JSON.stringify(status),
                                            false).done(function (data) {
                                                if (data === 'success') {
                                                    $('body').trigger('processStop');
                                                    $('.counter').addClass('empty');
                                                    $('.subtitle').addClass('empty');

                                                }
                                            }
                                        );
                                        this.closeModal();
                                    }
                                },
                                {
                                    text: 'Proceed to Checkout',
                                    click: function () {
                                        window.location = window.checkout.checkoutUrl;
                                    }
                                }
                            ]
                        });
                    } else {
                        $('body').trigger('processStop');
                    }
                    if (data.success === true) {
                        $('body').trigger('processStop');
                    }
                    popup.modal('openModal');
                }
            });
            var addToCartButtonTextAdded = this.options.addToCartButtonTextAdded || $t('Added');
            var addToCartButton = $(form).find(this.options.addToCartButtonSelector);
            addToCartButton.find('span').text(addToCartButtonTextAdded);
            addToCartButton.prop('title', addToCartButtonTextAdded);
            setTimeout(function () {
                var addToCartButtonTextDefault = self.options.addToCartButtonTextDefault || $t('Add to Cart');
                addToCartButton.removeClass(self.options.addToCartButtonDisabledClass);
                addToCartButton.find('span').text(addToCartButtonTextDefault);
                addToCartButton.prop('title', addToCartButtonTextDefault);
            }, 1000);
            var sections = ['cart'];
            setInterval(function () {
                customerData.invalidate(sections);
                customerData.reload(sections, true);
            }, 2000);
        }
    });

    return $.mage.catalogAddToCart;
});