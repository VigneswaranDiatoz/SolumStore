define([
    'jquery',
    'slick'
], function ($,slick) {
    'use strict';

    $.widget('mage.themeslider',{
        _create: function() {
            var self = this;
            var Totaltime = $('.pagebuilder-slider').attr('data-autoplay-speed');
            var RequiredTimeGap = Math.ceil(parseFloat(Totaltime/100));
            if(Totaltime){
                $(".pagebuilder-slider")[0].style.setProperty("--autoplay-speed",Totaltime+"ms");
            }
            // $(".pagebuilder-slider").on("init", function (){
            //     const element = $('.slick-active').find('button');
            //     let width = 0;
            //     const id = setInterval(frame, RequiredTimeGap+2);
            //     function frame() {
            //         if (width == 100) {
            //             clearInterval(id);
            //             element.css('width',0 + '%');
            //         } else {
            //             width++; 
            //             element.css('width',width + '%'); 
            //         }
            //     }
            // });
            // $(".pagebuilder-slider").on("afterChange", function (){
            //     const element = $('.slick-active').find('button');
            //     let width = 0;
            //     const id = setInterval(frame, RequiredTimeGap);
            //     function frame() {
            //         if (width == 100) {
            //             clearInterval(id);
            //             element.css('width',0 + '%');
            //         } else {
            //             width++; 
            //             element.css('width',width + '%'); 
            //         }
            //     }
            // });
        }
    });

    return $.mage.themeslider;

});