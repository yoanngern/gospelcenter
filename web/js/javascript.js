var rubanVisible = false;
var paramVisible = false;
var rubanProcess = false;

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
		console.log("click");
		
		event.preventDefault();
		toggleRuban();
		
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
    
    $("#container h1").css("margin-top", 50);
    
}

function hideMessage() {
    
    var header = $("#message").parent();
    
    $(header).removeClass("message");
    
    $("#message").remove();
    
    $("#container h1").css("margin-top", 40);
    
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