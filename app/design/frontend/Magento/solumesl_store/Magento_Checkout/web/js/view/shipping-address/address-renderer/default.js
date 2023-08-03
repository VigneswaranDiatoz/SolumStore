/**
 * Copyright Â© Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

 define([
    'jquery',
    'ko',
    'mage/url',
    'uiComponent',
    'underscore',
    'Magento_Ui/js/modal/modal',
    'Magento_Checkout/js/action/select-shipping-address',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/shipping-address/form-popup-state',
    'Magento_Checkout/js/checkout-data',
    'Magento_Customer/js/customer-data'
], function ($, ko, url, Component, _, modal, selectShippingAddressAction, quote, formPopUpState, checkoutData, customerData) {
    'use strict';

    var countryData = customerData.get('directory-data');

    return Component.extend({
        defaults: {
            template: 'Magento_Checkout/shipping-address/address-renderer/default'
        },

        /** @inheritdoc */
        initObservable: function () {
            this._super();
            this.isSelected = ko.computed(function () {
                var isSelected = false,
                    shippingAddress = quote.shippingAddress();
                if (shippingAddress) {
                    isSelected = shippingAddress.getKey() == this.address().getKey(); //eslint-disable-line eqeqeq
                }
                return isSelected;
            }, this);

            return this;
        },
        /**
         * Get the key for the shipping address
         * 
         * @returns null|{String}
         */
        checkShipQuoteAddress: function () {
             if (quote.shippingAddress()){
                    return quote.shippingAddress().getKey();
             } else {
                 return "";
             }
        },
        /**
         * @param {String} countryId
         * @return {String}
         */
        getCountryName: function (countryId) {
            return countryData()[countryId] != undefined ? countryData()[countryId].name : ''; //eslint-disable-line
        },

        /**
         * Get customer attribute label
         *
         * @param {*} attribute
         * @returns {*}
         */
        getCustomAttributeLabel: function (attribute) {
            var label;

            if (typeof attribute === 'string') {
                return attribute;
            }

            if (attribute.label) {
                return attribute.label;
            }

            if (_.isArray(attribute.value)) {
                label = _.map(attribute.value, function (value) {
                    return this.getCustomAttributeOptionLabel(attribute['attribute_code'], value) || value;
                }, this).join(', ');
            } else {
                label = this.getCustomAttributeOptionLabel(attribute['attribute_code'], attribute.value);
            }

            return label || attribute.value;
        },

        /**
         * Get option label for given attribute code and option ID
         *
         * @param {String} attributeCode
         * @param {String} value
         * @returns {String|null}
         */
        getCustomAttributeOptionLabel: function (attributeCode, value) {
            var option,
                label,
                options = this.source.get('customAttributes') || {};

            if (options[attributeCode]) {
                option = _.findWhere(options[attributeCode], {
                    value: value
                });

                if (option) {
                    label = option.label;
                }
            }

            return label;
        },

        /** Set selected customer shipping address  */
        selectAddress: function () {
            selectShippingAddressAction(this.address());
            checkoutData.setSelectedShippingAddress(this.address().getKey());
            if (this.isSelected) {
                return true;
            }
        },

        /**
         * Edit address.
         */
        editAddress: function (addressKeyVal) {
            var addressKey = addressKeyVal.address._latestValue.customerAddressId;
            if (addressKey) {
                window.addressId = addressKey;
                formPopUpState.isVisible("updaterender");
            } else {
                formPopUpState.isVisible("true");
            }            
            this.showPopup(addressKey);

        },
        /**
         * Remove address
         */
        removeAddress: function(addressKeyVal){
            var addressKey = addressKeyVal.address._latestValue.customerAddressId;
            if (addressKey == undefined || addressKey == null) {
                checkoutData.setSelectedShippingAddress("");
                checkoutData.setNewCustomerShippingAddress("");
                window.location.reload();
            } else {
                $.ajax({
                    url: url.build('solumesltheme/address/remove'),
                    type: 'POST',
                    dataType: 'json',
                    showLoader: true,
                    data: {
                        'key': addressKey,
                    },
                    complete: function(response) {     
                        if (response.responseJSON.success == true) {  
                            window.location.reload();
                        } else {
                            console.log(response.responseJSON.success);
                        }
                    },
                    error: function (xhr, status, errorThrown) {
                        console.log('Error happens. Try again.');
                    }
                });
            }        
        },
        /**
         * Show popup.
         */
        showPopup: function (addressKey) {
            if (addressKey) {
                $.ajax({
                    url: url.build('solumesltheme/address/savedaddress'),
                    type: 'POST',
                    dataType: 'json',
                    showLoader: true,
                    data: {
                        'key': addressKey,
                    },
                    success: function(response) {     
                        if (response.status == true) {  
                            var address = response.addressdata
                            if (address) {
                                $("[name='firstname']").val(address.firstname);
                                $("[name='lastname']").val(address.lastname);
                                $("[name='company']").val(address.company);
                                $("[name='street[0]']").val(address.street[0]);
                                if (address.street.hasOwnProperty(1))
                                $("[name='street[1]']").val(address.street[1]);
                                if (address.street.hasOwnProperty(2))
                                $("[name='street[2]']").val(address.street[2]);
                                $("[name='country_id']").val(address.country_id);
                                $("[name='country_id']").trigger("change");
                                $("[name='city']").val(address.city);
                                $("[name='postcode']").val(address.postcode);
                                $("[name='telephone']").val(address.telephone);
                                if (address.region_id == 0) {
                                    $("[name='region']").val(address.region['region']);                                    
                                } else {
                                    $("[name='region_id']").val(address.region['region_id']);
                                    $("[name='region_id']").trigger("change");
                                }
                                $("#opc-new-shipping-address input").trigger("keyup");
                            }
                        } else {
                            console.log(response.status);
                        }
                    },
                    error: function (xhr, status, errorThrown) {
                        console.log('Error happens. Try again.');
                    }
                });
            }        
        }
    });
});