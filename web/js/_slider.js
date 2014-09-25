$(document).ready(function () {

    $("section.slider").on('click', 'div.arrow', function (event) {

        var slider = $(this).parent();
        var side = $(this).attr("id");

        scrollSlide(slider, side);

    });

});


/**
 * scrollSlide
 * @param slider
 * @param side
 */
function scrollSlideOLD(slider, side) {

    console.log("scrollSlide(" + side + ")");


    var slides = $(".slides", slider);
    var pos = $(slides).attr("data-pos");

    if (pos == null || pos == "" || typeof pos == "undefined") {
        pos = 0;
    } else {
        pos = pos.replace("%", "");
        pos = parseInt(pos);
    }

    if (side == "right") {
        pos -= 100;
    } else {
        pos += 100;
    }

    var percentPos = pos + "%";
    $(slides).css("left", percentPos);


    $(slides).attr("data-pos", pos);

    if (side == "right") {


    }
}


function switchSlides(slider, side) {

    console.log("switchSlides(" + side + ")");

    var slides = $(".slides", slider);
    var move = $(slides).attr("data-move");
    var nbSlides = $(".slide", slides).length;

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
        var pos = 1;
    }

    if(side == "left") {
        $(lastSlide).remove();
        $(firstSlide).after(lastSlide);
        move -= 100;
        var pos = nbSlides;
    }

    $(".slide", slides).each( function(index, elem) {
        $(elem).attr("id", index+1);
    });

    var percentPos = move + "%";
    $(slides).css("left", percentPos);
    $(slides).attr("data-pos", pos);
    $(slides).attr("data-move", move);

    console.log(pos);

    $(".slide", slider).removeClass("current");
    $('.slide#' + pos, slider).addClass("current");

    scrollSlide(slider, side);
}



function scrollSlide(slider, side) {

    console.log("scrollSlide(" + side + ")");

    var slides = $(".slides", slider);
    var bullets = $("#slides", slider);
    var currentSlide = $(".slide.current", slider);
    var pos = $(slides).attr("data-pos");
    var move = $(slides).attr("data-move");
    var nbSlides = $(".slide", slides).length;

    console.log(currentSlide);
    //console.log(nbSlides);

    //currentSlide = parseInt(currentSlide);
    nbSlides = parseInt(nbSlides);

    //console.log($(currentSlide).next());

    if(!$(currentSlide).next().length && side == "right") {
        switchSlides(slider, "right");

        return;
    }


    if (pos == null || pos == "" || typeof pos == "undefined") {
        pos = 1;
    }

    if (move == null || move == "" || typeof move == "undefined") {
        move = 0;
    } else {
        move = move.replace("%", "");
        move = parseInt(move);
    }

    if (side == "right") {
        pos++;
        move -= 100;
    } else {
        pos--;
        move += 100;
    }





    var percentPos = move + "%";
    $(slides).css("left", percentPos);


    $(slides).attr("data-pos", pos);
    $(slides).attr("data-move", move);

    if (side == "right") {


    }

    console.log(pos);


    $("li[data-slide]", bullets).removeClass("current");
    $('li[data-slide="' + pos + '"]', bullets).addClass("current");

    $(".slide", slider).removeClass("current");
    $('.slide#' + pos, slider).addClass("current");
}





























