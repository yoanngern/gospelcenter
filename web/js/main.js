// @codekit-prepend "vendor/jquery-1.10.2.js"
// @codekit-append "vendor/handlebars-v1.3.0.js"
// @codekit-append "vendor/modernizr.js"
// @codekit-append "vendor/stupidtable.js"
// @codekit-append "_resize16_9.js"



var rubanVisible = false;
var paramVisible = false;
var rubanProcess = false;
var onMove = false;

var red = '#d91a15';
var white = '#fdfdfc';
var black = '#363331';
var redTop = '#e22416';
var redBottom = '#d11115';
var grayDark = '#313131';
var grayLight = '#878787';

// Size
var L = 1441;
var XL = 1701;
var XXL = 1921;

$(document).ready( function() {
	
	$('header').on('click', '#get_ruban', function() {
		
		event.preventDefault();
		toggleRuban();
		
	});
	
	$("table.main").stupidtable();
	
	$("table.main th[data-sort]").each( function() {
    	$(this).append("<span></span>");
	});
	
	$(document).on('click', 'nav#slides li', function() {
    	move(this);
	});
	
	$(".slide").each( function() {
    	
    	var slider = $(".slide").parent();
    	
    	initSlider(slider);
    	$(this).fadeIn(300);
	});
	
	$(document).on('click', 'div.arrow', function() {
    	
    	var slider = $(this).parent();
    	
    	if($(this).attr("id") == 'right') {
        	moveToLeft(1, slider);
    	} else {
        	moveToRight(1, slider);
    	}
	});
	
	start();
	
	// If the window is resised
	$(window).resize(function() {
        setWindow();
	});
	
	$('header').on('click', '#get_param', function() {
		event.preventDefault();	
		event.stopPropagation();
		toggleParam();
	});
	
	$('html').click(function() {
		if(paramVisible) {
			toggleParam();
		}
	});
	
	$('#param_nav').click( function(event) {
		event.stopPropagation();
		
	});
	
	$("#message").each( function() {
    	showMessage();
	});
	
	
	delay(function(){
		if($("#message").length) {
    	    hideMessage();
		}
	}, 2000);
	
});

$(window).scroll(function() {
    
    if($("#page").hasClass("tv") && !$("#page").hasClass("selections")) {
        if($(window).scrollTop() > $("header.tv").height()) {
            $("#page > header").addClass("scrolled");
            
        } else {
            $("#page > header").removeClass("scrolled");
            
        }
    }
    
});

function move(slide) {
    
    var nav = $(slide).parent().parent();
    var current = $("li.current", nav).data("slide");
    
    var mode = $(nav).attr("data-mode");
    
    var id = $(slide).data("slide");
    
    var sliderId = $(nav).parent().attr("id");
    var slider = $(".slider[id="+ sliderId +"]");
    
    if(id > current) {
        var pos = id - current;
        
        if(mode == "vertical") {
            moveToDown(pos, slider);
        } else {
            moveToLeft(pos, slider);
        }
        
    }
    
    if(id < current) {
        var pos = current - id;
        
        if(mode == "vertical") {
            moveToTop(pos, slider);
        } else {
            moveToRight(pos, slider);
        }
    }
}

function setMax(slider) {
    var posMaxLeft = 0;
    var posMaxRight = 0;
    
    $(".slide", slider).each( function() {
        var pos = $(this).position().left;
        
        if(pos <= posMaxLeft) {
            posMaxLeft = pos;
            $(".slide", slider).removeClass("maxLeft");
            $(this).addClass("maxLeft");
        }
        
        if(pos >= posMaxRight) {
            posMaxRight = pos;
            $(".slide", slider).removeClass("maxRight");
            $(this).addClass("maxRight");
        }
    });
}


/**
 *  Move to top
 *  @param  pos the number of position to move
 *          slider the slider of the slide
 */
