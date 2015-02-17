$(document).ready( function() {
	
    $("section.wall").on("click", 'a#more', function () {

        if($(this).attr("data-page")) {
            var page = parseInt($(this).attr("data-page"));
        } else {
            var page = 1;
        }

        moreVideos(page+1);
    });

});


function moreVideos(page) {

    var url = "../api/videos.json";

    $.ajax({
        type: "GET",
        url: url,
        async: true,
        jsonpCallback: 'callback',
        contentType: "application/json",
        dataType: 'json',
        'timeout': 1000,
        data: {
            page: page,
            nb: 8
        },
        error: function () {
            console.log("error");
        },
        success: function (data) {
            addVideos(data.celebrations);

            $("a#more").attr("data-page", parseInt(data.page));

        }
    });
}

function addVideos(celebrations) {

    $(celebrations).each(function() {

        var source = $("#addVideo").html();
        var template = Handlebars.compile(source);
        var html = template(this);

        $("section.wall a#more").before(html);
    });

}