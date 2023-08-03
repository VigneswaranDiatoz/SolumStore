define([
    "jquery",
    "Magento_Ui/js/modal/modal",
    'mage/template',
    "Magento_Ui/js/modal/alert",
    'Magento_Customer/js/customer-data',
    'Magento_Catalog/js/price-utils'
], function($, modal, mageTemplate, alert, customerData, priceUtils) {

    $.widget('mage.newWrapper', {
        options: {
            currentTab: 0,
            destinationReached: false,
            lBox:''
        },
        _create: function() {
            var self = this;
            var options = {
                type: 'slide',
                responsive: true,
                title: '',
                modalClass: 'configurable-popup',
                buttons: []
            };
    
            modal(options, $('#product-options-wrapper'));

            $(document).on('click', '#product-buynow-button', function (e) {
                e.preventDefault();
                $('#product-options-wrapper').modal('openModal');
                $("#purechat-container").hide();
            });

            $(document).on('click', '#login-modal-button', function (e) {
                $(document).find('.customer-notlogin').trigger('click');
            });

            $('#product-options-wrapper').on('modalclosed', function() { 
                $("#purechat-container").show();
            });

            if(self.options.productType == 'simple' || self.options.productType == 'virtual'){
                self.manageFinalStep($(this));
            }else{
                self.manageAttributes();
            }

            let boxes = document.querySelectorAll('.configurable-right-panel');
            if(boxes.length > 0){
                wh = window.innerHeight;
                whc = wh / 2;
    
                fBox = boxes[0];
                this.options.lBox = boxes[boxes.length - 1];
    
                //AlignFirst Box
                fBoxMarginTop = whc - ( fBox.offsetTop + ( fBox.offsetHeight / 2 ) );
                if(self.options.productType != 'configurable'){
                    fBox.style.marginTop = fBoxMarginTop + 'px';
                }
            }
        },

        attachEvents: function(currentElem) {
            var self = this; 
            var scrollBlockAlign = "center";
            elem = currentElem.parents('.configurable-right-panel')
            nextSlibling = elem.next()
            if ( !nextSlibling.length ) {
                return;
            }

            fBox.style.marginTop = '0px';
            elem.css('margin-bottom', '0px');

            nextSlibling.addClass('active');
            
            offBottom = Math.abs( wh - ( nextSlibling[0].getBoundingClientRect()['bottom']  ) + 20 );

            // regulating offsets due to firstbox margin top
            if ( !fBox.__isClick ) {
                offBottom = Math.abs( offBottom - fBoxMarginTop );
            }

            offCenterFromWindow = ( whc - ( nextSlibling[0].offsetHeight / 2  + offBottom ) - 20 );

            nextSlibling.css('margin-bottom', offBottom + offCenterFromWindow + 'px');

            if ( nextSlibling[0] === self.options.lBox ) {
                
                if (wh > nextSlibling[0].offsetHeight) {
                    offCenterFromWindow += 0;
                    scrollBlockAlign = 'end';
                    nextSlibling.css('padding-bottom', '60px');
                    nextSlibling.css('margin-bottom', '0px');
                } else {
                    offCenterFromWindow += whc - ( nextSlibling[0].offsetHeight / 2 ) - 20;
                    scrollBlockAlign = 'start';
                }
            }

            // multiple ways to achieve scroll

            nextSlibling[0].scrollIntoView({
                behavior: "smooth",
                block : scrollBlockAlign
            })
            // setTimeout( () => {

            //     (document.getElementsByClassName('configurable-wrapper')[0]).scrollTo({
            //         // top: offBottom + offCenterFromWindow,
            //         top: document.body.scrollHeight,
            //         behavior: 'smooth'
            //     });
            // }, 1000)

            elem.__isClick = true;
            currentElem.hide();
            // elem.removeEventListener( 'click', attachEvents )
        },

        manageAttributes: function () {
            var self = this;
            this.showTab();

            $(document).on('click', '.super-attribute-select', function(e){
                
                var currentElement = false;
                var parentElem = $(this).parents('.configurable-right-panel');
                $('.configurable-right-panel').attr('data-current-one',false);
                parentElem.attr('data-current-one',true);
                self.showTabByBox();
                var isMultiselect = parseInt(parentElem.attr('data-multiselect'));
                
                if ($(this).parent('.labl').hasClass('active')) {
                    $(this).attr('checked', false);
                    currentElement = true;
                }
                if (currentElement) {
                    $(this).parent().removeClass('active')
                    $(this).parent().find('.buying-qty').removeClass('active')
                } else {
                    if (!isMultiselect) {
                        $(this).parents('.control').find('.labl').removeClass('active');
                        $(this).parent().addClass('active')
                        $(this).siblings('.details-container').find('.buying-qty').addClass('active')
                    } else {
                        var checkboxes = parentElem.find('input[type="checkbox"]');
                        $.each(checkboxes, function(i, element) {
                            if ($(element).prop('checked')) {
                                $(this).parent().addClass('active')
                                $(this).siblings('.details-container').find('.buying-qty').addClass('active')
                            } else {
                                $(this).parent().removeClass('active')
                                $(this).siblings('.details-container').find('.buying-qty').removeClass('active')
                            }
                        })
                    }
                }

                self.manageFinalPrice();

                if (self.options.destinationReached) {
                    self.manageFinalStep()
                }
            });


            $(document).on('click', '.proceed-btn', function () {
                var parentElem = $(this).parents('.configurable-right-panel');
                var checkboxes = parentElem.find('input[type="checkbox"]');
                let canProceed = true;
                var optionsSelected = false;
                if (checkboxes.length) {
                    $.each(checkboxes, function(i, element) {
                        if ($(element).prop('checked')) {
                            optionsSelected = true;
                        }  
                    })
                }
                var radio = parentElem.find('input[type="radio"]');
                if (radio.length) {
                    $.each(radio, function(i, element) {
                        if ($(element).is(':checked')) {
                            optionsSelected = true;
                        }  
                    })
                }
                
                if (!optionsSelected) {
                    canProceed = false;
                    alert({
                        content: $.mage.__("Please Select Option")
                    });
                }
                if (canProceed) {
                    if (self.checkCandoFurther()) {
                        ++self.options.currentTab;
                        self.showTab()
                        self.attachEvents($(this))
                    } else {
                        self.manageFinalStep($(this));
                    }
                    // $(this).hide();
                }
            });
        },

        manageFinalPrice: function () {
            var items = $('.buying-qty');
            var finalPrice = 0;
            for(var i = 0; i < items.length; i++) {
                var qty = parseInt($(items[i]).val());
                var productPrice = $(items[i]).attr('data-product_price');
                finalPrice += productPrice*qty;
            }
            
            $('.price-box').html('<span class="price">'+priceUtils.formatPrice(finalPrice, self.options.basePriceFormat+'</span>'));
        },

        manageClass: function(element) {
            var parentElem = element.parents('configurable-right-panel');
            if (!parentElem.attr('data-multiselect')) {
                parentElem.find('.labl').removeClass('active')
                element.parent().addClass('active')
            }
        },

        manageCheckboxSelection: function(element) {
            if (!element.prop('checked')) {
                element.parent().removeClass('active')
            }
        },

        manageProccedButton: function(parentElem) {
            if (!parentElem.find('.active').length) {
                parentElem.find('.proceed-btn').addClass('btn-disabled')
            } else {
                parentElem.find('.proceed-btn').removeClass('btn-disabled')
            }
        },

        showTab: function (tabNo) {
            if(tabNo == undefined){
                var tabNo = this.options.currentTab;
            }
            $(".configurable-left-panel").hide();
            $($(".configurable-left-panel")[tabNo]).show();
        },

        showTabByBox:function(){
            var self = this;
            var count = 0;
            $('.configurable-right-panel').each((i,e)=>{
                if($(e).attr('data-current-one') === 'true'){
                    count = i;
                }
            });
            self.showTab(count);
        },

        // fixStepIndicator: function(tabNo) {
        //     $('.configurable-dot').removeClass('active saved');
        //     $($('.configurable-dot')[tabNo]).addClass('active');
        //     for (var i = 0; i < tabNo; i++) {
        //         $($('.configurable-dot')[i]).addClass('saved');
        //     }
        // },
        checkCandoFurther: function() {
            return ($('.configurable-dot').length-2) > this.options.currentTab;
        },

        manageFinalStep: function(proceedElem = null) {
            var self = this;
            var serializedData = $(".serialize-data").find("input").serializeArray();
            $.ajax(self.options.actionUrl, {
                method: 'post',
                data:{
                    options : JSON.stringify(serializedData)
                },
                showLoader: true,
                success: function (response) {                    
                    var buyingTemplate = mageTemplate('#buying-flow-final-step');
                    if(response.products){
                        var templateData = buyingTemplate({
                            data: {
                                products:response.products,
                                super_attribute:response.super_attribute,
                                product_id:$('input[name="product_id"]').val(),
                                product_type:response.product_type,
                                subscription_productStatus:response.sub_product,                            
                                sub_duration:response.sub_duration,                            
                                subscription_labels:response.subscription_labels
                            }
                        });
                        $('#final-panel-step').html(templateData);
                        $('.price-box').html('<span class="price">'+priceUtils.formatPrice(response.final_price, self.options.basePriceFormat+'</span>'));
                        self.manageBuyButton();
                    }else{
                        var templateData = {};
                        $('#final-panel-step').html(templateData);
                        self.manageFinalPrice();
                        $('.proceed-btn').show();
                        $('.buy-button').addClass('btn-disabled');
                    }
                    // self.options.finalPrice = response.final_price;
                    
                    // $('.price-box').attr('data-final_price', self.options.finalPrice);
                    
                    ++self.options.currentTab;
                    self.options.destinationReached = true;
                    if (proceedElem) {
                        self.showTab()
                        self.attachEvents(proceedElem)
                    }
                }
            });

            $(document).on('click', '.buy-button', function() {
                
                var serializedData = $(".final-panel-step").find("input").serializeArray();
                if(self.options.productType == 'simple' || self.options.productType == 'virtual'){
                    var productId = $(".final-panel-step").find("input[name=product_id]").val();
                    var planId = $(".final-panel-step").find("input[name=plan_id]").val();
                    var termId = $(".final-panel-step").find("input[name=term_id]").val();
                    var subscriptionCharge = $(".final-panel-step").find("input[name=subscription_charge]").val();
                    var startDate = $(".final-panel-step").find("input[name=start_date]").val();
                    var formKey = $(".final-panel-step").find("input[name=form_key]").val();
                    var qty = $(".final-panel-step").find(".buying-qty").val();
                    formData = new FormData();
                    formData.set('form_key',formKey);
                    formData.set('item',productId);
                    formData.set('plan_id',planId);
                    formData.set('term_id',termId);
                    formData.set('subscription_charge',subscriptionCharge);
                    formData.set('start_date',startDate);               
                    formData.set('qty',qty);
                }                
                if(self.options.productType != 'simple' && self.options.productType != 'virtual'){
                    $.ajax(self.options.addToCartUrl, {
                        method: 'post',
                        data:{
                            addtocartData : JSON.stringify(serializedData)
                        },
                        showLoader: true,
                        success: function (response) {
                            $('body').trigger('processStart');
                            // customerData.invalidate(['cart', 'directory-data', 'messages']);
                            // customerData.reload(['cart', 'directory-data', 'messages']);
                            $(".configurable-right-wrapper").find("input").prop('checked', false).prop('selected', false);
                            $('.configurable-right-wrapper').find('.active').removeClass('active');
                            $('.configurable-right-wrapper').find('.proceed-btn').addClass('btn-disabled')
                            $('.buy-button').addClass('btn-disabled');
    
                            $('.buy-button .price-box').html(priceUtils.formatPrice(0, self.options.basePriceFormat));
                            // $('.price-box').attr('data-final_price', self.options.finalPrice);
    
                            $('#product-options-wrapper').modal('closeModal');
                            
                            self.options.currentTab = 0;
                            self.showTab()
                            window.location.href = self.options.cartUrl
                        }
                    });
                }else{          
                    $.ajax(self.options.addToCartUrl, {
                        method: 'post',
                        data: formData,
                        type: 'post',
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            $('body').trigger('processStart');
                            // customerData.invalidate(['cart', 'directory-data', 'messages']);
                            // customerData.reload(['cart', 'directory-data', 'messages']);
                            $(".configurable-right-wrapper").find("input").prop('checked', false).prop('selected', false);
                            $('.configurable-right-wrapper').find('.active').removeClass('active');
                            $('.configurable-right-wrapper').find('.proceed-btn').addClass('btn-disabled')
                            $('.buy-button').addClass('btn-disabled');
    
                            $('.buy-button .price-box').html(priceUtils.formatPrice(0, self.options.basePriceFormat));
                            // $('.price-box').attr('data-final_price', self.options.finalPrice);
    
                            $('#product-options-wrapper').modal('closeModal');
                            
                            self.options.currentTab = 0;
                            self.showTab()
                            window.location.href = self.options.cartUrl
                        }
                    });
                }                
            });

            $(document).on('click', '.delete-action', function(){
                $(this).parents('.labl').remove();
                // if ($('.delete-action').length == 1) {
                //     $('.delete-action').remove();
                // }
                if (self.options.destinationReached) {
                    let attr_ids = $(this).data('deleteof');
                    let attridsArray = attr_ids.split(",");
                    self.unCheckAttribute(attridsArray,attr_ids);
                }
                self.manageFinalPrice();
            });

            $(document).on('change', '.buying-qty', function(){
                var qty = parseInt($(this).val());
                let product_id = $(this).closest('.labl').find('.hidden_product_id').val();
                let plan_id = $(this).closest('.labl').find('.hidden_product_duration').val();
                let condition_value = $(this).closest('.labl').find('.hidden_condition_unit_value').val();
                var productPrice = $(this).attr('data-product_price');
                if (qty) {
                    $('.buy-button.btn-disabled').removeClass('btn-disabled');

                    $(this).parents('.details-container').find('.price-container').html(
                        priceUtils.formatPrice(productPrice*qty, self.options.basePriceFormat)
                    );
                    self.manageFinalPrice();
                    if(plan_id){
                        self.manageLabels(product_id, qty, plan_id, condition_value);
                    }
                } else {
                    $('.buy-button').addClass('btn-disabled');
                    alert({
                        content: $.mage.__("Please enter quantity greater then 0.")
                    });
                }
            })

            $(document).on('change','.product_duration_select',function(){
                let plan_id = $('option:selected',this).attr('data-durationid'); 
                let product_id = $(this).closest('.labl').find('.hidden_product_id').val();
                let subscription_charge = $('option:selected',this).attr('data-subscriptionCharge');    
                let condition_value = $('option:selected',this).attr('data-conditionvalue');  
                let duration_label = $('option:selected',this).attr('data-label');
                let qty = parseInt($(this).closest('.labl').find('.buying-qty').val()); 
                let formattedprice = $('option:selected',this).attr('data-formattedPrice');
                let price = $('option:selected',this).attr('data-price');
                let productType = $('option:selected',this).attr('data-productType');
                if(productType == 'simple' || productType == 'virtual' || productType == 'configurable'){
                    $(this).closest('.labl').find('.product-price-container').html("Price " + formattedprice+'/'+'<span class="set_duration_label">'+duration_label+'</span>');
                    $(this).closest('.labl').find('.price-container').text(priceUtils.formatPrice(price*qty, self.options.basePriceFormat));
                    $(this).closest('.labl').find('.buying-qty').attr('data-product_price',price);
                }

                $(this).closest('.labl').find('.set_duration_label').text(duration_label);
                $(this).closest('.labl').find('.hidden_product_duration').val(plan_id);
                $(this).closest('.labl').find('.hidden_plan_id').val(plan_id);
                $(this).closest('.labl').find('.hidden_term_id').val(plan_id);
                $(this).closest('.labl').find('.hidden_subscription_charge').val(subscription_charge);
                $(this).closest('.labl').find('.hidden_condition_unit_value').val(condition_value);
                if(plan_id){
                    self.manageLabels(product_id, qty, plan_id, condition_value);
                }      
                self.manageFinalPrice();
            });
            
        },

        unCheckAttribute: function(attributeArray,seleted_attribute) {
            // now will have to compare the attributeArray against others delete button
            let false_set = [];
            for(let t = 0; t < attributeArray.length; t++){
                let unset_attribute_array = [];
                $('.delete-action').each(function(j,delbtn) {    
                    let delbtn_value =  $(delbtn).data('deleteof'); 
                    let delbtn_value_array =  $(delbtn).data('deleteof').split(",");   
                    if(delbtn_value_array.includes(attributeArray[t])){
                        unset_attribute_array.push('true');
                    }else{
                        unset_attribute_array.push('false');
                    }
                });
                if((!unset_attribute_array.includes('true')) && (unset_attribute_array.length > 0)){
                    false_set.push(attributeArray[t]);
                }
            }
            if(false_set.length > 0){
                false_set.forEach((attribute_id,k)=>{
                    $('.super-attribute-select').each(function(i, element) {
                        if(($(element).val() == attribute_id) && ($(element).is(':checked'))){
                            $(element).trigger('click');
                        }
                    });
                });
            }
        }, 

        manageBuyButton: function() {
            $('.buy-button').removeClass('btn-disabled');
        },

        manageLabels: function(product_id, qty, plan_id, condition_value){
            var self = this;
            $.ajax(self.options.labelUrl, {
                method: 'post',
                data:{
                    productId: product_id,
                    qty: qty,
                    planId: plan_id,
                    conditionValue: condition_value
                },
                showLoader: true,
                success: function (response) { 
                    let content = '';  
                    response.forEach((item)=>{
                        content += '<div class="subdetail">';
                        content += '<span class="subdetail_name">'+item.label+'</span> - ';
                        content += '<span class="subdetail_label">'+item.value+'</span>';
                        content += '</div>';
                    });   
                    $('#product_id_'+product_id).html(content);
                }
            });
        },

        manageQtyText: function(qty){
            let returnValue;
            if (qty >= 1000000000000) {
                returnValue = (qty/1000000000000)+'T';
            } else if (qty >= 1000000000) {
                returnValue = (qty/1000000000)+'B';
            } else if (qty >= 1000000) {
                returnValue = (qty/1000000)+'M';
            } else if (qty >= 1000){
                returnValue = (qty/1000)+'k';
            } else {
                returnValue = qty;
            }
            return returnValue;
        }
    });
    return $.mage.newWrapper;
});