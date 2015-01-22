// @codekit-prepend "vendor/jquery-1.10.2.js"
// @codekit-prepend "vendor/modernizr.js"
// @codekit-prepend "vendor/jquery.easing.1.3.js"
// @codekit-prepend "_basic.js"
// @codekit-prepend "vendor/jquery.mousewheel.js"
// @codekit-prepend "_nav.js"
// @codekit-append "vendor/handlebars-v1.3.0.js"
// @codekit-append "_slider.js"
// @codekit-append "_image.js"


var moveScroll = false;

$(document).ready(function () {

    window.intervalScreen = 0;

    $("#page").on('click', 'ul.nav a', function (event) {
        event.preventDefault();

        closeRuban();
        closeNav();

        var id = $(this).attr("data-link");

        moveToScreen(id);

        $("ul.nav a").removeClass("current");
        $(this).addClass("current");

    });

    var startPage = $("#page").attr("data-startPage");

    moveToScreen("#" + startPage);

    setInterval(function () {

        if (intervalScreen == 0) {
            moveScroll = false;
            intervalScreen++;
        }

    }, 1200);


    $("article.screen#home").on('mouseenter', '.arrow', function () {
        $(this).animate({
            bottom: '2%'
        }, 500, 'easeOutElastic');
    });

    $("article.screen#home").on('mouseout', '.arrow', function () {
        $(this).animate({
            bottom: '3%'
        }, 500, 'easeOutElastic');
    });

    $(document).on("click", "#goDown", function (e) {
        e.preventDefault();
        moveToScreen("#celebrations");
    });
});


/**
 * Resize event
 */
$(window).on("customResize", function (event) {

    var id = $("article.screen.current").attr("id");

    console.log(id);

    goToScreen("#" + id);

});


/**
 * Key down event
 */
$(document).on('keydown', function (e) {

    if (nav.rubanVisible) {
        e.preventDefault();
        return;
    }

    var keyCode = e.keyCode || e.which,
        arrow = {left: 37, up: 38, right: 39, down: 40};

    if (keyCode === arrow.up || keyCode === arrow.left) {
        e.preventDefault();
        $(document).trigger("screenScroll", "up");

    } else if (keyCode === arrow.down || keyCode === arrow.right) {
        e.preventDefault();
        $(document).trigger("screenScroll", "down");
    }
});


/**
 * Mouse wheel event
 */
$('html').bind('mousewheel', function (event) {
    event.preventDefault();

    if (nav.rubanVisible) {
        return;
    }

    if (event.deltaY > 2) {
        $(document).trigger("screenScroll", "up");
    } else if (event.deltaY < -2) {
        $(document).trigger("screenScroll", "down");
    }

    if (event.deltaX > 2) {
        $(document).trigger("screenScroll", "right");
    } else if (event.deltaX < -2) {
        $(document).trigger("screenScroll", "left");
    }
});


/**
 * Scroll event
 */
$(document).on('screenScroll', function (event, direction) {

    if (moveScroll) {
        return;
    } else {
        moveScroll = true;
    }

    intervalScreen = 0;

    var current = $("#container > article.screen.current");

    var id = "home";

    if (direction == "up") {
        var next = $(current).prev();

        if (next.length == 0) {
            return;
        }

        id = $(next).attr("id");

    } else if (direction == "down") {
        next = $(current).next();

        if (next.length == 0) {
            return;
        }

        id = $(next).attr("id");
    }

    moveToScreen("#" + id);


});


/**
 * moveToScreen
 * @param id
 */
function moveToScreen(id) {

    var elem = $(id);

    loadPage($(elem).attr("id"));

    $("#container > article.screen").removeClass("current");
    $(elem).addClass("current");

    var pos = $(elem).position();

    var top = pos.top + "px";

    $('html,body').animate({
        scrollTop: top
    }, 300, function () {
        //loadNextPage($(elem).attr("id"));
        loadAllPage();

        var link = $('ul.nav a[data-link="' + id + '"]');

        $("ul.nav a").removeClass("current").removeClass("focus");
        $(link).addClass("current").addClass("focus");

    });

}

function goToScreen(id) {
    var elem = $(id);

    loadPage($(elem).attr("id"));

    $("#container > article.screen").removeClass("current");
    $(elem).addClass("current");

    var pos = $(elem).position();

    $('html,body').scrollTop(pos.top);
}


function loadAllPage() {

    $("article.screen").each(function () {
        loadPage($(this).attr("id"));
    });

}


/**
 * loadNextPage
 * @param curr_page
 */
function loadNextPage(curr_page) {

    var page = $("article.screen#" + curr_page).next();

    if (page.length > 0) {

        loadPage($(page).attr("id"));
    }
}


/**
 * loadPage
 * @param page
 */
function loadPage(page) {

    var container = $("#" + page);

    if ($(container).hasClass("loaded")) {
        return;
    }

    var url = "/ajax/" + page;

    $.ajax({
        type: "GET",
        url: url,
        contentType: "txt/html",
        'timeout': 1000,
        error: function () {
            console.log("error");
        },
        success: function (data) {

            $(" div.container > div.content", container).html(data);
            $(container).addClass("loaded");

            initImg();

            if (page == "home") {
                $("article.screen#home .arrow").show();
                timer2 = setInterval(function () {

                    $("article.screen#home .arrow").animate({
                        bottom: '3%'
                    }, 1000, 'easeInOutElastic');

                    clearInterval(timer2);
                }, 500);
            }


        }
    });
}