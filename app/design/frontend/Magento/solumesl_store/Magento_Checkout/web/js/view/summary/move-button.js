/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */


 define(
    [
        'jquery',
        'ko',
        'Magento_Checkout/js/view/summary',
        'Magento_Checkout/js/model/step-navigator',
        'Magento_Checkout/js/model/shipping-service',
        'Magento_Checkout/js/action/set-shipping-information',
        'Magento_Checkout/js/view/shipping'
    ],
    function(
        $,
        ko,
        Component,
        stepNavigator,
        shippingservice,
        setShippingInformationAction,
        shipping
    ) {
        'use strict';

        return Component.extend({

            cartUrl: window.checkoutConfig.cartUrl,

            isVisibleShippingButton: function () {
                var text = window.location.href;
                if (!stepNavigator.getActiveItemIndex() && text.includes("shipping")) {
                    $("body").find(".opc-block-summary").removeClass("solumesl-payment-page");
                }
                return !stepNavigator.getActiveItemIndex() && text.includes("shipping");
            },
            isPaymentPageDisplay: function () {
                var text = window.location.href;
                if(stepNavigator.getActiveItemIndex() && text.includes("payment")) {
                    $("body").find(".opc-block-summary").addClass("solumesl-payment-page");
                }
            },
            initialize: function () {                
                var self = this;
                this._super();     
            }, 

            rates: shippingservice.getShippingRates(),

            goToPayment: function(){        
                $( "#co-shipping-method-form" ).submit();  
            },            
        });
    }
);
