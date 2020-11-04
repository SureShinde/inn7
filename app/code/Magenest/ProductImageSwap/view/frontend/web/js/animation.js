define([
    'jquery',
    'immediate',
    'fadeInto',
    'ltr',
    'rtl',
    'ttb',
    'btt',
    '!domReady',
    'matchMedia'
], function ($, immediate, fadeInto, ltr, rtl, ttb, btt) {
    'use strict';

    $.widget('catalogImageHovering.animation', {

        options: {
            animationType: 'immediate',
            duration: 0.3,
            easingFunction: 'ease-in-out',
            //Hover Element must be parent of the pictures
            // mustnot be .product-image-wrapper and the .product-image-photo itself
            // recommend .product-image-container (for image hover) or .product-item-info (for product wrapper hover)
            hoverElement: '.product-image-container'
        },
        imageHover: null,
        animationObj: {},
        instantiated: false,

        /** @inheritdoc */
        _create: function () {

            if (!this.instantiated && window.innerWidth > 768) {
                this._bind();
            }
            this._onResize();
        },

        _bind: function () {
            this.imageHover = $(this.element).attr('data-catalog_image_hovering');
            if(!this.imageHover){
                return false;
            }
            switch (this.options.animationType) {
                case 'immediate':
                    this.animationObj = $.extend(true,{},immediate);
                    break;
                case 'fade_into':
                    this.animationObj = $.extend(true,{},fadeInto);
                    break;
                case 'left_to_right':
                    this.animationObj = $.extend(true,{},ltr);
                    break;
                case 'right_to_left':
                    this.animationObj = $.extend(true,{},rtl);
                    break;
                case 'top_to_bottom':
                    this.animationObj = $.extend(true,{},ttb);
                    break;
                case 'bottom_to_top':
                    this.animationObj = $.extend(true,{},btt);
                    break;
            }
            this.animationObj.execute(this.element, this.imageHover, this.options);
            this.instantiated = true;
        },

        _unbind: function(){
            this.animationObj.destroy(this.element);
            this.animationObj = {};
            this.imageHover = null;
            this.instantiated = false;
        },

        _onResize: function(){
            if(this.imageHover){
                var self = this;
                $(window).on('resize', function(e){
                    // Check whether event is triggered by code
                    if(typeof(e.originalEvent) === "undefined"){
                        return false;
                    }
                    // Remove on mobile
                    if(window.innerWidth <= 768 && self.instantiated){
                        self._unbind();
                    }
                    // Reinit on desktop
                    else if (window.innerWidth > 768 && !self.instantiated){
                        self._bind();
                    }
                });
            }
        }
    });

    return $.catalogImageHovering.animation;
});
