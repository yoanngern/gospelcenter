$(document).ready( function() {
	
	resize();
	
	// If the window is resised
	$(window).resize(function() {
        resize();
	});
	
});

function resize() {
    $(".16_9width").each( function() {
    	resizeHeight(this);
	});
	
	$(".16_9height").each( function() {
    	resizeWidth(this);
	});
}

function resizeHeight(element) {
    
    var elementW = $(element).width();
    var elementH = elementW * (9/16);
    
    var ratio = $(element).attr("data-ratio");
    
    if(ratio > 0) {
        elementH = elementH * ratio;
    }
    
    $(element).css("height", elementH);
    
}

function resizeWidth(element) {
    
    var elementH = $(element).height();
    var elementW = elementH * (16/9);
    
    var ratio = $(element).attr("data-ratio");
    
    if(ratio > 0) {
        elementW = elementW * ratio;
    }
    
    $(element).css("width", elementW);
    
}