$(document).ready(function () {


    /**
     * If device is touchable
     */
    if ($("html").hasClass("touch")) {
        var elem = $("#page.celebrations").find('a.speaker').first();

        selectSpeaker(elem);

    }

    /**
     * A speaker is selected
     */
    $("#page.celebrations").on('click', 'a.speaker', function (event) {
        event.preventDefault();

        selectSpeaker(this);

    });

});


/**
 * selectSpeaker
 * @param speaker
 */
function selectSpeaker(speaker) {

    var id = $(speaker).attr("data-link");

    var thisW = $(speaker).width();

    var thisMarLeft = $(speaker).css("margin-left");

    thisMarLeft = thisMarLeft.replace("px", "");
    thisMarLeft = parseInt(thisMarLeft);

    var elem = $("article.celebrationInfo#" + id);

    var pos = $(speaker).position();

    var left = pos.left + (thisW / 2) + thisMarLeft;

    $("> .arrow", elem).css("left", left);

    var target = $(".celebrationInfo" + "#" + id);

    var targetContainer = $(target).parent();

    var container = $(".celebrationInfos");

    var targetH = $(target).height();

    var targetPadTop = $(target).css("padding-top");
    targetPadTop = targetPadTop.replace("px", "");
    targetPadTop = parseInt(targetPadTop);

    var targetPadBottom = $(target).css("padding-bottom");
    targetPadBottom = targetPadBottom.replace("px", "");
    targetPadBottom = parseInt(targetPadBottom);

    targetH = targetH + targetPadTop + targetPadBottom;

    if (!$(target).hasClass("actived")) {

        $(container).css("overflow", "hidden");

        $(container).animate({
            height: 0
        }, 200, function () {
            $(".celebrationInfo", targetContainer).removeClass("actived");
            $(target).addClass("actived");

            $(container).animate({
                height: targetH
            }, 400, function () {
                $(container).css("overflow", "visible");
            });
        });


    } else {

        $(container).css("overflow", "hidden");

        $(container).animate({
            height: 0
        }, 300, function () {
            $(".celebrationInfo", targetContainer).removeClass("actived");
        });
    }
}