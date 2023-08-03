define([
    'jquery',
    'jquery/ui',
 ], function ($) {
    'use strict';
 
    $.widget('mage.navigationmenu', {
        options: {
            container: '.navigation'
        },
        _create: function() {
            var topmenu = this.element.find('.top-menu');
            this.appendHover(topmenu);
            var menuContainer = this.options.container;
            $(menuContainer).on("mouseleave", function (){
                $(menuContainer).find('.active').removeClass('active');
            });
            this.appendIcon(this.element);
        },
        appendHover: function(topmenu) {
            var self = this;
            $.each(topmenu, function(index, menu){
                if (menu.localName === 'li') {
                    $(menu).on('mouseenter', function(event){
                        event.stopPropagation();
                        self.clearClass($(this))
                        var contentDiv = $(this).children().eq(1);
                        contentDiv.addClass('active')
                        contentDiv.children().addClass('active')
                        var ulContent = contentDiv.find('ul:first')
                        ulContent.addClass('active')
                        self.checkChildMenu(ulContent);
                    });
                }
            });
            
        },
        checkChildMenu: function(ulcontent) {
            var self = this;
            var lidata = ulcontent.children();
            if (lidata.length) {
                self.appendHover(lidata)
            }
        },
        clearClass: function(element) {
            
            element.parent().find('.active').removeClass('active');
        },
        appendIcon : function(element) {
            var subMenu = element.find('.sub-menu-content');
            $.each(subMenu, function(index, menu) {
                $(menu).prev().append('<span class="arrow-icon"></span>');
            });
            
        }
    });
    return $.mage.navigationmenu;
});