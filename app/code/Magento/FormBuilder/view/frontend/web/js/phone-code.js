/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

 define([
    'jquery',
    'mage/translate',
    'mage/validation'
], function ($, zxcvbn, $t) {
    'use strict';

    $.widget('mage.phoneCode', {
        options: {
            countrySelector: 'select[name="country_id"]',
            phoneCodeSelector: 'input[name="telephone"]',
            phoneCodeUrl : ''
        },

        /**
         * Widget initialization
         * @private
         */
        _create: function () {
            var self = this;
            var countryCode = $(self.options.countrySelector).val();
            self.setPhoneCode(countryCode);
            $(self.options.countrySelector).change(function () {
                self.setPhoneCode($(this).val());
            });
        },
        setPhoneCode: function(code) {
            var self = this;
            var settings = {
                "url": self.options.phoneCodeUrl + "?code=" + code,
                "method": "GET",
            };
            $.ajax(settings).done(function (phoneCode) {
                self.addPhoneCode(phoneCode);
            });
        },
        addPhoneCode: function(phoneCode) {
            if($(".telephone .control").find(".phone-code").length == 0) {
                $(".telephone .control").prepend("<span class='phone-code'>");
            }
            $(".telephone .control").find(".phone-code").html("+"+phoneCode);
        }
    });

    return $.mage.phoneCode;
});