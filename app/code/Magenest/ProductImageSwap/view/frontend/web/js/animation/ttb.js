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
        "transform": "translateY(100%)"
    };
    var cloneElementPositionStart = {
        "opacity": "0",
        "transform": "translateY(-100%)"
    };
    var cloneElementPositionEnd = {
        "opacity": "1",
        "transform": "translateY(0)"
    };
    var btt = new prototype(originalElementPositionStart,originalElementPositionEnd,1,cloneElementPositionStart,cloneElementPositionEnd);

    return btt;
});
