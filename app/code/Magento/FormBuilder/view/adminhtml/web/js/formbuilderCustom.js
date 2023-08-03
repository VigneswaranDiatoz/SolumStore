/**
 * @author Webkul Software Private Limited
 */

define([
    "jquery",
    "jquery/ui",
    'FormBuilder',
    'mage/translate'
], function($) {
    "use strict";
    $.widget('formBuilder.formbuilderCustom', {
        _create: function() {
            self = this;
            if(!window.$){
                var fbTemplate = document.getElementById('fb-editor');
                var options = {
                    disabledAttrs: ["access","other","multiple","toggle","inline"],
                    disableFields: ['autocomplete','button','header','hidden','paragraph'],
                    disabledActionButtons: ['data','save','clear'],
                    controlPosition: 'left',
                    i18n: {
                        locale: self.options.locale
                    },
                    fieldRemoveWarn: true,
                    typeUserAttrs: {
                        text: {
                            className: {
                                label: 'Validation',
                                options: {
                                '': '',
                                'validate-number form-control': 'validate-number',
                                'validate-email form-control': 'validate-email',
                                'validate-not-negative-number form-control' :'validate-not-negative-number',
                                'validate-zero-or-greater form-control' :'validate-zero-or-greater',
                                'validate-greater-than-zero form-control' :'validate-greater-than-zero',
                                'validate-digits form-control' :'validate-digits',
                                }
                            }
                        }
                    },
                    disabledSubtypes: {
                        file: ['fineuploader'],
                        textarea:['quill'],
                        text:['color']
                    },
                    notify: {
                        error: function(message) {
                         console.error(message);
                        },
                        success: function(message) {
                           console.log(message);
                        },
                        warning: function(message) {
                           console.warn(message);
                        }
                      },
                    defaultFields: self.options.data
                };
        
                const formBuilder = $(fbTemplate).formBuilder(options);
        
                $('ul.tabs li').click(function(){
                    var tab_id = $(this).attr('data-tab');
        
                    $('ul.tabs li').removeClass('current');
                    $('.tab-content').removeClass('current');
        
                    $(this).addClass('current');
                    $("#"+tab_id).addClass('current');
                });

                document.getElementById('clear-all-fields').onclick = function() {
                    formBuilder.actions.clearFields();
                }
                

                document.getElementById("save-and-continue-edit").addEventListener("click", function (e) {
                    e.preventDefault();
                    $("#custom-form").append('<input type="hidden" name="continue" value="continue">');
                    $('#savedata').trigger('click');
                });
                
                $('.input-text').change(function () {
                    var validt = $(this).val();
                    if(validt.match(/([\<])([^\>]{1,})*([\>])/i)!=null)
                    {
                         alert("Contains HTML Tag");
                         $(this).val("");
                    }
                     
                });

                
                // document.getElementById("savedata").addEventListener("click", function (e) {
                //     e.preventDefault();
                //     var maxlength = $('[name ="maxlength"]');
                //     if(maxlength){
                //         $('[name ="maxlength"]').removeClass("validate-email");
                //     }
                //     let formTitle = $("#form_title").val();
                //     if(formTitle == ""){
                //        alert($.mage.__("Please Enter the Form Name"));
                //     }else{
                //         $('body').trigger('processStart');
                //         $("#forms_fields").val();
                //         var json = formBuilder.actions.getData('json', true);
                //         $("#forms_fields").val((json));
                //         // return formBuilder.actions.save();
                         
                //         $(this).submit();
                //     }
                    
                // });
            }
        }
    });
    return $.formBuilder.formbuilderCustom;
});