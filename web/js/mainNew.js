// @codekit-prepend "vendor/jquery-1.10.2.js"
// @codekit-prepend "vendor/jquery-dateFormat.js"
// @codekit-prepend "vendor/modernizr.js"
// @codekit-append "vendor/handlebars-v1.3.0.js"
// @codekit-append "vendor/stupidtable.js"
// @codekit-append "formNew.js"
// @codekit-append "_scroll.js"
// @codekit-append "_slider.js"
// @codekit-append "advanced/_celebrations.js"

$(document).ready(function () {

    $("body").scrollTop(0);

    window.nav = {};

    nav.rubanVisible = false;
    nav.navVisible = false;
    nav.paramVisible = false;
    nav.rubanProcess = false;

    window.intervalMessage = 0;

    $("header").on('click', '#get_ruban', function (event) {
        event.preventDefault();
        toggleRuban();
    });

    $("header").on('click', '#get_nav', function (event) {
        event.preventDefault();
        toggleNav();
    });

    $('header').on('click', '#get_param', function(event) {
        event.preventDefault();
        event.stopPropagation();
        toggleParam();
    });


    $("section.tab").on('click', 'nav.sub_nav a', function (event) {

        var sectionTab = $("section.tab");

        event.preventDefault();

        var id = $(this).attr("href");

        $(sectionTab).find("article.tab").removeClass("active");
        $(sectionTab).find("article.tab" + id).addClass("active");

        $(sectionTab).find("nav.sub_nav a").removeClass("current");
        $(this).addClass("current");

        if ($(sectionTab).hasClass("autoScroll")) {
            moveToAnchor(id);
        }

    });

    $("#page").on('click', 'a[data-link="moveTo"]', function (event) {
        event.preventDefault();

        moveToAnchor($(this).attr("href"));

    });

    $("#page").on('mouseover', 'nav.sub_nav a',function () {

        $("nav.sub_nav a").removeClass("focus");
        $(this).addClass("focus");

    }).on('mouseleave', 'nav.sub_nav', function () {

        $("nav.sub_nav a").removeClass("focus");
        $("nav.sub_nav a.current").addClass("focus");

    });

    $("#page").on('mouseover', 'nav.main ul.nav a',function () {

        $("nav.main a").removeClass("focus");
        $(this).addClass("focus");

    }).on('mouseleave', 'nav.main', function () {

        $("nav.main a").removeClass("focus");
        $("nav.main a.current").addClass("focus");

    });

    $("#page.admin").on('mouseover', 'h1.switch',function (event) {

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

});


function hideMessage() {

    $("#message").remove();

}


function errorMessage(message) {

    if($("#message").html() == message) {
        return;
    }

    intervalMessage = 0;

    $("#page > header").prepend('<section id="message" class="error">' + message + '</section>');

}


/**
 * toggleRuban
 */
function toggleRuban() {
    if (nav.rubanVisible) {
        closeRuban();
    } else {
        openRuban();
    }
}


/**
 * openRuban
 */
function openRuban() {
    if (!nav.rubanProcess) {
        nav.rubanVisible = true;
        nav.rubanProcess = true;
        $('#ruban_nav').show();

        var width = $('#ruban_nav').width();

        $('#page, .followRubanNav').animate({
            left: width,
            marginRight: width
        }, 200, function () {
            nav.rubanProcess = false;
        });

        $('#page > header').animate({
            left: width,
            marginRight: width
        }, 200);

        $('body').addClass("rubanOpen");
        //$('body').css('overflow', 'hidden');
    }
}


/**
 * closeRuban
 */
function closeRuban() {
    if (!nav.rubanProcess) {
        nav.rubanVisible = false;
        nav.rubanProcess = true;

        $('#page, .followRubanNav').animate({
            left: "0px",
            marginRight: "0px"
        }, 200, function () {
            $('#ruban_nav').hide();
            nav.rubanProcess = false;
        });

        $('#page > header').animate({
            left: "0px",
            marginRight: "0px"
        }, 200);

        $('body').removeClass("rubanOpen");
        //$('body').css('overflow', 'scroll');
    }
}


/**
 * toggleNav
 */
function toggleNav() {
    if (nav.navVisible) {
        closeNav();
    } else {
        openNav();
    }
}


/**
 * openNav
 */
function openNav() {

    nav.navVisible = true;

    $("#page").find("> header nav.main ul").addClass("actived");

    $("#get_nav").addClass("close");

    /*
     if(!nav.rubanProcess) {
     nav.rubanVisible = true;
     nav.rubanProcess = true;
     $('#ruban_nav').show();

     var width = $('#ruban_nav').width();

     $('#page').animate({
     left: width,
     marginRight: width
     }, 200, function() {
     nav.rubanProcess = false;
     });

     $('#page > header').animate({
     left: width,
     marginRight: width
     }, 200);

     $('body').addClass("rubanOpen");
     //$('body').css('overflow', 'hidden');
     }
     */
}


/**
 * closeNav
 */
function closeNav() {

    nav.navVisible = false;

    $("#page").find("> header nav.main ul").removeClass("actived");

    $("#get_nav").removeClass("close");

    /*
     if(!nav.rubanProcess) {
     nav.rubanVisible = false;
     nav.rubanProcess = true;

     $('#page').animate({
     left: "0px",
     marginRight: "0px"
     }, 200, function() {
     $('#ruban_nav').hide();
     nav.rubanProcess = false;
     });

     $('#page > header').animate({
     left: "0px",
     marginRight: "0px"
     }, 200);

     $('body').removeClass("rubanOpen");
     //$('body').css('overflow', 'scroll');
     }
     */
}


/**
 * moveToAnchor
 * @param id
 */
function moveToAnchor(id) {

    var elem = $(id);

    var pos = $(elem).position();

    var headerElem = $("#page").find("> header");

    if($("#page").hasClass("headerFixed")) {
        var pagePadTop = $("#page").css("padding-top");

        pagePadTop = pagePadTop.replace("px", "");
        pagePadTop = parseInt(pagePadTop);

        var headerH = pagePadTop;

    } else {

        var headerH = $(headerElem).height();

    }

    var top = pos.top + headerH + "px";

    $('html,body').animate({
        scrollTop: top
    }, 300);
}


/**
 * toggleParam
 */
function toggleParam() {
    if (nav.paramVisible) {
        closeParam();
    } else {
        openParam();
    }
}


/**
 * openParam
 */
function openParam() {
    nav.paramVisible = true;
    $('div.param_nav').addClass("actived");
}


/**
 * closeParam
 */
function closeParam() {
    nav.paramVisible = false;
    $('div.param_nav').removeClass("actived");
}