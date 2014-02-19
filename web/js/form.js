$(document).ready( function() {
    
    displayMultipleRelationFrom();
    
    formMultiplePage();
    
    stylingForm();
    
    // init checkbox
	$("input[type=checkbox]").each( function() {
    	initCheckBox(this);
	});
	
	// Select a status
	$("form").on('click', 'div.icon', function() {
	    setCheckbox(this);
	});
    
    /*
	$('form input, form textarea').each( function() {
    	if($(this).attr('data-label')) {
    	    if(!$(this).val()) {
        	    $(this).removeClass('writeOn');
                $(this).addClass('writeOff');
                $(this).removeClass('labelOn');
                $(this).addClass('labelOff');
    	    } else {
        	    $(this).removeClass('writeOff');
                $(this).addClass('writeOn');
                $(this).removeClass('labelOff');
                $(this).addClass('labelOn');
    	    }
        }
	});
	
	
	$('form').submit(function() {
        
        $('form input, form textarea').each( function() {
            var label = $(this).attr('data-label');
            if($(this).val() == label) {
                $(this).val('');
            }
        });
        
        return true;
    });
    
	
	$("input[type='text']").click(function () {
	    var label = $(this).attr('data-label');
        if($(this).val() == label) {
            $(this).select();
        }
    });
    
    $('form input, form textarea').each( function() {
        if($(this).attr('data-label')) {
            if(!$(this).val()) {
                var label = $(this).attr('data-label');
                var input = $(this);
                $(this).val(label);
                $(this).removeClass('labelOff');
                $(this).addClass('labelOn');
            }
        }
    });
    */
    
    $('form.person fieldset.header input.resize').autoGrowInput();
    
    /*
    $('form').on('focus', '.labelOn', function() {
        var label = $(this).attr('data-label');
        if($(this).val() == label) {
            $(this).removeClass('labelOn');
            $(this).addClass('labelOff');
        }
    });
    
    $('form').on('blur', '.labelOff, .labelOn', function() {
        if($(this).val() == "") {
            var label = $(this).attr('data-label');
            $(this).val(label);
            $(this).removeClass('labelOff');
            $(this).addClass('labelOn');  
        }
    });
	
	$('form').on("keyup", 'input, textarea', function() {	
		 var label = $(this).attr('data-label');
         if($(this).val() == label) {
    		 $(this).removeClass('writeOn');
             $(this).addClass('writeOff');
		 } else {
    		 $(this).removeClass('writeOff');
    		 $(this).addClass('writeOn'); 
		 }
	});
	*/
	
	$('form.person fieldset.header').on("keyup", 'input.resize', function() {
    	$(this).autoGrowInput();
	});
	
	$("form").on("click", "nav.sub_nav a", function() {
    	event.preventDefault();
    	var id = $(this).attr("id");
    	switchFieldset(id);
	});
	
	$("form").on("focusout", "input[type=datetime]", function() {
    	var value = $(this).val();
    	var date = stringToDate(value);
    	
    	if(date != null) {
    	    
    	    
        	date = Date.parse(date).toString("d MMMM yyyy");
        	value = date;
        	
    	} else {
        	value = "";
    	}
    	
    	$(this).val(value);
    	$(this).autoGrowInput();
    	
	});
	
	$("form fieldset[data-prototype]").on("click", "#add", function(e) {
    	
    	e.preventDefault();
    	
    	var id = $(this).data("id");
    	
    	var container = $("fieldset #"+id);
    	
    	addEntityForm(container);
	});
	
});


function formMultiplePage() {
    $("fieldset.page").hide();
    $("fieldset.page:first").show();
    
    // Create a sub nav
    var htmlSubnav ='<nav class="sub_nav"><ul></ul></nav>';
    $("fieldset.header").after(htmlSubnav);
    
    var subnav = $("nav.sub_nav ul");
    
    $("fieldset.page").each( function(index) {
        var legend = $("legend", this).html();
        
        $(subnav).append('<li><a id="'+ (index+1) +'" href="#">'+ legend +'</a></li>');
        
        if(index == 0) {
            $("li a", subnav).addClass("current");
        }
    });
    
    $("fieldset.page > legend").remove();
}


function switchFieldset(id) {
    $("fieldset.page").hide();
    
    $("fieldset.page").each( function(index) {
        if(index == (id-1)) {
            $(this).show();
        }
    });
    
    $("nav.sub_nav a").removeClass("current");
    $("nav.sub_nav ul li:nth-of-type("+ id +") a").addClass("current");
}


function stylingForm() {
    $("input[type=datetime]").each( function() {
        var structure = $(this).data("structure");
        $(this).attr("placeholder", structure);
    });
}


/**
 * Display multiple relation form
 * 
 */
function displayMultipleRelationFrom() {
    
    $("form fieldset[data-prototype]").each( function() {
        
        var legend = $(this).data("legend");
        $(this).attr("id", legend);
        
        // Add the Legen
        $(this).append('<legend>' + legend + '</legend>');
        
        // Add the button new
    	var addButton = $('<a href="#" data-id="'+ legend +'" id="add" class="buttonRounded">Add a new '+ legend +'</a>');	
    	$(this).append(addButton);
    	
    	$(this).attr("data-nbField", "0");
    });
    
}


/**
 * Add an entity form
 * @param node container
 *
 */
function addEntityForm(container) {
    
    console.log(container);
    
    var index = $(container).data("nbfield");
    
    index++;
    
    var legend = $(container).data("legend");
    
    var prototype = $(container).data("prototype").replace(/__name__label__/g, legend + (index))
                                                  .replace(/__name__/g, index);
    
    var id = $(prototype).attr("id");
    
    console.log(index);
    
    // Add the Entity form
    $(container).append(prototype);
    
    $(container).data("nbfield", index);
    
}



function deleteEntityForm() {
    
}


function stringToDate(string) {
    
    var dayOK = false;
    var monthOK = false;
    var yearOK = false;
    
    var reg=new RegExp("[ ,;/.]+", "g");
    
    var date = string.split(reg);
    
    if(0 < date[0] < 32) {
        dayOK = true;
    };
    
    if(Date.parse(date[1])) {
        //correctMonth = Date.parse(date[1]);
        monthOK = true;
    }
    
    if(date.length > 1 && !monthOK) {
        date[1] = removeDiacritics(date[1]);
    
        var month = 
        {
            janvier:    1,
            fevrier:    2,
            mars:       3,
            avril:      4,
            mai:        5,
            juin:       6,
            juillet:    7,
            aout:       8,
            septembre:  9,
            octobre:    10,
            novembre:   11,
            decembre:   12,
            january:    1, 
            february:   2, 
            march:      3, 
            april:      4, 
            may:        5, 
            june:       6,
            july:       7,
            august:     8,
            september:  9,
            october:    10,
            november:   11,
            december:   12,
            januar:     1, 
            februar:    2,
            marz:       3,
            april:      4,
            Mai:        5,
            Juni:       6,
            Juli:       7,
            August:     8,
            September:  9,
            Oktober:    10,
            November:   11,
            Dezember:   12,
        }
        
        var noMonth = month[date[1]];
        
        if(0 < noMonth < 13) {
            monthOK = true;
            date[1] = noMonth;
        };
    }
    
    if(date.length > 2) {
        if(date[2] > 0) {
            yearOK = true;
        };
    } else {
        year = new Date().toString("yyyy");
        date[2] = year;
        yearOK = true;
    }
    
    
    
    if(dayOK && monthOK && yearOK) {
        
        day = date[0];
        date[0] = date[1];
        date[1] = day;
        
        return date.toString();
    } else {
        return null;
    }
    
}


