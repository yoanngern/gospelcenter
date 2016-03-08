// @codekit-prepend "grayscale/grayscale.js"

$(document).ready( function() {
	
    $("section.wall").on("click", 'a#more', function () {

        if($(this).attr("data-page")) {
            var page = parseInt($(this).attr("data-page"));
        } else {
            var page = 1;
        }

        var url = $(this).attr("data-apiUrl");

        //var url = "../api/videos.json";

        moreItems(page+1, url);
    });

});


function moreItems(page, url) {

    console.log("test");
    console.log(page);
    console.log(url);

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
            addToWall(data.items);

            $("a#more").attr("data-page", parseInt(data.page));

        }
    });
}

function addToWall(items) {

    $(items).each(function() {

        var source = $("#addToWall").html();
        var template = Handlebars.compile(source);
        var html = template(this);

        $("section.wall a#more").before(html);
    });

}