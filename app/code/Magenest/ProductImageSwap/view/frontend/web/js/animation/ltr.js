define([
    'jquery',
    'prototype'
], function ($, prototype) {
    'use strict';
    var originalElementPositionStart = {
        "opacity": "1",
        "transform": "translateX(0%)"
    };
    var originalElementPositionEnd = {
        "opacity": "0",
        "transform": "translateX(100%)"
    };
    var cloneElementPositionStart = {
        "opacity": "0",
        "transform": "translateX(-100%)"
    };
    var cloneElementPositionEnd = {
        "opacity": "1",
        "transform": "translateX(0)"
    };
    var ltr = new prototype(originalElementPositionStart,originalElementPositionEnd,1,cloneElementPositionStart,cloneElementPositionEnd);

    return ltr;
});
