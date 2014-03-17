var rubanVisible = false;
var navVisible = false;
var rubanProcess = false;
var navProcess = false;
var headerLeft = '';
var onMove = false;

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

Modernizr.addTest("overflowscrolling",function(){
 return Modernizr.testAllProps("overflowScrolling");
});

$(document).ready( function() {
	
	// Get ruban is clicked
	$('header').on('click', '#get_ruban', function() {
		event.preventDefault();
		toggleRuban();
	});
	
	// Get nav is clicked
	$('header').on('click', '#get_nav', function() {
		event.preventDefault();
		toggleNav();
	});
	
	// init checkbox
	$("input[type=checkbox]").each( function() {
    	initCheckBox(this);
	});
	
	// init checkbox
	$("input[type=radio]").parent().each( function() {
    	initRadio(this);
	});
	
	// Select a checkbox
	$("form").on('click', 'div.icon', function() {
	    setCheckbox(this);
	});
	
	// Select initialization
	$("select").each( function() {
    	initSelect(this);
	});
	
	// Select click
	$("form").on('click', 'div.select', function() {
    	viewSelect(this);
	});
	
	// Option is selected
	$("body").on('click', '#viewSelect li', function() {
    	setSelect(this);
	});
	
	// Close select view
	$("header").on('click', '#back.current', function() {
    	closeViewSelect($(this).data("select"));
	});
	
	// Input File initialization
	$("input[type=file]").each( function() {
    	initInputFile(this);
	});
	
	// Input File click
	$("form").on('click', '#addImage', function() {
    	$("input[type=file]").click();
	});
	
	// Input File is updated
	$("input[type=file]").change( function() {
    	showPreview(this);
	});
	
	$(".slider").swipe({
      swipe:function(event, direction, distance, duration, fingerCount) {
        
        if(direction == "left" && distance > 70) {
            moveToLeft(1, this);
        } else if(direction == "right" && distance > 70) {
            moveToRight(1, this);
        }
      }
    });
	
	start();
	
	// If the window is resised
	$(window).resize(function() {
        setWindow();
	});
	
	/*
	var intervalID = setInterval(function() {
        moveToLeft(1, ".nextCelebrations", 300);
    }, 4000);
	*/
});

function setWindow() {
    
    if($("#page").hasClass("celebrations") && $("#page").hasClass("local")) {
        initCelebrations();
    }
    
    $(".slider").each( function() {
        initSlider(this);
    });
}

function initCelebrations() {
    
    var windowW = $(window).width();
    var windowH = $(window).height();
    
    // Landscape
    if(windowH < windowW) {
        
        $("html").css("height", "200%");
        
        navH = $("body > header").height();
        
        nextH = windowH - navH;
        
        $(".nextCelebrations").css("height", nextH);
        
        $(".lastCelebrations").hide();
    
    // Profile
    } else {
        
        $(".lastCelebrations").show();
        
        $(".nextCelebrations").css("height", "50%");
        
        navH = $("body > header").height();
        nextH = $(".nextCelebrations").height();
        
        navTop = nextH + (0.5 * navH);
        
        $(".nextCelebrations nav#slides").css("top", navTop);
        
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
    
    var nav = $(slide).parent().parent();
    var current = $("li.current", nav).data("slide");

    var id = $(slide).data("slide");
    
    var sliderId = $(slide).data("slider");
    var slider = $(".slider[id="+ sliderId +"]");
    
    if(id > current) {
        var pos = id - current;
        moveToLeft(pos, slider);
    }
    
    if(id < current) {
        var pos = current - id;
        moveToRight(pos, slider);
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

function moveToLeft(pos, slider, speed) {
    
    speed = typeof speed !== 'undefined' ? speed : 250;
    
    if($(slider).hasClass("small")) {
        var isSmall = true;
    } else {
        var isSmall = false;
    }
    
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
    
    if(isSmall) {
        
        var position = $(".slide", slider).parent().attr("data-position");
        
        position = typeof position !== 'undefined' ? position : 0;
        
        if(position < total) {
            position++;
        }
        
        var paddingLeft = $(".slide", slider).parent().css("padding-left").replace('px', '');
        paddingLeft = parseFloat(paddingLeft);
        
        var posLeft = $(".slide:eq("+ position +")", slider).position().left;
        
        left = -posLeft + paddingLeft;
        
        $(".slide", slider).parent().animate({
    		left: left
    	}, speed, function() {});
    	
    	$(".slide", slider).parent().attr("data-position", position);
    	
    	return false;
    }
    
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
    	}, speed, function() {
        	setMax(slider);
    	});
    });
}

