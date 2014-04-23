// @codekit-prepend "vendor/jquery.easing.1.3.js"
// @codekit-prepend "vendor/jquery.history.js"
// @codekit-prepend "vendor/jquery.mousewheel.js"

var moveScroll = false;

var navigation = [
    "home",
    "celebrations",
    "vision",
    "god",
    "television",
    "training",
    "contact"
];

$(document).ready( function() {
	
	initGlobalPage();
	logoResize();
    slideResize();
    
    timer = setInterval(function() {
        var page = $("article.page.active");
        
        var toScroll = $(page).offset().top;
        
        $('html, body').scrollTop(toScroll);
        
        $("#container").animate({
            opacity: 1
        }, 700);
        
        $(".logo, #page > h2, #page > h1").animate({
            opacity: 1
        }, 1500);
        
        clearInterval(timer);
    }, 100);
    
    timer2 = setInterval(function() {
        
        $("#home .arrow").animate({
            bottom: '3%'
        }, 1000, 'easeInOutElastic');
        
        clearInterval(timer2);
    }, 500);
    
    
    $(document).on('mouseenter', '#home .arrow', function() {
        $(this).animate({
            bottom: '2%'
        }, 500, 'easeOutElastic');
    });
    
    $(document).on('mouseout', '#home .arrow', function() {
        $(this).animate({
            bottom: '3%'
        }, 500, 'easeOutElastic');
    });
    
    
    /**
     *  When the window is resize
     */
    $(window).resize(function() {
        logoResize("article.logo");
        slideResize();
        
        var page = $("article.page.active");
        
        var toScroll = $(page).offset().top;
        
        $('html, body').scrollTop(toScroll);
    });
    
});


/**
 *  Initialisation of the global page
 */
function initGlobalPage() {
    $("#page.home footer").hide();
	$("#page.home .arrow").show();
	$("#page.home footer").css("background", "#fdfdfc");
	
	
	var currentClass = $("#container").attr("class");
	
	var html = '';
	
	var currentContent = $("#container").html();
	
	for(i = 0; i < navigation.length; i++) {
    	html += '<article class="page" id="'+ navigation[i] +'"></article>';
	}
	
	$("#container").html(html);
	
	$("article.page#"+currentClass).html(currentContent);
	$("article.page#"+currentClass).addClass("active");
	
	$("body").addClass(currentClass);
	
	if(currentClass !== "home") {
    	$("footer li a."+currentClass).addClass("current");
	}
	
	var currentPage = $("article.page#"+currentClass);
	$("html, body").scrollTop(currentPage.offset().top);
	
	$("article.page.active .slide").css("opacity", 1);
}


/**
 *  Slide resize
 */
function slideResize() {
    $("article.slide").each( function() {
        var slideH = $(this).height();
        var txtH = $("section", this).height();
        
        var marginH = (slideH - txtH) / 2;
        
        $("section", this).css("margin-top", marginH);
        
    });
}


/**
 *  Move to page
 *  @param link to the page
 */
function moveToPage(link) {
    
    if(!$("body").hasClass(link)) {
        getContent(link);
    } else {
        scrollToPage(link);
    }
}


/**
 *  Move to page
 *  @param page of the content
 */
function scrollToPage(page) {

    console.log("scrollToPage()");
    
    var element = $("#"+page);

    if(page == "celebrations") {
        var currentPage = $("article.page.active");
        var currentClass = $(currentPage).attr("id");
        
        var currentPos = $.inArray(currentClass, navigation);
        var nextPos = $.inArray(page, navigation);
        
        var posSlider = $("article.page#celebrations nav li.current").attr("data-slide");
        var totalSlider = $("article.page#celebrations .slide").length;
        
        if(currentPos > nextPos) {
            moveToDown((totalSlider - posSlider), $("article.page#celebrations .slider"), true);
            
        } else {
            moveToTop((posSlider-1), $("article.page#celebrations .slider"), true);
        }   
    }
    
    if(page == "home") {
        $("footer").fadeOut(300);
    } else {
        $("article.page#home .arrow").fadeOut(300, function() {
            $("#home .arrow").css("bottom", '-100px');
        });
        $("footer li a").removeClass("current");
        $("footer li a."+ page).addClass("current");
    }
    
    resize();
    
    slideResize();
    
    $('html,body').animate({
    	scrollTop: element.offset().top
    }, 1000, 'easeInOutCubic', function () {
	    
	    $("#page > h1, #page > h2").fadeIn(300);
	    
	    var title = "Gospel Center";
	    
	    if(page !== "home") {
    	    $("footer").fadeIn(300);
    	    
    	    title = title +" - "+ $("footer li a.current").text();
	    } else {
    	    $("#home .arrow").show();
    	    $("#home .arrow").animate({
                bottom: '3%'
            }, 1000, 'easeInOutElastic');
	    }
	    
	    $("article.page").removeClass("active");
	    $("article.page#"+page).addClass("active");
	    
	    $(".logo, #page > h2, #page > h1").animate({
            opacity: 1
        }, 1500);
	    
	    History.pushState(null, null, page);
	    
	    document.title = title;
    });
}


