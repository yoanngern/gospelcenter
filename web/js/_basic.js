$(document).ready(function () {

    $("html").attr("data-platform", window.navigator.platform);



    var waitForFinalEvent = (function () {
        var timers = {};
        return function (callback, ms, uniqueId) {
            if (!uniqueId) {
                uniqueId = "Don't call this twice without a uniqueId";
            }
            if (timers[uniqueId]) {
                clearTimeout(timers[uniqueId]);
            }
            timers[uniqueId] = setTimeout(callback, ms);
        };
    })();


    $(window).resize(function () {
        waitForFinalEvent(function () {
            $(window).trigger("customResize");
            //...
        }, 500, "some unique string");
    });


});