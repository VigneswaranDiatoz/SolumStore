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
], function ($, urlBuilder,$t) {
    'use strict';
    $.widget('mage.passwordValidate', {
        _create: function () {
            var self = this;
            
            var vali_input = document.getElementById("password");
            var vali_letter = document.getElementById("message_lower");
            var vali_capital = document.getElementById("message_upper");
            var vali_number = document.getElementById("message_number");
            var vali_length = document.getElementById("message_length");
            var vali_spec = document.getElementById("message_special");

            // When the user clicks on the password field, show the message box
            vali_input.onfocus = function () {
                document.getElementById("elepop").style.display = "block";
            }

            // When the user clicks outside of the password field, hide the message box
            vali_input.onblur = function () {
                document.getElementById("elepop").style.display = "none";
            }

            // When the user starts to type something inside the password field
            vali_input.onkeyup = function () {
                // Validate lowercase letters
                var lowerCaseLetters = /[a-z]/;
                if (vali_input.value.match(lowerCaseLetters)) {
                    vali_letter.classList.remove("invalid");
                    vali_letter.classList.add("valid");
                } else {
                    vali_letter.classList.remove("valid");
                    vali_letter.classList.add("invalid");
                }

                // Validate capital letters
                var upperCaseLetters = /[A-Z]/;
                if (vali_input.value.match(upperCaseLetters)) {
                    vali_capital.classList.remove("invalid");
                    vali_capital.classList.add("valid");
                } else {
                    vali_capital.classList.remove("valid");
                    vali_capital.classList.add("invalid");
                }

                // Validate numbers
                var numbers = /[0-9]/;
                if (vali_input.value.match(numbers)) {
                    vali_number.classList.remove("invalid");
                    vali_number.classList.add("valid");
                } else {
                    vali_number.classList.remove("valid");
                    vali_number.classList.add("invalid");
                }

                // Validate length
                if (vali_input.value.length >= 8) {
                    vali_length.classList.remove("invalid");
                    vali_length.classList.add("valid");
                } else {
                    vali_length.classList.remove("valid");
                    vali_length.classList.add("invalid");
                }

                // Special length
                var paswd = /(?=.*[!@#$%^&*.])/;
                if (vali_input.value.match(paswd)) {

                    vali_spec.classList.remove("invalid");
                    vali_spec.classList.add("valid");
                } else {
                    vali_spec.classList.remove("valid");
                    vali_spec.classList.add("invalid");
                }

                let bar_vali = document.querySelectorAll(".valid").length;
                let bar_line = document.querySelector(".line");
                var final_per = (bar_vali * 100) / 5;

                let txt = document.querySelector(".txt");


                switch (bar_vali) {
                    case 1:
                        bar_line.style.backgroundImage = "linear-gradient(to right, red " + final_per +
                            "%, lightgray 0%)";
                        txt.innerHTML = $t('Easy')
                        break;
                    case 2:
                        bar_line.style.backgroundImage = "linear-gradient(to right, tomato " + final_per +
                            "%, lightgray 0%)";
                        txt.innerHTML = $t('Easy')
                        break;
                    case 3:
                        bar_line.style.backgroundImage = "linear-gradient(to right, Orange " + final_per +
                            "%, lightgray 0%)";
                        txt.innerHTML = $t('Easy')
                        break;
                    case 4:
                        bar_line.style.backgroundImage = "linear-gradient(to right, MediumSeaGreen " + final_per +
                            "%, lightgray 0%)";
                        txt.innerHTML = $t('Normal')
                        break;
                    case 5:
                        bar_line.style.backgroundImage = "linear-gradient(to right, green " + final_per +
                            "%, lightgray 0%)";
                        txt.innerHTML = $t('Hard')
                        break;
                }

            }
        }
    });
    return $.mage.passwordValidate;
});
