var onMove = false;

$(document).ready( function() {
	
	start();	
	
	$("article.slide").each( function() {
    	initSlide(this);
    	$(this).fadeIn(300);
	});
	
	$("nav#slides li").click( function() {
    	move(this);
	});
	
	$("div.arrow").click( function() {
    	if($(this).attr("id") == 'right') {
        	moveToLeft(1);
    	} else {
        	moveToRight(1);
    	}
	});
	
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


function setWindow() {
    $("article.slide").each( function() {
        var sectionH = $("section", this).height();
        var articleH = $(this).height();
        var paddingTop = ((articleH - sectionH) / 2);
        $("section", this).css('padding-top', paddingTop);
    });
    
    if($("article.slide").length) {
        setSlide();
    }
    
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


function setMax() {
    var posMaxLeft = 0;
    var posMaxRight = 0;
    
    $("article.slide").each( function() {
        var pos = $(this).position().left;
        
        if(pos <= posMaxLeft) {
            posMaxLeft = pos;
            $("article.slide").removeClass("maxLeft");
            $(this).addClass("maxLeft");
        }
        
        if(pos >= posMaxRight) {
            posMaxRight = pos;
            $("article.slide").removeClass("maxRight");
            $(this).addClass("maxRight");
        }
    });
}


function initSlide(slide) {
    
    var id = $(slide).attr("id");
    var total = $("article.slide").length;
    
    windowW = $(window).width();
    
    var left = (id - 1) * windowW;
    
    $(slide).css("left", left);
    	
	if(id == 1) {
    	$(slide).addClass("maxLeft");
	}
	
	if(id == total) {
    	$(slide).addClass("maxRight");
	}
    
}

function move(slide) {
    
    if(onMove) {
        return false;
    }
    onMove = true;
    
    delay(function(){
		onMove = false;
	}, 350);
    
    var current = $("nav#slides li.current").data("slide");
    
    var id = $(slide).data("slide");
    
    if(id > current) {
        var pos = id - current;
        moveToLeft(pos);
    }
    
    if(id < current) {
        var pos = current - id;
        moveToRight(pos);
    }
}

function moveToLeft(pos) {
    
    if(onMove) {
        return false;
    }
    onMove = true;
    
    delay(function(){
		onMove = false;
	}, 350);
    
    var total = $("article.slide").length;
    var current = $("nav#slides li.current").data("slide");
    var currentSlide = $("article.slide[id="+ current +"]");
    
    $("nav#slides li").removeClass("current");
    
    if(current == total) {
        var newCurrent = 1
    } else {
        var newCurrent = current + pos;
    }
    
    $("nav#slides li[data-slide="+ newCurrent +"]").addClass("current");
    
    windowW = $(window).width();
    var left = pos * windowW;
    left = "-="+left;
    
    $("article.slide").each( function() {
        
        var id = $(this).attr("id");
        
        if($(this).hasClass("maxLeft") && id != current) {
            var pos = $("article.slide.maxRight").position().left;
            
            $(this).css("left", pos+windowW);
            
            $("article.slide").removeClass("maxRight");
            $("article.slide").removeClass("maxLeft");
            $(this).addClass("maxRight");
        }
        
        $(this).animate({
    		left: left
    	}, 300, function() {
        	setMax();
    	});
    });
}

function moveToRight(pos) {
    
    if(onMove) {
        return false;
    }
    onMove = true;
    
    delay(function(){
		onMove = false;
	}, 350);
    
    var total = $("article.slide").length;
    var current = $("nav#slides li.current").data("slide");
    var currentSlide = $("article.slide[id="+ current +"]");
    
    $("nav#slides li").removeClass("current");
    
    if(current == 1) {
        var newCurrent = total
    } else {
        var newCurrent = current - pos;
    }
    
    $("nav#slides li[data-slide="+ newCurrent +"]").addClass("current");
    
    windowW = $(window).width();
    var left = pos * windowW;
    left = "+="+left;
    
    var nbSlide = $("article.slide").length;
    
    $("article.slide").each( function() {
        
        var id = $(this).attr("id");
        
        if($(this).hasClass("maxRight") && id != current) {
            var pos = $("article.slide.maxLeft").position().left;
            
            $(this).css("left", pos-windowW);
            
            $("article.slide").removeClass("maxRight");
            $("article.slide").removeClass("maxLeft");
            $(this).addClass("maxLeft");
        }
        
        $(this).animate({
    		left: left
    	}, 300, function() {
        	setMax();
    	});
    });
    
}