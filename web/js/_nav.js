$(document).ready(function () {

    $("body").scrollTop(0);

    window.nav = {};

    nav.rubanVisible = false;
    nav.navVisible = false;
    nav.paramVisible = false;
    nav.rubanProcess = false;
    nav.langVisible = false;

    $("header").on('click', '#get_ruban', function (event) {
        event.preventDefault();
        toggleRuban();

    }).on('click', '#get_nav', function (event) {
        event.preventDefault();
        toggleNav();

    }).on('click', '#get_param', function(event) {
        event.preventDefault();
        event.stopPropagation();
        toggleParam();
    });

    $('footer').on('click', '#get_lang', function(event) {
        event.preventDefault();
        event.stopPropagation();
        toggleLanguage();
    });

    $(document).on('mouseover', 'nav.sub_nav a',function () {

        var navElem = $(this).parent().parent().parent();

        $("a", navElem).removeClass("focus");
        $(this).addClass("focus");

    }).on('mouseleave', 'nav.sub_nav', function () {

        var navElem = $(this).parent().parent().parent();

        $("a", navElem).removeClass("focus");
        $("a.current", navElem).addClass("focus");

    });

    $(document).on('click', 'section.tab nav.sub_nav a', function (event) {

        var sectionTab = $(this).parent().parent().parent().parent();

        event.preventDefault();

        var id = $(this).attr("href");

        $(sectionTab).find("> article.tab").removeClass("active");
        $(sectionTab).find("> article.tab" + id).addClass("active");

        $(sectionTab).find("> nav.sub_nav a").removeClass("current");
        $(this).addClass("current");

        if ($(sectionTab).hasClass("autoScroll")) {

            var elemParent = $(id).parent();

            moveToAnchor(elemParent);
        }

    });


});



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
}


/**
 * closeNav
 */
function closeNav() {

    nav.navVisible = false;

    $("#page").find("> header nav.main ul").removeClass("actived");

    $("#get_nav").removeClass("close");
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

/**
 * toggleLanguage
 */
function toggleLanguage() {
    if (nav.langVisible) {
        closeLanguage();
    } else {
        openLanguage();
    }
}


/**
 * openLanguage
 */
function openLanguage() {
    nav.langVisible = true;
    $('div.lang-nav').addClass("actived");
}


/**
 * closeLanguage
 */
function closeLanguage() {
    nav.langVisible = false;
    $('div.lang-nav').removeClass("actived");
}