/**
 *
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_FormBuilder
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

 define([
    "jquery",
    "Magento_Ui/js/modal/modal",
    'Magento_Ui/js/modal/alert',
    'mage/url',
    'mage/template',
    "mage/translate",
    'mage/mage',
], function($, modal, alert, urlBuilder, mageTemplate, $t) {
    "use strict";
    $.widget('formBuilder.rfqModal', {
        options: {
            container: null,
            reLoadflag: false,
            totalSteps: 0,
            showSeller: 0,
            catIds: [],
            loginForm: null
        },
        _create: function() {
            var self = this;
            self.options.container = self.bindings[0];
            self.options.reLoadflag = false;
            self.options.loginForm = $(self.options.container).find(".block-customer-login").find("#login-form");
            $(document).ready(function($) {
                if(self.options.recaptchaEnable && self.options.checkRecaptcha){
                    grecaptcha.ready(function() {
                        grecaptcha.execute(self.options.siteKey, {action: 'form_builder'}).then(function(token) {
                            $("input[id=g-recaptcha-response]").val(token)
                        });
                    });
                }
                var allInputFields = $("#wk-rfq-modal").find(".field.required").find("input");
                for (var i = 0; i < allInputFields.length; i++) {
                    if ($(allInputFields[i]).attr("aria-required")) {
                        $(allInputFields[i]).attr("required",true);
                    }
                }
                let registerForm = $(self.options.container).find(".form-create-account");
                let title = $(".wk-step.customer-from .wk-step-title");
                let step = 1;
                var modalOptions = {
                    type: 'popup',
                    responsive: true,
                    innerScroll: true,
                    modalClass: "wk-rfq-modal",
                    title: $t("Steps to Submit Quote")+"<div class='progress-bar'></div>",
                    subTitle: step+"/"+self.options.totalSteps,

                    closed: function (){
                        if (self.options.reLoadflag) {
                            $('body').trigger('processStart');
                            location.reload();
                        }
                        var hash = window.location.hash.substring(1);
                        if (hash == "wk-rfq-modal"){
                            window.location.hash = "";
                        }
                    },
                    buttons: []
                };
    
                var popup = modal(modalOptions, $(self.options.container));
                $(window).on('hashchange', function(e){
                    var hash = window.location.hash.substring(1);
                    if (hash == "wk-rfq-modal"){
                        $(self.options.buttonId).click();
                    }
                });
                $(self.options.buttonId).click(function() {
                    $(self.options.container).attr("data-only-login", false);
                    $(".modal-title").show();
                    $(".signin-btn").click();
                    title.html("<span>"+self.options.formData.step1_label+"</span>");
                    self.options.loginForm.find($(".field.password")).hide();
                    self.options.loginForm.trigger("reset");
                    self.options.loginForm.find(".sign-up-actions-toolbar").hide();
                    self.options.loginForm.find(".sign-in-actions-toolbar").show();
                    self.options.loginForm.find(".wk-action.secondary").hide();
                    self.options.loginForm.parents().find(".modal-title").hide();
                    registerForm.trigger("reset");
                    step = 1;
                    let currentStep = steps.find(".wk-step.current");
                    let nextStep = steps.find(".wk-step:first");
                    currentStep.removeClass("current");
                    nextStep.addClass("current");
                    subTitleDiv.html(step+"/"+self.options.totalSteps);
                    width = ((step * 100)/self.options.totalSteps);
                    progressiveBar.style.setProperty('--after-width', width+"%");
                    // $("#wk-form-id").trigger("reset");
                    // $(".wk-step").find(".wk-next").attr("disabled",true);
                    // $(".wk-step").find("button[type='submit'].wk-next").removeAttr("disabled");
                    // $(".wk-rfq-modal .modal-title").show();
                    $(".wk-rfq-modal .wk-step.last-step").find(".study-row").html("");
                    $(self.options.container).modal('openModal');
                });
                $(".customer-notlogin").click(function() {
                    $(self.options.container).attr("data-only-login", true);
                    $(".modal-title").hide();
                    $(".signin-btn").click();
                    $(self.options.container).modal('openModal');
                });
                let steps = $(".modal-body-content");
                let subTitleDiv = $(".modal-popup.wk-rfq-modal .modal-title .modal-subtitle");
                var progressiveBar = $(".modal-popup.wk-rfq-modal .modal-title")[0];
                var loginContrainer= $(self.options.container).find(".block-customer-login");
                var accordions = $(self.options.container).find(".radio-box-group.accord .radio-label");
                accordions.click(function(event) {
                    if ($(this).attr("aria-expanded") == "true") {
                        $(self.options.container).find(".radio-box-group.accord .radio-label[aria-expanded='true']").not(this).click();
                    }
                });
                if (accordions.length > 0) {
                    var hashingValue = window.location.hash.substring(1);
                    $(accordions).each(function (key, acc) {
                        var label = $(acc).find(".radio-label-span").html().trim();
                        label = label.replace(" ","");
                        if (label.toLowerCase() == hashingValue.toLowerCase()) {
                            setTimeout(function () {
                                $(acc).click();
                            },500);
                            return;
                        }
                    });
                }
                loginContrainer.find("input[name='is_social']").on("change", function() {
                    var val = $(this).val();
                    if (val == 1) {
                        let currentStep = steps.find(".wk-step.current");
                        let nextStep = currentStep.next();
                        currentStep.removeClass("current");
                        nextStep.addClass("current");
                        subTitleDiv.html((++step)+"/"+self.options.totalSteps);
                        width = ((step * 100)/self.options.totalSteps);
                        progressiveBar.style.setProperty('--after-width', width+"%");
                    }
                });
                self.options.loginForm.submit(function (event) {
                    event.preventDefault();
                    if ((self.options.loginForm.find($(".field.password")).is(":visible")) && self.options.loginForm.valid()) {
                        var loginData = {},
                        formDataArray = self.options.loginForm.serializeArray();
                        formDataArray.forEach(function (entry) {
                            loginData[entry.name] = entry.value;
                        });
                        $.ajax({
                            type: self.options.loginForm.attr("method"),
                            url: urlBuilder.build("customer/ajax/login"),
                            data: JSON.stringify(loginData),
                            showLoader: true,
                            success: (data) => {
                                $('body').trigger('processStop');
                                window.scrollTo(0, 0);
                                if (data.errors == false) {
                                    location.reload();
                                    // self.options.reLoadflag = true;
                                    // if ($(self.options.container).attr("data-only-login") == "false") {
                                    //     let currentStep = steps.find(".wk-step.current");
                                    //     let nextStep = steps.find("#wk-form-id .wk-step:first");
                                    //     currentStep.removeClass("current");
                                    //     nextStep.addClass("current");
                                    //     subTitleDiv.html((++step)+"/"+self.options.totalSteps);
                                    //     width = ((step * 100)/self.options.totalSteps);
                                    //     progressiveBar.style.setProperty('--after-width', width+"%");
                                    // } else {
                                    //     location.reload();
                                    // }
                                } else if (data.errors == true) {
                                    self.options.loginForm.find(".wk-error-box .err-msg").html(data.message);
                                    self.options.loginForm.find(".wk-error-box").show();
                                } else {
                                    self.options.loginForm.find(".wk-error-box .err-msg").html($.mage.__('Something went wrong, please try again later'));
                                    self.options.loginForm.find(".wk-error-box").show();
                                }
                            },
                        });
                    }
                });
                registerForm.submit(function (event) {
                    event.preventDefault();
                    if (registerForm.valid()) {
                        var passValue = registerForm.find("input[name='password']").val();
                        registerForm.find("input[name='password_confirmation']").val(passValue);
                        $.ajax({
                            type: registerForm.attr("method"),
                            url: urlBuilder.build("formbuilder/account/createpost"),
                            data: registerForm.serialize(),
                            showLoader: true,
                            success: (data) => {
                                $('body').trigger('processStop');
                                window.scrollTo(0, 0);
                                if (data.errors == false) {
                                    $(self.options.container).modal('closeModal');
                                    if(data.alert === true){
                                        alert({
                                            title: $.mage.__(data.title),
                                            content: data.msg,
                                            actions: {
                                                always: function(){
                                                    if(data.reload === true){
                                                        location.reload();
                                                    }
                                                }
                                            }
                                        });
                                    }
                                    
                                    // if ($(self.options.container).attr("data-only-login") == "false") {
                                    //     let currentStep = steps.find(".wk-step.current");
                                    //     let nextStep = steps.find("#wk-form-id .wk-step:first");
                                    //     currentStep.removeClass("current");
                                    //     nextStep.addClass("current");
                                    //     subTitleDiv.html((++step)+"/"+self.options.totalSteps);
                                    //     width = ((step * 100)/self.options.totalSteps);
                                    //     progressiveBar.style.setProperty('--after-width', width+"%");
                                    // } else {
                                    //     location.reload();
                                    // }
                                } else if (data.errors == true) {
                                    registerForm.find(".wk-error-box .err-msg").html(data.msg);
                                    registerForm.find(".wk-error-box").show();
                                } else {
                                    registerForm.find(".wk-error-box .err-msg").html($.mage.__('Something went wrong, please try again later'));
                                    registerForm.find(".wk-error-box").show();
                                }
                            },
                        });
                    }
                });
                var width = ((step * 100)/self.options.totalSteps);
                progressiveBar.style.setProperty('--after-width', width+"%");
                $(".actions-toolbar.wk-nav-from .wk-prev").click(()=> {
                    let currentStep = steps.find(".wk-step.current");
                    let nextStep = currentStep.prev();
                    currentStep.removeClass("current");
                    nextStep.addClass("current");
                    subTitleDiv.html((--step)+"/"+self.options.totalSteps);
                    width = ((step * 100)/self.options.totalSteps);
                    progressiveBar.style.setProperty('--after-width', width+"%");
                    
                });
                $(".actions-toolbar.wk-nav-from .wk-next").click(()=> {
                    let currentStep = steps.find(".wk-step.current");
                    let nextStep = currentStep.next();
                    let newstep = ++step;
                    if (nextStep.length > 0 && self.options.totalSteps >= newstep) {
                        currentStep.removeClass("current");
                        nextStep.addClass("current");
                        subTitleDiv.html((newstep)+"/"+self.options.totalSteps);
                        width = ((step * 100)/self.options.totalSteps);
                        progressiveBar.style.setProperty('--after-width', width+"%");
                    }
                });
                $(".actions-toolbar.wk-nav-from .wk-skip").click(()=> {
                    let currentStep = steps.find(".wk-step.current");
                    let nextStep = currentStep.next();
                    if (nextStep.length > 0) {
                        currentStep.removeClass("current");
                        nextStep.addClass("current");
                        subTitleDiv.html((++step)+"/"+self.options.totalSteps);
                        width = ((step * 100)/self.options.totalSteps);
                        progressiveBar.style.setProperty('--after-width', width+"%");
                    }
                });
                if (parseInt(self.options.showSeller)) {
                    var allSellerTemp = mageTemplate('#all-seller-radio'),
                    subCatTemp = mageTemplate('#child-cat-template'),
                    tmpl;
                    var subCatTemp = mageTemplate('#child-cat-template');
                    var sellerTemp = mageTemplate('#seller-cat-template');
                    self.options.catIds.forEach(categoryId => {
                        var settings = {
                            "url": self.options.sellercategoriesUrl+"?rootCategoryId="+categoryId+"&depth=2",
                            "method": "GET",
                        };
                        $.ajax(settings).done(function (response) {
                            var allSellers = [];
                            response.forEach(cat => {
                                
                                var tmpl = subCatTemp({
                                    data: {
                                        name: cat.name,
                                        id: cat.id
                                    }
                                });
                                $('#child-cats-self.options.container').append(tmpl);

                                var sellers = cat.sellers;
                                sellers.forEach(seller => {
                                    if (!allSellers.includes(seller)) {
                                        allSellers.push(seller);
                                    }
                                });
                            });

                            $('#seller-cats-self.options.container').html("");
                            $.each(allSellers, function( sellerId, seller ) {
                                var tmpl = sellerTemp({
                                    data: {
                                        name: seller.shop_title ?? seller.shop_url,
                                        id: seller.seller_id
                                    }
                                });
                                $('#seller-cats-self.options.container').append(tmpl);
                            });
                        });
                    });
                    $("input[name='res[type][value]']").change((event) => {
                        let categoryId = $(event.target).val();
                        let catName = $(event.target).attr("data-name");
                        tmpl = allSellerTemp({
                            data: {
                                name: "All "+catName+ " Seller ",
                                categoryId: categoryId,
                            }
                        });
                        $('#seller-step-self.options.container').html(tmpl);
                        var settings = {
                            "url": self.options.sellercategoriesUrl+"?rootCategoryId="+categoryId+"&depth=2",
                            "method": "GET",
                        };
                        $.ajax(settings).done(function (response) {
                            var allSellers = [];
                            $('#child-cats-self.options.container').html("");
                            response.forEach(cat => {
                                var tmpl = subCatTemp({
                                    data: {
                                        name: cat.name,
                                        id: cat.id
                                    }
                                });
                                $('#child-cats-self.options.container').append(tmpl);
                                var sellers = cat.sellers;
                                sellers.forEach(seller => {
                                    if (!allSellers.includes(seller)) {
                                        allSellers.push(seller);
                                    }
                                });
                            });
                            $('#seller-cats-self.options.container').html("");
                            $.each(allSellers, function( sellerId, seller ) {
                                var tmpl = sellerTemp({
                                    data: {
                                        name: seller.shop_title ?? seller.shop_url,
                                        id: seller.seller_id
                                    }
                                });
                                $('#seller-cats-self.options.container').append(tmpl);
                            });
                        });
                    });

                    $(document).on("click", ".cat-tabs .cat-tab",(event) => {
                        let categoryId = $(event.target).attr("data-id");
                        $(".cat-tabs .cat-tab").removeClass("clicked");
                        $(event.target).addClass("clicked");
                        var settings = {
                            "url": self.options.sellercategoriesUrl+"?rootCategoryId="+categoryId+"&depth=2&isChildrenNeeded="+false,
                            "method": "GET",
                            "showLoader": true
                        };
                        $.ajax(settings).done(function (response) {
                            $('body').trigger('processStop');
                            var sellers = response[0].sellers;
                            $('#seller-cats-self.options.container').html("");
                            sellers.forEach(seller => {
                                var tmpl = sellerTemp({
                                    data: {
                                        name: seller.shop_title ?? seller.shop_url,
                                        id: seller.seller_id
                                    }
                                });
                                $('#seller-cats-self.options.container').append(tmpl);
                            });
                        });
                    });
                    var dataForPage = self.options.dataForPage;
                    var dataLen = Object.keys(dataForPage).length;
                    if (dataLen > 0 && dataForPage.selectedCatId) {
                        let catId = dataForPage.selectedCatId;
                        let catInputs = $("input[name='res[type][value]']");
                        for (let i = 0; i < catInputs.length; i++) {
                            if (catInputs[i].value == catId) {
                                $(catInputs[i]).click();
                                $(".wk-step.current .actions-toolbar.wk-nav-from .wk-next").click();
                                break;
                            }
                        }
                    }
                } else {
                    $(".wk-step").find("input").on("change", (event) => {
                        event.preventDefault();
                        $(".wk-step.current").find(".wk-next").removeAttr("disabled");
                    });
                }
            });
            $(document).ajaxComplete(function() {
                $(".wk-step").find("input").on("change", (event) => {
                    event.preventDefault();
                    $(".wk-step.current").find(".wk-next").removeAttr("disabled");
                });
            });      
        }
    });
    return $.formBuilder.rfqModal;
});
