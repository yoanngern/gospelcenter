// @codekit-prepend "vendor/jquery.timeago.js"

$(document).ready( function() {
	
	resizeVideo();
	
	$(window).resize(function() {
        resizeVideo();
	});
	
	$(".duration").each( function() {
    	dateRewrite(this);
	});
	
});

function resizeVideo() {
    var windowH = $(window).height();
    var sectionH = $(window).height() - $("footer").height() - 170;
    
    var videoH = 540;
    var videoW = 960;
    
    if((sectionH * 1) >= 360 && (sectionH * 0.9) < 720) {
        videoH = 0.85 * sectionH;
    }
    
    if((sectionH * 0.9) > 720) {
        videoH = 720;
    }
    
    if((sectionH * 1) < 360) {
        videoH = 360;
    }
    
    videoW = 16/9 * videoH;
    
    $("section.video iframe").css("height", videoH);
    $("section.video iframe").css("width", videoW);
    $("section.video").css("width", videoW);
}

function dateRewrite(time) {

    var now = Date.now();    
    date = new Date($(time).attr("data-time"));
    
    date = $.timeago(date);
    
    $(time).text(date);
}