define([
    'jquery',
    'underscore'
], function ($, _) {
    'use strict';
    return function(startState,endState, cloneFlag, cloneStartState, cloneEndState){
        this.execute =  function(element, imageHover, options){
            this.tempSrc = null;
            this.options = options;
            this.element = element;
            this.imageHover = imageHover;
            this.transition = this._getTransitionVal();
            this.cloneFlag = cloneFlag;
            this._validateInput(cloneFlag);
            this._getState();
            if(this.cloneFlag){
                this._getCloneState();
                this._createCloneElement();
            }
            this._getOriginalState();
            this._bindEventListener();
            this._initStartPos();
        };

        this._createCloneElement = function(){
            //Fix products viewmode list styles issues
            var CSS_FOR_LIST_MODE = {
                "z-index": "1",
                "position": "absolute",
                "top": "0",
                "left": "0",
                "opacity": "0"
            };
            this.cloneElement = this.element.clone().insertAfter(this.element).attr('src', this.imageHover).addClass("product-image-photo-hover");
            if(this.element.parents('.products.wrapper').hasClass('products-list')){
                this.cloneElement.css(CSS_FOR_LIST_MODE);
            }
        };

        this.destroy = function(){
            this._unbindEventListener();
            if(this.cloneFlag){
                this.cloneElement.remove();
            }
            this.element.css(this.originalState);
            this.options = null;
            this.imageHover = null;
            this.element = null;
        };

        this._mouseover = function(){
            this.element.css(this.endState);
            if(this.cloneFlag){
                this.cloneElement.css(this.cloneEndState);
            }
            else{
                this.tempSrc = this.element.attr('src');
                this.element.attr('src',this.imageHover);
            }
        };

        this._mouseout = function () {
            this.element.css(this.startState);
            if(this.cloneFlag){
                this.cloneElement.css(this.cloneStartState);
            }
            else{
                this.element.attr('src',this.tempSrc);
                this.tempSrc = null;
            }
        };

        this._initStartPos = function(){
            this.element.css(this.startState);
            if(this.cloneFlag){
                this.cloneElement.css(this.cloneStartState);
            }
        };

        this._bindEventListener = function(){
            var parent = this.element.parents(this.options.hoverElement);
            parent.on('mouseover.catalogImageHovering', $.proxy(this._mouseover,this));
            parent.on('mouseout.catalogImageHovering', $.proxy(this._mouseout, this));
        };

        this._unbindEventListener = function(){
            var parent = this.element.parents(this.options.hoverElement);
            parent.off('mouseover.catalogImageHovering');
            parent.off('mouseout.catalogImageHovering');
        };

        this._validateInput = function(cloneFlag){
            if(cloneFlag){
                this._validate([startState,endState,cloneStartState,cloneEndState]);
            }
            else{
                this._validate([startState,endState]);
            }
        };

        this._validate = function(input){
            var self = this;
            _.map(input,function(obj){
                if(_.isObject(obj) && !_.isArray(obj)){
                    self.startState = $.extend(true,{"transition": self.transition},startState);
                }
                else{
                    throw new Error('Input state must be object');
                }
            });
        };

        this._getOriginalState = function(){
            this.originalState = _.mapObject(this.startState, function() {
                return "";
            });
        };

        this._getTransitionVal = function(){
            return this.options.duration + "s " + this.options.easingFunction;
        };

        this._getState = function(){
            this.startState = $.extend(true,{"transition": this.transition},startState);
            this.endState = endState;
        };

        this._getCloneState = function(){
            this.cloneStartState = $.extend(true,{"transition": this.transition},cloneStartState);
            this.cloneEndState = cloneEndState;
        }
    };
});
