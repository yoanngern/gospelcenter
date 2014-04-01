// @codekit-append "vendor/removeDiacritics.js"

var onMove = false;

$(document).ready( function() {
	
	start();	
	
	// If the window is resised
	$(window).resize(function() {
        setWindow();
	});
});

/*
 *	delay() function is added to jQuery
 *	The goal is to fix a delay
 */
var delay = (function(){
	var timer = 0;
	return function(callback, ms){
		clearTimeout(timer);
		timer = setTimeout(callback, ms);
	};
})();


function start() {
	$("#page > h1, #page > h2").fadeIn(300);
	
	delay(function(){
		$("article.slide section").fadeIn(200);
		setWindow();
	}, 300);
	
}


function setSlide() {
    
    var total = $("article.slide").length;
    var current = $("nav#slides li.current").data("slide");
    var currentSlide = $("article.slide[id="+ current +"]");
    var currentPos = $(currentSlide).position().left;
    
    $(currentSlide).css("left", 0);
    
    $("article.slide").removeClass("left").removeClass("right");
    
    windowW = $(window).width();
    
    $("article.slide").each( function() {
        
        var id = $(this).attr("id");
        var thisPos = $(this).position().left;
        
        // Left
        if(thisPos < currentPos) {
        
            $(this).addClass("left");
            if(current == total) {
                if(id == 1) {
                    var left = 1 * windowW;
                } else {
                    var left = (-1) * ((current - id) * windowW);
                }
                
            } else {
                var left = (-1) * ((current - id) * windowW);
            }
        }
        
        // Right
        if(thisPos > currentPos) {
            $(this).addClass("right");
            
            if(current == 1) {
                if(id == total) {
                    left = (-1) * windowW;
                } else {
                    var left = (id - current) * windowW;
                }
            } else {
                var left = (id - current) * windowW;
            }
            
        }
        
        $(this).css("left", left);
    });
}