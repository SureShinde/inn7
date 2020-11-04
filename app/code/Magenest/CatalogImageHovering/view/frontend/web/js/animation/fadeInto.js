define([
    'jquery',
    'prototype'
], function ($, prototype) {
    'use strict';
    var originalElementPositionStart = {
        "opacity": "1"
    };
    var originalElementPositionEnd = {
        "opacity": "0"
    };
    var cloneElementPositionStart = {
        "opacity": "0"
    };
    var cloneElementPositionEnd = {
        "opacity": "1"
    };
    var fadeInto = new prototype(originalElementPositionStart,originalElementPositionEnd,1,cloneElementPositionStart,cloneElementPositionEnd);

    return fadeInto;
});
