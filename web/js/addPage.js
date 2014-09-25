// @codekit-append "form.js"

$(document).ready( function() {
	initSlides();
	
	$(".slide #up").click( function() {
    	var slide = $(this).parent().parent();
    	moveSlideUp(slide);
	});
	
	$(".slide #down").click( function() {
    	var slide = $(this).parent().parent();
    	moveSlideDown(slide);
	});
	
});

function initSlides() {
    $("#gospelcenter_pagebundle_page_slides").hide();
    $("#gospelcenter_pagebundle_pageglobaltype_slides").hide();
    $("#gospelcenter_pagebundle_youthpagetype_slides").hide();
    
    var source   = $("#slide").html();
    var template = Handlebars.compile(source);
    var html    = template();
    
    $("fieldset#slides").append(html);
    
    $("article.slide").each( function(index) {
        var id = $(this).attr("id");
        $("div[id=gospelcenter_pagebundle_page_slides_"+ index +"] input").attr("data-slide", id);
        $("div[id=gospelcenter_pagebundle_pageglobaltype_slides_"+ index +"] input").attr("data-slide", id);
        $("div[id=gospelcenter_pagebundle_youthpagetype_slides_"+ index +"] input").attr("data-slide", id);
    });
}

function moveSlideUp(slide) {
    
    $(slide).prev().before($(slide));
    
    var id = $(slide).attr("id");
    
    updateSort();
    
}

function moveSlideDown(slide) {
    
    $(slide).next().after($(slide));
    
    var id = $(slide).attr("id");
    
    updateSort();
    
}

function updateSort() {
    $("article.slide").each( function(index) {
        var id = $(this).attr("id");
        
        $("input[data-slide="+ id +"]").val(index+1);
    });
}
