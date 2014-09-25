$(document).ready(function () {

    nav.scroll = {};
    nav.scroll.last = 0;
    nav.scroll.lastUp = 0;
    nav.scroll.lastDown = 0;

    $(window).on('scroll', function (event) {

        if (document.body.scrollHeight <= document.body.scrollTop + window.innerHeight) {
            var bottom = true;
        } else {
            var bottom = false;
        }

        var page = $("#page");
        var headerElem = $("> header", page);

        var topPos = $(this).scrollTop();
        var headerH = $(headerElem).height();

        if (topPos > nav.scroll.last) {
            var sense = "down";
            nav.scroll.lastDown = topPos;
        } else {
            var sense = "up";
            nav.scroll.lastUp = topPos;
        }


        if (!$(page).hasClass("simpleHeader") && !$(page).hasClass("admin") && !$(page).hasClass("home")) {
            if (!bottom && (document.body.scrollHeight - window.innerHeight - 600) > 0) {

                if (topPos > 440) {
                    if (sense == "up") {

                        var diff = nav.scroll.lastDown - topPos;

                        $("#page").addClass("headerFixed");

                        if (diff < 64) {
                            $(headerElem).css("top", (diff - 64));
                        } else {
                            $(headerElem).css("top", 0);
                        }

                    } else {

                        var diff = nav.scroll.lastUp - topPos;

                        if (diff > -64) {
                            $(headerElem).css("top", (diff));
                        } else {
                            $(headerElem).css("top", -64);
                            $("#page").removeClass("headerFixed");
                        }
                    }
                } else {
                    $("#page").removeClass("headerFixed");
                    $(headerElem).css("top", -64);
                }

                if (topPos <= 480 && sense == "up") {
                    $(headerElem).css("top", (topPos - 440) - 64);
                }

            } else {
                $("#page").removeClass("headerFixed");
                $(headerElem).css("top", -64);
            }

            nav.scroll.last = topPos;


        }

        if (!$(page).hasClass("simpleHeader") && !$(page).hasClass("admin")) {
            if (topPos < headerH) {

                var max = Math.pow(headerH / 16, 1.2);

                var topValue = Math.abs(topPos / 16);

                topValue = Math.pow(topValue, 1.2);

                $("a.logo img", headerElem).css("opacity", 1 - topValue / max);

                topValue = topValue * (-1);

                $(".map_bg .inner", headerElem).css("top", topValue);

            }
        }

    });

});