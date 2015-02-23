// @codekit-prepend "vendor/jquery-1.10.2.js"
// @codekit-prepend "vendor/jquery-dateFormat.js"
// @codekit-prepend "vendor/jquery.svgmagic.js"
// @codekit-prepend "vendor/jquery.corner.js"
// @codekit-prepend "vendor/jquery.placeholder.js"
// @codekit-prepend "vendor/modernizr.js"
// @codekit-prepend "_basic.js"
// @codekit-append "vendor/handlebars-v1.3.0.js"
// @codekit-append "vendor/stupidtable.js"
// @codekit-append "_formNew.js"
// @codekit-append "_scroll.js"
// @codekit-append "_slider.js"
// @codekit-append "_image.js"
// @codekit-prepend "_nav.js"

$(document).ready(function () {

    window.intervalMessage = 0;

    $("#page").on('click', 'a[data-link="moveTo"]', function (event) {
        event.preventDefault();

        moveToAnchor($(this).attr("href"));

    });

    $("#page").on('mouseover', 'nav.main ul.nav a', function () {

        $("nav.main a").removeClass("focus");
        $(this).addClass("focus");

    }).on('mouseleave', 'nav.main', function () {

        $("nav.main a").removeClass("focus");
        $("nav.main a.current").addClass("focus");

    });

    $("#page.admin").on('mouseover', 'h1.switch', function (event) {

        $("ul.adminTitle").addClass("active");

    }).on('mouseleave', '#container header', function (event) {

        $("ul.adminTitle").removeClass("active");

    });

    $("table.main").stupidtable();


    setInterval(function () {

        if ($("#message").length) {
            intervalMessage++;
        }

        if (intervalMessage == 2) {
            hideMessage();
        }

    }, 1000);

    $('img').svgmagic();

    $('input, textarea').placeholder();

    $(".radius").each(function () {

        var val = 0;

        if ($(this).hasClass("round")) {
            var width = $(this).css("width");
            width = width.replace("px", "");
            parseInt(width);
            val = width / 2;

            val = val + "px";
        } else {
            val = $(this).css("border-top-left-radius");
        }

        console.log(val);

        $(this).corner(val);

    });


});


/**
 * hideMessage()
 */
function hideMessage() {

    $("#message").remove();

}


/**
 * errorMessage()
 * @param message
 */
function errorMessage(message) {

    if ($("#message").html() == message) {
        return;
    }

    intervalMessage = 0;

    $("#page > header").prepend('<section id="message" class="error">' + message + '</section>');

}


/**
 * moveToAnchor
 * @param id
 */
function moveToAnchor(id) {

    var elem = $(id);

    var pos = $(elem).position();

    console.log(elem);

    var headerElem = $("#page").find("> header");

    if ($("#page").hasClass("headerFixed")) {
        var pagePadTop = $("#page").css("padding-top");

        console.log(pagePadTop);

        pagePadTop = pagePadTop.replace("px", "");
        pagePadTop = parseInt(pagePadTop);

        var headerH = pagePadTop;

    } else {

        var headerH = $(headerElem).height();

    }

    var top = pos.top + headerH + 20 + "px";

    $('html,body').animate({
        scrollTop: top
    }, 300);
}


