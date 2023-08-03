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
    'mage/url',
    "jquery/ui",
    'mage/mage',
    'mage/calendar',
    "mage/adminhtml/wysiwyg/tiny_mce/setup"
], function ($, urlBuilder) {
    "use strict";
    $.widget('formBuilder.customFormRender', {

        _create: function () {
            $.each($('.wk_dob'), function (i, v) {
                $(this).calendar({ showsTime: false, dateFormat: "M/d/yy" });
            });
            self = this;

            $(document).ready(function ($) {

                var dataForm = $('#wk-form-id');
                dataForm.mage('validation', {});
                let tinyMiceFieldName = self.options.tinyMiceFieldName;
                let tinyMiceFieldRequired = self.options.tinyMiceFieldRequired;
                let maxlength = self.options.maxlength;

                if (self.options.recaptchaEnable && self.options.checkRecaptcha) {
                    grecaptcha.ready(function () {
                        grecaptcha.execute(self.options.siteKey, { action: 'form_builder' }).then(function (token) {
                            $("input[id=g-recaptcha-response]").val(token)
                        });
                    });
                }
                if (tinyMiceFieldRequired && tinyMiceFieldName != "" && tinyMiceFieldName != null) {
                    $('#save-btn').click(function (e) {
                        if ($('#' + tinyMiceFieldName + '_ifr').length) {
                            var desc = $('#' + tinyMiceFieldName + '_ifr').contents().find('body').text();
                            $('#' + tinyMiceFieldName + 'error').remove();
                            if (desc === "" || desc === null) {
                                $('#' + tinyMiceFieldName + 'error').remove();
                                $('#' + tinyMiceFieldName).parent().append('<div class="mage-error-formbuilder" generated="true" id="' + tinyMiceFieldName + 'error">This is a required field.</div>');
                            }
                            if (maxlength > 0) {
                                if (desc !== "" && desc !== null && desc.length >= maxlength) {
                                    $('#' + tinyMiceFieldName + 'error').remove();
                                    $('#' + tinyMiceFieldName).parent().append('<div class="mage-error-formbuilder" generated="true" id="' + tinyMiceFieldName + 'error">Maximun allowed character is: ' + maxlength + '</div>');
                                }

                                if (desc !== "" && desc !== null && desc.length <= maxlength) {
                                    $('#wk-form-id').submit();
                                } else {
                                    return false;
                                }
                            }

                            if (tinyMiceFieldRequired && desc !== "" && desc !== null) {
                                $('#wk-form-id').submit();
                            } else {
                                return false;
                            }
                        }
                    });
                }

                if (tinyMiceFieldName != "" && tinyMiceFieldName != null) {
                    $('#save-btn').click(function (e) {
                        if ($('#' + tinyMiceFieldName + '_ifr').length) {
                            var desc = $('#' + tinyMiceFieldName + '_ifr').contents().find('body').text();
                            if (maxlength > 0) {
                                if (desc !== "" && desc !== null && desc.length >= maxlength) {
                                    $('#' + tinyMiceFieldName + 'error').remove();
                                    $('#' + tinyMiceFieldName).parent().append('<div class="mage-error-formbuilder" generated="true" id="' + tinyMiceFieldName + 'error">Maximun allowed character is: ' + maxlength + '</div>');
                                }
                                if (tinyMiceFieldRequired == "" && desc.length <= maxlength) {
                                    $('#wk-form-id').submit();
                                } else {
                                    return false;
                                }
                            }
                        }
                    });
                }

                $('#wk-form-id').submit(function (event) {
                    event.preventDefault();
                    var status = dataForm.validation('isValid');
                    if (status) {
                        $.ajax({
                            type: $(this).attr("method"),
                            url: $(this).attr("action"),
                            data: $(this).serialize(),
                            showLoader: true,
                        }).done(function (response) {
                            $('body').trigger('processStop');
                            $(".wk-rfq-modal .modal-title").hide();
                            $(".wk-rfq-modal .wk-step.current").removeClass("current");
                            $(".wk-rfq-modal .wk-step.last-step").addClass("current");
                            $(".wk-rfq-modal .wk-step.last-step").find(".study-row").html(response.caseStudyHtml);
                        });
                    }
                });

                // Restrict to let only enter numbers
                $('body').on('keypress', "#wk-form-id input[type=number]", function (event) {
                    if (event.which != 8 && event.which != 0 && event.which < 48 || event.which > 57) {
                        event.preventDefault();
                    }
                });
            });
        }
    });
    return $.formBuilder.customFormRender;
});
