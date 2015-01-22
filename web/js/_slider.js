// @codekit-prepend "vendor/jquery.slides.js"


$(document).ready(function () {

    /*
    window.slideCounter = 0;

    $(document).on('click', 'section.slider div.arrow', function (event) {

        console.log(event);

        var slider = $(this).parent();
        var side = $(this).attr("id");

        scrollSlide(slider, side);

    });


    $(document).on('click', 'section.slider li[data-slide]', function(event) {

        var slider = $(this).parent().parent().parent();
        var slide = $(this).attr("data-slide");

        slideDirect(slider, slide);

    });
    */

    $(function() {
        $('section.slider#1').slidesjs({
            width: 960,
            height: 380
        });

        $('section.slider#2').slidesjs({
            width: 960,
            height: 380
        });

        $('section.slider#3').slidesjs({
            width: 960,
            height: 380
        });

        $('section.slider#4').slidesjs({
            width: 960,
            height: 380
        });

        $('section.slider#5').slidesjs({
            width: 960,
            height: 380
        });
    });

});


/**
 * slideDirect
 * @param slider
 * @param slide_id
 */
function slideDirect(slider, slide_id) {

    var slides = $(".slides", slider);
    var slide = $("#" + slide_id, slides);
    var bullets = $("#slides", slider);
    var move = $(slides).attr("data-move");
    var currentSlide = $("li[data-slide].current", slider);
    var currentId = $(currentSlide).attr("data-slide");
    currentId = parseInt(currentId);

    if (move == null || move == "" || typeof move == "undefined") {
        move = 0;
    } else {
        move = move.replace("%", "");
        move = parseInt(move);
    }

    value = (slide_id - currentId);

    if(value > 0) {
        slideCounter = value;
        scrollSlide(slider, "right");
    }

    if(value < 0) {
        slideCounter = -value;
        scrollSlide(slider, "left");
    }

}


/**
 * switchSlides
 * @param slider
 * @param side
 */
function switchSlides(slider, side) {

    var slides = $(".slides", slider);
    var move = $(slides).attr("data-move");
    var nbSlides = $(".slide", slides).length;
    var pos = $(slides).attr("data-pos");

    if (move == null || move == "" || typeof move == "undefined") {
        move = 0;
    } else {
        move = move.replace("%", "");
        move = parseInt(move);
    }

    var firstSlide = $(".slide", slides).first();
    var lastSlide = $(".slide", slides).last();

    if(side == "right") {
        $(firstSlide).remove();
        $(lastSlide).after(firstSlide);
        move += 100;

        if(pos == nbSlides) {
            pos = 0;
        }
    }

    if(side == "left") {
        $(lastSlide).remove();
        $(firstSlide).before(lastSlide);
        move -= 100;

        if(pos == 1) {
            var pos = nbSlides +1;
        }
    }

    $(".slide", slides).each( function(index, elem) {
        $(elem).attr("id", index+1);
    });

    var percentPos = move + "%";
    $(slides).css("left", percentPos);
    $(slides).attr("data-pos", pos);
    $(slides).attr("data-move", move);

    if(side == "right") {
        var pos = nbSlides -1;
    }

    if(side == "left") {
        var pos = 2;
    }

    $(".slide", slider).removeClass("current");
    $('.slide#' + pos, slider).addClass("current");

    scrollSlide(slider, side);
}


/**
 * scrollSlide
 * @param slider
 * @param side
 */
function scrollSlide(slider, side) {

    var slides = $(".slides", slider);
    var bullets = $("#slides", slider);
    var currentSlide = $(".slide.current", slider);
    var pos = $(slides).attr("data-pos");
    var move = $(slides).attr("data-move");
    var nbSlides = $(".slide", slides).length;

    nbSlides = parseInt(nbSlides);

    if (pos == null || pos == "" || typeof pos == "undefined") {
        pos = 1;
        $(slides).attr("data-pos", pos);
    }

    if(!$(currentSlide).next().length && side == "right") {

        switchSlides(slider, "right");

        return;
    }

    if(!$(currentSlide).prev().length && side == "left") {

        switchSlides(slider, "left");

        return;
    }

    if(slideCounter > 0) {
        slideCounter--;
    }

    if (move == null || move == "" || typeof move == "undefined") {
        move = 0;
    } else {
        move = move.replace("%", "");
        move = parseInt(move);
    }

    if (side == "right") {
        move -= 100;

        if(pos == nbSlides) {
            pos = 1;
        } else {
            pos++;
        }

    } else {
        move += 100;

        if(pos == 1) {
            pos = nbSlides;
        } else {
            pos--;
        }
    }

    var percentPos = move + "%";

    $(slides).attr("data-pos", pos);
    $(slides).attr("data-move", move);


    $("li[data-slide]", bullets).removeClass("current");
    $('li[data-slide="' + pos + '"]', bullets).addClass("current");

    $(".slide", slider).removeClass("current");

    var nextSlide = null;

    if (side == "right") {
        nextSlide = $(currentSlide).next();
    } else {
        nextSlide = $(currentSlide).prev();
    }

    $(nextSlide).addClass("current");

    $(slides).animate({
        left: percentPos
    }, 400, function() {
        if(slideCounter > 0) {
            slideCounter--;
            scrollSlide(slider, side);
        }
    });
}
