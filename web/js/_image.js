window.connection = "good";

window.responsive = {
    device: "desktop"
};

$(document).ready(function () {

    resize();
    initImg();

    /**
     * window is resised
     */
    $(window).resize(function () {
        resize();
    });

    $(responsive).on("deviceChange", function (device) {
        initImg();
    });


});

function initImg() {
    $("[data-bg]").each(function () {

        if (connection != "low") {
            initImageBg(this);
        }
    });

    $("[data-img]").each(function () {

        if (connection != "low") {
            initImageImg(this);
        }
    });
}

$.ajaxSetup({
    timeout: 1, // Microseconds, for the laughs.  Guaranteed timeout.
    error: function (request, status, maybe_an_exception_object) {
        if (status == 'timeout')
            connection = "low";
    }
});

function resize() {
    var windowW = $(window).width();

    var oldDevice = responsive.device;

    if (windowW > 1024) {
        responsive.device = "desktop";
    }

    if (windowW <= 1024 && windowW > 640) {
        responsive.device = "tablet";
    }

    if (windowW <= 640) {
        responsive.device = "mobile";
    }

    if(oldDevice != responsive.device) {

        $(responsive).trigger("deviceChange", responsive.device);
    }
}


function isHighDensity() {
    return ((window.matchMedia && (window.matchMedia('only screen and (min-resolution: 124dpi), only screen and (min-resolution: 1.3dppx), only screen and (min-resolution: 48.8dpcm)').matches || window.matchMedia('only screen and (-webkit-min-device-pixel-ratio: 1.3), only screen and (-o-min-device-pixel-ratio: 2.6/2), only screen and (min--moz-device-pixel-ratio: 1.3), only screen and (min-device-pixel-ratio: 1.3)').matches)) || (window.devicePixelRatio && window.devicePixelRatio > 1.3));
}


function initImageBg(elem) {

    var src = $(elem).attr("data-bg");
    var src_2x = $(elem).attr("data-bg_2x");

    var src_tablet = $(elem).attr("data-bg_tablet");
    var src_tablet_2x = $(elem).attr("data-bg_tablet_2x");

    var src_mobile = $(elem).attr("data-bg_mobile");
    var src_mobile_2x = $(elem).attr("data-bg_mobile_2x");

    if (isHighDensity() && src_2x != "") {
        src = src_2x;
    }

    // Tablet device ?
    if (responsive.device == "tablet") {

        if (isHighDensity() && src_tablet_2x != "") {
            src = src_tablet_2x;
        } else {
            src = src_tablet;
        }
    }

    if (responsive.device == "mobile") {
        if (isHighDensity() && src_mobile_2x != "") {
            src = src_mobile_2x;
        } else {
            src = src_mobile;
        }
    }

    var bg_url = "url('" + src + "')";

    $(elem).css("background-image", bg_url);

}

function initImageImg(elem) {
    var srcset = "";

    var src = $(elem).attr("data-img");
    var src_2x = $(elem).attr("data-img_2x");

    var src_tablet = $(elem).attr("data-img_tablet");
    var src_tablet_2x = $(elem).attr("data-img_tablet_2x");

    var src_mobile = $(elem).attr("data-img_mobile");
    var src_mobile_2x = $(elem).attr("data-img_mobile_2x");

    if (isHighDensity() && src_2x != "") {
        srcset = src_2x;
    }

    // Tablet device ?
    if (responsive.device == "tablet") {

        if (isHighDensity() && src_tablet_2x != "") {
            srcset = src_tablet_2x;
            src = src_tablet;
        } else {
            src = src_tablet;
        }
    }

    if (responsive.device == "mobile") {
        if (isHighDensity() && src_mobile_2x != "") {
            srcset = src_mobile_2x;
            src = src_mobile;
        } else {
            src = src_mobile;
        }
    }


    $(elem).attr("src", src);

    if (srcset != "") {
        $(elem).attr("srcset", srcset + " 2x");
    }
}