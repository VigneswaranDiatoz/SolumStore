/**
 * @category   Webkul
 * @package    Webkul_FormBuilder
 * @author     Webkul Software Private Limited
 * @copyright  Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license    https://store.webkul.com/license.html
 */
/*jshint jquery:true*/
define([
    "jquery",
    'mage/url',
    'mage/translate',
    "jquery/ui"
], function ($, urlBuilder) {
    'use strict';
    $.widget('mage.fbBlockPlugin', {
        options: {
            fbLogin: '.fblogin',
            actionButton :'.login .actions-toolbar .create .actions-toolbar',
            socialContainer : ".wk_socialsignup_rfq_container"
        },
        _create: function () {
            var self = this;
            window.fbAsyncInit = function () {
                FB.init({
                    appId: self.options.fbAppId,
                    status     : true,
                    cookie     : true,
                    xfbml      : true,
                    oauth      : true
                });
                FB.getLoginStatus(function (response) {
                    if (response.status == 'connected') {
                        if (self.options.customerSession && self.options.uId) {
                            self.greet(self.options.uId);
                        }
                    }
                });
            };
            (function (d) {
                var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {
                    return;}
                js = d.createElement('script'); js.id = id; js.async = true;
                js.src = "//connect.facebook.net/"+self.options.localeCode+"/all.js";
                d.getElementsByTagName('head')[0].appendChild(js);
            }(document));
            $(self.options.fbLogin).on('click', function (e) {
                self.fblogin();
            });
        },
        greet: function (id) {
            FB.api('/me', function (response) {
                var src = 'https://graph.facebook.com/'+id+'/picture';
                $('.welcome-msg')[0].insert('<img height="20" src="'+src+'"/>');
            });
        },
        login: function () {
            var self = this;
            document.location.href=self.options.fbLoginUrl;
            // document.cookie = "fbsr_" + self.options.fbAppId +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
            // var settings = {
            //     "url": urlBuilder.build("socialsignup/facebook/loginajax"),
            //     "method": "POST",
            //     "headers": {
            //     "accept": "application/json",
            //     "Content-Type": "application/json",
            //     },
            //     "processData": false,
            //     "mimeType": "multipart/form-data",
            //     showLoader: true,
            //     "contentType": false
            // };
            // let loginForm = $(".wk-step.customer-from .wk-step-body").find(".block-customer-login");
            // $.ajax(settings).done(function (response) {
            //     $('body').trigger('processStop');
            //     window.scrollTo(0, 0);
            //     response = JSON.parse(response);
            //     if (response.errors == false) {
            //         loginForm.find("input[name='is_social']").val(1).trigger("change");
            //     } else if (data.errors == true) {
            //         loginForm.find(".wk-error-box .err-msg").html(response.message);
            //         loginForm.find(".wk-error-box").show();
            //     } else {
            //         loginForm.find(".wk-error-box .err-msg").html($.mage.__('Something went wrong, please try again later'));
            //         loginForm.find(".wk-error-box").show();
            //     }
            // });
        },
        fblogin: function () {
            var self = this;
            FB.login(function (response) {
                if (response.status == 'connected') {
                    self.login();
                } else {
                    // user is not logged in
                    window.location.reload();
                }
            }, {scope:'email'});
            return false;
        }
    });
    return $.mage.fbBlockPlugin;
});
