$(document).ready(function () {

    $("input.video_url").change(function () {

        videoUrlUpdate(this);

    }).on('input', function () {

        videoUrlUpdate(this);

    });


});


function videoUrlUpdate(input) {

    var videoContainer = $("#videoContainer");

    var url = $(input).val();

    if (url == $(videoContainer).attr("data-url")) {
        return;
    }

    var hostname = $('<a>').prop('href', url).prop('hostname');

    var youtube = false;
    var vimeo = false;
    var dailymotion = false;
    var id = false;

    if (hostname.match("youtube.com")) {
        youtube = true;

        if ($.type(getYouTubbeId(url))) {
            id = getYouTubbeId(url);
        }
    }

    if (hostname.match("vimeo.com")) {
        vimeo = true;

        if ($.type(getVimeoId(url))) {
            id = getVimeoId(url);
        }
    }

    if (hostname.match("dailymotion.com")) {
        dailymotion = true;

        if ($.type(getDailymotionId(url))) {
            id = getDailymotionId(url);
        }
    }

    if (!id) {
        errorMessage("This url is incorrect");

        $(videoContainer).html("").attr("data-url", "");

        return;
    }

    var context = {
        youtube: youtube,
        vimeo: vimeo,
        dailymotion: dailymotion,
        id: id
    };

    var source = $("#videoIframe").html();
    var template = Handlebars.compile(source);
    var html = template(context);

    $(videoContainer).html(html).attr("data-url", url);
}


function getYouTubbeId(url) {

    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;

    var match = url.match(regExp);

    if (match && match[7].length == 11) {
        return match[7];
    } else {
        return false;
    }
}


function getVimeoId(url) {

    var regExp = /https?:\/\/(?:www\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|)(\d+)(?:$|\/|\?)/;

    var match = url.match(regExp);

    if (match) {
        return match[3];
    } else {
        return false;
    }
}


function getDailymotionId(url) {

    var regExp = /^.+dailymotion.com\/(video|hub)\/([^_]+)[^#]*(#video=([^_&]+))?/;

    var match = url.match(regExp);

    if (match) {
        if (match[4] !== undefined) {
            return match[4];
        }
        return match[2];
    }
    return false;

}