function moveToTop(pos, slider, speed) {
    speed = typeof speed !== 'undefined' ? speed : false;
    
    var sliderH = $(slider).height();
    
    var total = $(".slide", slider).length;
    
    var currentTop = $("article.slide.first", slider).css("margin-top");
    currentTop = currentTop.replace("px", "");
    currentTop = parseInt(currentTop);
    
    var top = currentTop + sliderH * 1.015 * pos;
    
    var currentId = $("nav li.current", slider).attr("data-slide");
    currentId = parseInt(currentId);
    var newId = currentId - pos;
    var newSlide = $(".slide#"+newId, slider);

    var newTitle = $(newSlide).attr("data-title");
    var titleNode = $("article.page.active > section > h1");
    var title = $(titleNode).attr("data-title");
    
    if(newTitle !== null && newTitle !== "" && typeof newTitle !== "undefined") {
        $(titleNode).attr("data-title", $(titleNode).text());
        $(titleNode).text(newTitle);
    } else {
        if(title !== null && title !== "" && typeof title !== "undefined") {
            $(titleNode).text(title);
        }
    }
    
    var newRound = $('nav li[data-slide="'+newId+'"]', slider);
    
	$("nav li", slider).removeClass("current");
    $(newRound).addClass("current");
    
    if(newRound.attr("data-slide") == total) {
        $("nav", slider).addClass("black");
    } else {
        $("nav", slider).removeClass("black");
    }
    
    if(speed) {
        $("article.slide.first", slider).css("margin-top", top);
    } else {
        $("article.slide.first", slider).animate({
            marginTop: top
        }, 1000, 'easeInOutCubic');
    }
}


/**
 *  Move to down
 *  @param  pos the number of position to move
 *          slider the slider of the slide
 *          speed if true then no animation
 */
function moveToDown(pos, slider, speed) {
    speed = typeof speed !== 'undefined' ? speed : false;

    console.log("moveToDown("+pos+", "+slider+")");
    
    var sliderH = $(slider).height();
    
    var total = $(".slide", slider).length;
    
    var currentTop = $("article.slide.first", slider).css("margin-top");
    currentTop = currentTop.replace("px", "");
    currentTop = parseInt(currentTop);
    
    var top = currentTop - sliderH * 1.015 * pos;
    
    var currentId = $("nav li.current", slider).attr("data-slide");
    currentId = parseInt(currentId);
    var newId = currentId + pos;
    var newSlide = $(".slide#"+newId, slider);
    
    var newTitle = $(newSlide).attr("data-title");
    var titleNode = $("article.page.active > section > h1");
    var title = $(titleNode).attr("data-title");
    
    if(newTitle !== null && newTitle !== "" && typeof newTitle !== "undefined") {
        $(titleNode).attr("data-title", $(titleNode).text());
        $(titleNode).text(newTitle);
    } else {
        if(title !== null && title !== "" && typeof title !== "undefined") {
            $(titleNode).text(title);
        }
    }
    
    var newRound = $('nav li[data-slide="'+newId+'"]', slider);
    
    $("nav li", slider).removeClass("current");
    $(newRound).addClass("current");
    
    if(newRound.attr("data-slide") == total) {
        $("nav", slider).addClass("black");
    } else {
        $("nav", slider).removeClass("black");
    }
    
    if(speed) {
        $("article.slide.first", slider).css("margin-top", top);
    } else {
        $("article.slide.first", slider).animate({
            marginTop: top
        }, 1000, 'easeInOutCubic');
    }
    
    
}


/**
 *  Move to left
 *  @param  pos the number of position to move
 *          slider the slider of the slide
 */
function moveToLeft(pos, slider) {
    
    if(onMove) {
        return false;
    }
    onMove = true;
    
    delay(function(){
		onMove = false;
	}, 350);
    
    var total = $(".slide", slider).length;
    var current = $("nav#slides li.current", slider).data("slide");
    var currentSlide = $(".slide[id="+ current +"]", slider);
    
    $("nav#slides li", slider).removeClass("current");
    
    if(current == total) {
        var newCurrent = 1
    } else {
        var newCurrent = current + pos;
    }
    
    $("nav#slides li[data-slide="+ newCurrent +"]", slider).addClass("current");
    
    windowW = $(window).width();
    var left = pos * windowW;
    left = "-="+left;
    
    
    
    $(".slide", slider).each( function() {
        
        var id = $(this).attr("id");
        
        if($(this).hasClass("maxLeft") && id != current) {
            var pos = $(".slide.maxRight", slider).position().left;
            
            $(this).css("left", pos+windowW);
            
            $(".slide", slider).removeClass("maxRight");
            $(".slide", slider).removeClass("maxLeft");
            $(this).addClass("maxRight");
        }
        
        $(this).animate({
    		left: left
    	}, 300, function() {
        	setMax(slider);
    	});
    });
}


/**
 *  Move to right
 *  @param  pos the number of position to move
 *          slider the slider of the slide
 */
