// @codekit-append "_date.js"
// @codekit-append "vendor/jquery.elastic.source.js"
// @codekit-append "vendor/autoGrowInput.js"
// @codekit-append "vendor/removeDiacritics.js"
// @codekit-append "_checkbox.js"
// @codekit-append "_radio.js"
// @codekit-append "_selectMultiple.js"


$(document).ready( function() {
    
    displayMultipleRelationFrom();
    
    formMultiplePage();
    
    stylingForm();
    
    
    
    // init checkbox
	$("input[type=checkbox][data-icon]").each( function() {
    	initCheckBox(this);
	});
	
	// init checkbox
	$("input[type=radio]").parent().each( function() {
    	initRadio(this);
	});
	
	// init date
	$("input[type=datetime]").each( function() {
    	setDateTime(this);
	});
	
	// Select a status
	$("form").on('click', 'div.icon', function() {
	    setCheckbox(this);
	});
	
	// Select a status
	$("form").on('click', 'div.radio-icon div', function() {
	    setRadio(this);
	});
    
    $('form.person fieldset.header input.resize').autoGrowInput();
    
    
	$('form.person fieldset.header').on("keyup", 'input.resize', function() {
    	$(this).autoGrowInput();
	});
	
	$("form").on("click", "nav.sub_nav a", function(event) {
    	event.preventDefault();
    	var id = $(this).attr("id");
    	switchFieldset(id);
	});
	
	$("form").on("focusout", "input[type=datetime]", function() {
    	setDateTime(this);
	});
	
	$("form fieldset[data-prototype]").on("click", "#add", function(event) {
    	
    	event.preventDefault();
    	
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


function setDateTime(input) {
    
    var value = $(input).val();

    var date = stringToDate(value);
        
    if(date != null) {
	    
    	date = Date.parse(date).toString("d MMMM yyyy");
    	value = date;
    	
	} else {
    	value = "";
	}
	
	$(input).val(value);
	
	if($(input).hasClass("resize")) {
    	$(input).autoGrowInput();
	}
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

    
    var index = $(container).data("nbfield");
    
    index++;
    
    var legend = $(container).data("legend");
    
    var prototype = $(container).data("prototype").replace(/__name__label__/g, legend + (index))
                                                  .replace(/__name__/g, index);
    
    var id = $(prototype).attr("id");
    
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