function moveToRight(pos, slider, speed) {
    
    speed = typeof speed !== 'undefined' ? speed : 250;
    
    if($(slider).hasClass("small")) {
        var isSmall = true;
    } else {
        var isSmall = false;
    }
    
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
    
    if(isSmall) {
        
        var position = $(".slide", slider).parent().attr("data-position");
        
        position = typeof position !== 'undefined' ? position : 1;
        
        if(position > 0) {
            position--;
        }
        
        var paddingLeft = $(".slide", slider).parent().css("padding-left").replace('px', '');
        paddingLeft = parseFloat(paddingLeft);
        
        var posLeft = $(".slide:eq("+ position +")", slider).position().left;
        
        left = -posLeft + paddingLeft;
        
        if(left <= 0) {
            $(".slide", slider).parent().animate({
        		left: left
        	}, speed, function() {});
        }
        
        $(".slide", slider).parent().attr("data-position", position);
    	
    	return false;
    }
    
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
    	}, speed, function() {
        	setMax(slider);
    	});
    });
    
}

function start() {
    
    setWindow();
    
}

function initSlider(slider) {
    
    var startPos = 0;
    
    if($(slider).hasClass("small")) {
        var isSmall = true;
    } else {
        var isSmall = false;
    }
    
    $(".slide", slider).each( function() {
        
        var slide = $(this);
        
        var id = $(slide).attr("id");
        var total = $(".slide", slider).length;
        windowW = $(window).width();
        
        // if the Slider is Small
        if(isSmall) {
            sliderW = total * windowW;
            $(slide).parent().css("width", sliderW);
            
        // If the Slider is Big
        } else {
            
            if(id > 1) {
                
                $(slide).css("top", 0);
                
                slideH = $(slide).height();
                currPos = $(slide).position().top;
                
                var top = startPos - currPos;
                $(slide).css("top", top);
            } else {
                startPos = $(slide).position().top;
            }
            
            var left = (id - 1) * windowW;
        
            var marginRight = $(slide).css("marginRight").replace('px', '');
            marginRight = parseFloat(marginRight);
            
            $(slide).css("left", left + (marginRight * (id-1)));
            
            if(id == 1) {
            	$(slide).addClass("maxLeft");
        	}
        	
        	if(id == total) {
            	$(slide).addClass("maxRight");
        	}
            
        }
        
    });
    
}

function initInputFile(input) {
    
    $(input).hide();
    
    var title = $(input).data("title");
    
    if(title != null) {
        var div = '<div id="addImage"><span>'+ title +'</span><div class="arrow"></div></div>';
    } else {
        var div = '<div id="addImage"><span>Select a file.</span><div class="arrow"></div></div>';
    }
    
    $(input).after(div);
}


function showPreview(input) {
    
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            
            var image = e.target.result;
            
            $("#addImage").after('<img class="newImg" src="'+ image +'" alt="preview"/>');
        }

        reader.readAsDataURL(input.files[0]);
    }
    
    $("#addImage").hide();
}


function initSelect(select) {
    $(select).hide();
    
    var id = $(select).attr("id");
    
    var title = '';
    
    $("option:selected", select).each( function() {
        
        if($(this).attr("value") != '') {
        
            if(title == '') {
                title += $(this).text();
            } else {
                title += ', ' + $(this).text();
            }
        }
    });
    
    if(title == '') {
        title = $(select).attr("placeholder");
    }
    
    var html = '<div class="select" data-select="'+ id +'"><span>'+ title +'</span><div class="arrow"></div></div>';
    
    $(select).after(html);
}


