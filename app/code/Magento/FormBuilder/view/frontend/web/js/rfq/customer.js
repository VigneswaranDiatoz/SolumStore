/**
 * @category   Webkul
 * @package    Webkul_SocialSignup
 * @author     Webkul Software Private Limited
 * @copyright  Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license    https://store.webkul.com/license.html
 */

 define([
    'jquery',
    'mage/url',
    'mage/mage',
], function ($, urlBuilder) {
    'use strict';

    return function (config) {
        let loginForm = $(".wk-step.customer-from .wk-step-body").find(".block-customer-login");
        let registerForm = $(".wk-step.customer-from .wk-step-body").find(".form-create-account");
        let signUpButton = $(".wk-step.customer-from .wk-step-body").find(".signup-btn");
        let subtitle = $(".wk-step.customer-from .wk-step-body").find(".wk-step-subtitle");
        let signInButton = $(".wk-step.customer-from .wk-step-body").find(".signin-btn");
        let title = $(".wk-step.customer-from .wk-step-title");
        loginForm.submit(function (event) {
            if (!(loginForm.find($(".field.password")).is(":visible"))) {
                event.preventDefault();
                var email = loginForm.find($("input[name='username']")).val();
                var settings = {
                    "url": urlBuilder.build("rest/all/V1/customers/isEmailAvailable"),
                    "method": "POST",
                    "headers": {
                    "accept": "application/json",
                    "Content-Type": "application/json",
                    },
                    "processData": false,
                    "mimeType": "multipart/form-data",
                    "contentType": false,
                    "data": JSON.stringify({
                        "customerEmail": email,
                        "websiteId": 1,
                    })
                };
                $.ajax(settings).done(function (isEmailAvailable) {
                    subtitle.hide();
                    loginForm.find(".field-recaptcha").hide();
                    if (isEmailAvailable == "false") {
                        loginForm.find($(".field.password")).show();
                        loginForm.find($(".wk-action.secondary")).show();
                        loginForm.find($(".wk-action.persistent")).css("display", "inline-block");
                        loginForm.find(".sign-up-actions-toolbar").show();
                        loginForm.find(".sign-in-actions-toolbar").hide();
                        title.html("<span>"+config.loginLabel+"</span>");
                    } else {
                        registerForm.find($(".field.email")).hide();
                        loginForm.hide();
                        registerForm.show();
                        registerForm.find($("input[name='email']")).val(email);
                        title.html("<span>"+config.createLabel+"</span>");
                    }
                });
            }
        });
        signUpButton.click(function(){
            registerForm.find($(".field.email")).show();
            loginForm.hide();
            registerForm.show();
            title.html("<span>"+config.createLabel+"</span>");
        });
        signInButton.click(function(){
            loginForm.show();
            registerForm.hide();
            loginForm.find(".sign-up-actions-toolbar").show();
            loginForm.find(".sign-in-actions-toolbar").hide();
            loginForm.find($(".field.password")).show();
            loginForm.find($(".wk-action.secondary")).show();
            loginForm.find($(".wk-action.persistent")).css("display", "inline-block");
            title.html("<span>"+config.loginLabel+"</span>");
        });
    };
});