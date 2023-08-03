/**
 * Webkul Software
 *
 * @category  Webkul
 * @package   Webkul_FormBuilder
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
/*jshint browser:true jquery:true*/
/*global alert*/
define(
    [
    'jquery',
    'ko',
    'uiComponent',
    'Magento_Ui/js/modal/alert',
    'FormBuilder',
    "jquery/ui"
    ],
    function ($, ko, Component, alert) {
        'use strict';

        return Component.extend(
            {
                defaults: {
                    template: 'Webkul_FormBuilder/steps',
                    selectedStep: 0,
                    totalSteps: 0,
                    steps: [],
                    allowForm: true,
                    stepsFormData: [],
                },
                initObservable: function () {
                    this._super()
                    .observe(
                        [
                            'selectedStep',
                            'totalSteps',
                            'steps',
                            'stepsFormData',
                        ]
                    );

                    return this;
                },
                initialize: function () {
                    var self = this;
                    this._super();
                    self.addSteps(self.data);
                    document.getElementById("savedata").addEventListener("click", function (e) {
                        e.preventDefault();
                        var maxlength = $('[name ="maxlength"]');
                        if(maxlength){
                            $('[name ="maxlength"]').removeClass("validate-email");
                        }
                        let formTitle = $("#form_title").val();
                        if(formTitle == ""){
                            alert($.mage.__("Please Enter the Form Name"));
                        } else {
                            $('body').trigger('processStart');
                            $("#forms_fields").val();
                            var formData = [];
                            self.steps().forEach(formBuilder => {
                                let formBuilderObj = formBuilder.formObj;
                                formData[formBuilder.id] = {};
                                if (formBuilderObj != undefined) {
                                    formData[formBuilder.id].stepName = $("input[name='steps["+formBuilder.id+"]']").val();
                                    formData[formBuilder.id].data = formBuilderObj.actions.getData('json', true);
                                } else {
                                    formData[formBuilder.id].stepName = $("input[name='steps["+formBuilder.id+"]']").val();
                                    formData[formBuilder.id].data = formBuilder.formData;
                                }
                            });
                            $("#forms_fields").val(JSON.stringify(formData));
                            $("#custom-form").submit();
                        }
                        
                    });
                },
                addSteps: function(stepData) {
                    var self = this;
                    $.each(stepData, function( index, step ) {
                        self.addNewStepWithData(step);
                    });
                },
                getSteps: function () {
                    return this.steps;
                },
                showCurrentstep: function (step, event) {
                    var self = this;
                    self.hideAllSteps();
                    self.selectedStep(step.id);
                    step.current(true);
                    self.bindEditor(step);
                },
                deleteCurrentStep:  function (step, event) {
                    var self = this;
                    if (self.totalSteps() > 1) {
                        self.totalSteps(self.totalSteps()-1);
                        self.hideAllSteps();
                        self.steps.remove(step);
                        self.showFirstStep();
                    }
                },
                addNewStep: function () {
                    var self = this, step = [];
                    self.hideAllSteps();
                    self.totalSteps(1+self.totalSteps());
                    step.id = self.totalSteps();
                    self.selectedStep(step.id);
                    step.current = ko.observable(true);
                    self.steps.push(step);
                    self.bindEditor(step);
                },
                addNewStepWithData: function (stepData) {
                    var self = this, step = [];
                    self.totalSteps(1+self.totalSteps());
                    step.id = self.totalSteps();
                    step.formData = stepData.data;
                    step.stepName = stepData.stepName;
                    self.selectedStep(step.id);
                    step.current = ko.observable(false);
                    step.isEditorBind = false;
                    self.steps.push(step);
                },
                showFirstStep: function () {
                    var step = this.steps()[0];
                    step.current(true);
                    this.bindEditor(step);
                },
                hideAllSteps: function () {
                    var self = this;
                    self.steps().forEach(oldStep => {
                        oldStep.current(false);
                    });
                },
                bindEditor: function (step) {
                    var self = this;
                    let deferred = $.Deferred();
                    let fbTemplate = "#wk-fb-editor"+step.id , currentStep = step;
                    if (currentStep.isEditorBind != undefined && currentStep.isEditorBind) {
                        return;
                    }
                    step.isEditorBind = true;
                    let options = {
                        disabledAttrs: ["access","other","toggle","inline"],
                        disableFields: ['autocomplete','button','header','hidden','paragraph'],
                        disabledActionButtons: ['data','save','clear'],
                        controlPosition: 'left',
                        i18n: {
                            locale: self.locale
                        },
                        fieldRemoveWarn: true,
                        fields: [{
                            label: 'Categories',
                            attrs: {
                                type: 'category'
                            },
                            icon: '🌟'
                        }],
                        templates: {
                            category: function(fieldData) {
                              return {
                                field: '<span id="'+fieldData.name+'">',
                                onRender: function() {
                                    $("#"+fieldData.id).html("<span>This step contains a hidden step to select seller(s)</span>");
                                }
                              };
                            }
                        },
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
                            },
                            "radio-group": {
                                renderType: {
                                    label: 'Type',
                                    multiple: false,
                                    options: {
                                        0: 'Normal',
                                        1: 'Accordion'
                                    },
                                },
                                openAccord: {
                                    label: 'Show Fields In case of Type is Accordion',
                                    multiple: false,
                                    options: {
                                        0: 'No',
                                        1: 'Yes'
                                    },
                                }
                            },
                            category: {
                                value: {
                                    label: 'Category Ids',
                                    value: "",
                                    placeholder: 'Category Ids seprated by comma(,)'
                                },
                                seller: {
                                    label: 'Show Seller',
                                    multiple: false,
                                    options: {
                                        0: 'All',
                                        1: 'Category-wise'
                                    },
                                }
                            }
                        },
                        inputSets: [{
                            label: 'Business Industry Set',
                            name: 'industry-business',
                            showHeader: false,
                            fields: self.industryBusinessData
                        }],
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
                        formData: (currentStep.formData != undefined) ? JSON.parse(currentStep.formData) : []
                    };
                    $(fbTemplate).formBuilder(options).promise.then(formBuilder => {
                        deferred.resolve(formBuilder, currentStep);
                    });
                    deferred.promise().then(
                        function (formBuilder, currentStep) {
                            currentStep.formObj = formBuilder;
                        }
                    );
                }
            }
        )
    }
);