function viewSelect(div) {
    
    var options = [];
    
    var id = $(div).data('select');
    
    var select = $("select[id="+ id +"]");
    
    var title = $(select).attr('placeholder');
    
    if($(select).prop("multiple")) {
        var isMultiple = true;
    } else {
        var isMultiple = false;
    }
    
    $("option", select).each( function() {
        
        if($(this).attr("value").length) {
            
            var anOption = [];
            
            if($(this).attr("selected") == "selected") {
                anOption['selected'] = 'selected';
            } else {
                anOption['selected'] = '';
            }
            
            
            anOption['id'] = $(this).attr("value");
            anOption['name'] = $(this).text();
            options.push(anOption);
        }
    });
    
    var html = '<section id="viewSelect"><section class="content"><ul data-select="'+ $(select).attr("id") +'" data-multiple="'+ isMultiple +'">';
    
    $(options).each( function() {
        html += '<li data-option="'+ this['id'] +'" class="'+ this['selected'] +'"><h1>'+ this['name'] +'</h1><div class="status"></div></li>';
    });
    
    html += '</ul></section></section>';
    
    $("#page").after(html);
    
    $("#viewSelect").css("left", "100%");
    
    $("#viewSelect").animate({
		left: 0
	}, 300, function() {
    	
	});
	
	$("body > header a").hide();
	$("body > header h1").hide();
	
	$("body > header h1").after('<h1 class="current">'+ title +'</h1>');
	
	$("body > header").prepend('<a id="back" data-select="'+ id +'" class="left current" href="#"></a>');
    
}


function setSelect(option) {
    
    var optionId = $(option).data("option");
    var isMultiple = $(option).parent().data("multiple");
    var selectId = $(option).parent().data("select"); 
    var select = $("select[id="+ selectId +"]");
    
    if(!isMultiple) {
        $("option", select).attr("selected", false);
    }
    
    if(!$(option).hasClass("selected")) {
        
        $(option).addClass("selected");
        $("option[value="+ optionId +"]", select).attr("selected", true);
        
    } else {
        
        $(option).removeClass("selected");
        $("option[value="+ optionId +"]", select).attr("selected", false);
        
    }

    if(!isMultiple) {
        $(option).parent().children().removeClass("selected");
        closeViewSelect(selectId);
    }
    
}


function closeViewSelect(selectId) {
    
    var title = '';
    
    var select = $("select[id="+ selectId +"]");
    
    $("option:selected", select).each( function() {
        
        if($(this).attr("value") != '') {
        
            if(title == '') {
                title += $(this).text();
            } else {
                title += ', ' + $(this).text();
            }
        }
    });
    
    if(title == '') {
        title = $(select).attr('placeholder');
    }
    
    $("div.select[data-select="+ selectId +"] span").text(title);
    
    delay(function(){
		$("#viewSelect").animate({
    		left: "100%"
    	}, 300, function() {
        	$("#viewSelect").remove();
        	$("body > header .current").remove();
        	$("body > header #back").show();
        	$("body > header h1").css("display", "inline-block");
    	});
	}, 500);
	
}


function toggleRuban() {
	if(rubanVisible) {
		closeRuban();
	} else {
		openRuban();
	}
}

function toggleNav() {
	if(navVisible) {
		closeNav();
	} else {
		openNav();
	}
}

function openRuban() {
	if(!rubanProcess) {
	    rubanVisible = true;
        rubanProcess = true;
    	$('#ruban_nav').show();
    	if(navVisible) {
    	    $('#nav').css("top", "-100%").hide();
    	    navVisible = false;
        }
    	
    	var width = $('#ruban_nav').width();
    	
    	$('body > header, #page').animate({
    		left: width
    	}, 100, function() {
        	rubanProcess = false;
    	});
    }
}

function closeRuban() {
    if(!rubanProcess) {
    	rubanVisible = false;
    	rubanProcess = true;
    	
    	$('body > header, #page').animate({
    		left: "0px"
    	}, 100, function() {
        	$('#ruban_nav').hide();
        	rubanProcess = false;
    	});
    }
}

function openNav() {
	if(!navProcess) {
	    navVisible = true;
        navProcess = true;
        $('#nav').show();
    	
    	$('#nav').animate({
    		top: 0
    	}, 100, function() {
        	navProcess = false;
        	$('#get_nav').addClass("selected");
    	});
    }
}

function closeNav() {
    if(!navProcess) {
    	navVisible = false;
    	navProcess = true;
    	
    	$('#nav').animate({
    		top: '-100%'
    	}, 100, function() {
        	navProcess = false;
        	$('#get_nav').removeClass("selected");
    	});
    	
    	$('#nav').hide();
    }
}