function moveToRight(pos, slider) {
    
    if(onMove) {
        return false;
    }
    onMove = true;
    
    delay(function(){
		onMove = false;
	}, 350);
    
    var total = $(".slide", slider).length;
    var current = $("nav#slides li.current", slider).data("slide");
    var currentSlide = $(".slide[id="+ current +"]", slider);
    
    $("nav#slides li", slider).removeClass("current");
    
    if(current == 1) {
        var newCurrent = total
    } else {
        var newCurrent = current - pos;
    }
    
    $("nav#slides li[data-slide="+ newCurrent +"]", slider).addClass("current");
    
    windowW = $(window).width();
    var left = pos * windowW;
    left = "+="+left;
    
    var nbSlide = $(".slide", slider).length;
    
    $(".slide", slider).each( function() {
        
        var id = $(this).attr("id");
        
        if($(this).hasClass("maxRight") && id != current) {
            var pos = $(".slide.maxLeft", slider).position().left;
            
            $(this).css("left", pos-windowW);
            
            $(".slide", slider).removeClass("maxRight");
            $(".slide", slider).removeClass("maxLeft");
            $(this).addClass("maxLeft");
        }
        
        $(this).animate({
    		left: left
    	}, 300, function() {
        	setMax(slider);
    	});
    });
    
}

function start() {
    setWindow();
    
    $("#logo").fadeIn(500).css("display","block");
    
    $('.slider').each( function() {
        initSlider(this);
    });
    
}

function initSlider(slider) {
    
    $(".slide", slider).each( function() {
        
        var slide = $(this);
        
        var id = $(slide).attr("id");
        var total = $(".slide", slider).length;
        var mode = $("nav", slider).attr("data-mode");
        
        if(mode == "vertical") {
            
            var slideH = $(slide).height();
            
            var top = (id - 1) * slideH;
            
            var currentPos = $("nav li.current", slider).attr("data-slide");
            var currentSlide = $(".slide#"+currentPos, slider);
            
        } else {
        
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
        
    });
    
}


function setWindow() {
    
    var windowH = $(window).height();
    
    $('#logo').each( function() {
    	var logoH = $(this).height();
    	var paddingTop = (windowH / 2.2) - (logoH / 2);
    	$(this).css("padding-top", paddingTop);
	});
	
	$("article.slide").each( function() {
        var sectionH = $(".content", this).height();
        var articleH = $(this).height();
        var paddingTop = ((articleH - sectionH) / 2);
        $(".content", this).css('padding-top', paddingTop);
    });
    
    $(".clip article").each( function() {
        $(this).css("margin-left", windowW * 0.005);
        $(this).css("margin-right", windowW * 0.005);
    });
    
    $("article.more").each( function() {
        var containerH = $(this).parent().height();
        var txtH = $("span", this).height();
        
        var moreH = containerH * 0.85;
        var moreW = moreH * (16/9);
        
        var paddingTop = (moreH - txtH) / 2;
        var top = (moreH / 2) * (-1) + (txtH/4);
        
        $(this).height(moreH);
        $(this).width(moreW);
        $(this).css("top", top);
        $("span", this).css("padding-top", paddingTop);
    });
}



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


function showMessage() {
    
    var header = $("#message").parent();
    
    $(header).addClass("message");
    
}

function hideMessage() {
    
    var header = $("#message").parent();
    
    $(header).removeClass("message");
    
    $("#message").remove();
    
}


function toggleRuban() {
	if(rubanVisible) {
		closeRuban();
	} else {
		openRuban();
	}
}

function openRuban() {
	if(!rubanProcess) {
	    rubanVisible = true;
        rubanProcess = true;
    	$('#ruban_nav').show();
    	
    	var width = $('#ruban_nav').width();
    	
    	$('#page').animate({
    		left: width,
    		marginRight: width
    	}, 200, function() {
        	rubanProcess = false;
    	});
    	$('body').css('overflow', 'hidden');
    }
}

function closeRuban() {
    if(!rubanProcess) {
    	rubanVisible = false;
    	rubanProcess = true;
    	$('#page').animate({
    		left: "0px",
    		marginRight: "0px"
    	}, 200, function() {
        	$('#ruban_nav').hide();
        	rubanProcess = false;
    	});
    	$('body').css('overflow', 'scroll');
    }
}

function toggleParam() {
	if(paramVisible) {
		closeParam();
	} else {
		openParam();
	}
}

function openParam() {
	paramVisible = true;
	$('#param_nav').show();
	$('.param_arrow').show();
}

function closeParam() {
	paramVisible = false;
	$('#param_nav').hide();
	$('.param_arrow').hide();
}