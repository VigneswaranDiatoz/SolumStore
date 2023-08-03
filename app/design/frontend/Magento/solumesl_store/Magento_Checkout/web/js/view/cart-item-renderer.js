/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

 define([
     'jquery',
    'uiComponent'
], function ($, Component) {
    'use strict';

    return Component.extend({
        /**
         * Prepare the product name value to be rendered as HTML
         *
         * @param {String} productName
         * @return {String}
         */
        getProductNameUnsanitizedHtml: function (productName) {
            // product name has already escaped on backend
            return productName;
        },

        /**
         * Prepare the given option value to be rendered as HTML
         *
         * @param {String} optionValue
         * @return {String}
         */
        getOptionValueUnsanitizedHtml: function (optionValue) {
            // option value has already escaped on backend
            return optionValue;
        },
        /**
         * Manage the quantity update value in minicart
         * 
         * @param {String} id 
         * @param {String} stat 
         */
        manageIncDec: function(id, stat) {
            var ctrl = (id.replace('-upt','')).replace('-dec','');          
            var currentQty = $("#cart-item-"+ctrl+"-qty").val();
            if(stat == 'increaseQty'){
                var newAdd = parseInt(currentQty)+parseInt(1);
                 $("#cart-item-"+ctrl+"-qty").val(newAdd);
                 $("#cart-item-"+ctrl+"-qty").trigger('change');
            }else{
                 if(currentQty>=1){
                    var newAdd = parseInt(currentQty)-parseInt(1);
                    $("#cart-item-"+ctrl+"-qty").val(newAdd); 
                    $("#cart-item-"+ctrl+"-qty").trigger('change');                    
                 }
            }
        }
    });
});
