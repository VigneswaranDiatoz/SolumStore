define([
    "jquery",
    "Magento_Ui/js/modal/modal",
    'mage/template',
    "Magento_Ui/js/modal/alert",
    'Magento_Customer/js/customer-data',
    'Magento_Catalog/js/price-utils'
], function($, modal, mageTemplate, alert, customerData, priceUtils) {

    $.widget('mage.configurableWrapper', {
        options: {
            currentTab: 0,
            destinationReached: false,
            lBox:''
        },
        _create: function() {

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
            });

            $(document).on('click', '#login-modal-button', function (e) {
                $(document).find('.customer-notlogin').trigger('click');
            });

            this.manageAttributes();



            let boxes = document.querySelectorAll('.configurable-right-panel');
            wh = window.innerHeight;
            whc = wh / 2;

            fBox = boxes[0];
            this.options.lBox = boxes[boxes.length - 1];

            //AlignFirst Box
            fBoxMarginTop = whc - ( fBox.offsetTop + ( fBox.offsetHeight / 2 ) );

            if (fBoxMarginTop > 0) {
                fBox.style.marginTop = fBoxMarginTop + 'px';
            } else {
                fBox.style.marginBottom = Math.abs(fBoxMarginTop) + 'px';
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

            elem.__isClick = true;
            currentElem.hide();
        },

        manageAttributes: function () {
            var self = this;
            this.showTab();

            $(document).on('click', '.super-attribute-select', function(e){
                
                var currentElement = false;
                var parentElem = $(this).parents('.configurable-right-panel');
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
            
            // $(document).on('click', '.configurable-dot.saved', function(){
            //     --self.options.currentTab
            //     self.showTab()
            // })

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
                if (canProceed && self.manageQtyCheck()) {
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

            $(document).on('click', '.buy-button', function() {
                if (self.manageQtyCheck()) {
                    var serializedData = $(".final-panel-step").find("input").serializeArray();
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
                }
            });

            $(document).on('click', '.delete-action', function(){
                $(this).parents('.labl').remove();
                if ($('.delete-action').length == 1) {
                    $('.delete-action').remove();
                }
                self.manageFinalPrice();
            });

            $(document).on('change', '.buying-qty', function(){
                var qty = parseInt($(this).val());
                var productPrice = $(this).attr('data-product_price');
                if (qty) {
                    $('.buy-button.btn-disabled').removeClass('btn-disabled');

                    $(this).parents('.details-container').find('.price-container').html(
                        priceUtils.formatPrice(productPrice*qty, self.options.basePriceFormat)
                    );
                    self.manageFinalPrice();
                } else {
                    $('.buy-button').addClass('btn-disabled');
                    alert({
                        content: $.mage.__("Please add quantity")
                    });
                }
            })
        },

        manageQtyCheck: function () {
            let checkQty = true;
            var radio = $('.configurable-right-panel').find('input[type="radio"]');
            if (radio.length) {
                $.each(radio, function(i, element) {
                    if ($(element).is(':checked') && !parseInt($(element).parent().find('.buying-qty').val())) {
                        checkQty = false;
                        return false;
                    }
                })
            }
            var checkboxes = $('.configurable-right-panel').find('input[type="checkbox"]');
            if (checkboxes.length) {
                $.each(checkboxes, function(i, element) {
                    if ($(element).prop('checked') && !parseInt($(element).parent().find('.buying-qty').val())) {
                        checkQty = false;
                        return false;
                    }  
                })
            }
            if (!checkQty) {
                alert({
                    content: $.mage.__("Please add quantity in selected options")
                });
            }

            return checkQty;
        },
        
        manageFinalPrice: function () {
            var self = this;
            var items = $('.buying-qty');
            var finalPrice = 0;
            for(var i = 0; i < items.length; i++) {
                var qty = parseInt($(items[i]).val());
                var productPrice = $(items[i]).attr('data-product_price');
                finalPrice += productPrice*qty;
            }
            
            $('.price-box').html(priceUtils.formatPrice(finalPrice, self.options.basePriceFormat));
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

        showTab: function () {
            var tabNo = this.options.currentTab;
            $(".configurable-left-panel").hide();
            $($(".configurable-left-panel")[tabNo]).show();
        },
        
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
                    var templateData = buyingTemplate({
                        data: {
                            products:response.products,
                            super_attribute:response.super_attribute,
                            product_id:$('input[name="product_id"]').val(),
                        }
                    });
                    // self.options.finalPrice = response.final_price;
                    
                    $('#final-panel-step').html(templateData);
                    $('.price-box').html(priceUtils.formatPrice(response.final_price, self.options.basePriceFormat));
                    // $('.price-box').attr('data-final_price', self.options.finalPrice);
                    self.manageBuyButton();
                    
                    ++self.options.currentTab;
                    self.options.destinationReached = true;
                    if (proceedElem) {
                        self.showTab()
                        self.attachEvents(proceedElem)
                    }
                }
            });
        },

        manageBuyButton: function() {
            $('.buy-button').removeClass('btn-disabled');
        }

    });
    return $.mage.configurableWrapper;
});