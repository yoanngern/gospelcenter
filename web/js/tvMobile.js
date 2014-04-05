$(document).ready( function() {
	
	resizeVideo();
	
	$(window).resize(function() {
        resizeVideo();
	});
	
});

function resizeVideo() {
    var windowW = $(window).width();
    
    var videoH = 960;
    var videoW = 540;
    
    videoW = windowW;
    videoH = 9/16 * videoW;
    
    $("section.video iframe").css("height", videoH);
    $("section.video iframe").css("width", videoW);
}