/**
 *  Move to page
 *  @param page of the content
 */
function getContent(page) {
    
    var url = "/" + page;
    
    $.ajax({
        url: url,
        cache: false
    })
    .done(function( html ) {
        addPage(html);
    })
    .fail(function() {
        console.log("error");
    });
    
}


/**
 *  Add a page
 *  @param html the content of the page
 */
function addPage(html) {
    var pageName = $("#container", html).attr("class");
    var html = $("#container", html).html();
    
    $("article.page#"+pageName).html(html);
    
    $("body").addClass(pageName);
    
    $("article.page#"+pageName+" .slide").each( function() {
    	
    	var slider = $(this).parent();
    	
    	initSlider(slider);
    	$(this).fadeIn(300);
	});
    
    scrollToPage(pageName);
    
}


/**
 *  Go down
 */
$(document).on("goDown", function() {
    moveToPage("celebrations");
});


/**
 *  Logo resize
 */
function logoResize() {
    
    if($("body").hasClass("home")) {
        var block = $("article.logo");
    
        var windowW = $(window).width();
    	var windowH = $(window).height();
    	
    	var windowRatio = windowW/windowH;
        
        var blockW = $(block).width();
    	var blockH = $(block).height();
    	
    	var logoW = $("img", block).width();
    	var logoH = $("img", block).height();
    	
    	var txtW = $("h1", block).width();
    	var txtH = $("h1", block).height();
    	
    	var txtFontSize = $("h1", block).css("font-size");
    	
    	txtFontSize = txtFontSize.replace("px", "");
    	txtFontSize = parseInt(txtFontSize);
    	
    	var maxH = blockH - logoH;
    	
    	var newTxtFontSize = (txtFontSize * blockW) / txtW;
    	
    	newTxtFontSize = 0.95 * newTxtFontSize;
    	
    	if(newTxtFontSize < maxH || windowRatio > 2.57) {
        	$("h1", block).css("font-size", newTxtFontSize);
    	} else {
        	$("h1", block).css("font-size", maxH);
    	}
    }
}


/**
 *  Mouse wheel event
 */
$('html').bind('mousewheel', function(e){
	e.preventDefault();
	
	if(e.deltaY > 2) {
    	$(document).trigger("screenScroll", "up");
	} else if(e.deltaY < -2) {
    	$(document).trigger("screenScroll", "down");
	}
	
	if(e.deltaX > 2) {
    	$(document).trigger("screenScroll", "right");
	} else if(e.deltaX < -2) {
    	$(document).trigger("screenScroll", "left");
	}
});


/**
 *  Link event
 */
$(document).on('click', 'a', function(e) {
	
	var link = $(this).attr("href");
	var event = $(this).attr("data-event");
	
	if(event !== null && event !== "" && typeof event !== "undefined") {
    	var id = $(this).attr("id");
    	$(this).trigger(event, id);
    	e.preventDefault();
    }
    
    var pos = $.inArray(link, navigation);
    
    if(pos >= 0) {
        e.preventDefault();
        
        if(link !== null && link !== "" && typeof link !== "undefined") {
        	moveToPage(link);
    	}
    }
});


/**
 *  Scroll event
 *  @param direction of the scroll
 */
$(document).on('screenScroll', function(event, direction) {
	
	if(moveScroll) {
    	return;
	} else {
    	moveScroll = true;
	}
	
	delay(function(){
		moveScroll = false;
	}, 1200);
	
	var currentPage = $("article.page.active");
	var currentId = $(currentPage).attr("id");
	
	var slider = $(".slider.vertical", currentPage);
	
	if(slider !== null && slider !== "" && typeof slider !== "undefined") {
    	var currentPos = $("nav li.current", slider).attr("data-slide");
	} else {
    	var currentPos = null;
	}
	
	var pos = $.inArray(currentId, navigation);
	
	if(direction == "up" || direction == "left") {
	    
	    if(currentPos == $(".slide.first", slider).attr("id") || currentPos == null) {
    	    if(pos !== 0) {
        	    moveToPage(navigation[pos-1]);
        	} else {
            	return;
        	}
	    } else {
    	    moveToTop(1, slider);
	    }
	
	    
    } else if(direction == "down" || direction == "right") {
    	
    	if(currentPos == $(".slide.last", slider).attr("id") || currentPos == null) {
    	    if(pos !== navigation.length -1) {
        	    moveToPage(navigation[pos+1]);
        	} else {
            	moveToPage(navigation[0]);
        	}
	    } else {
    	    moveToDown(1, slider);
	    }
    }
});
