// @codekit-append "form.js"

locations = [];
speakers = [];

$(document).ready( function() {
	
	var locationContainer = $("#gospelcenter_celebrationbundle_celebration_location");
	var speakersContainer = $("#gospelcenter_celebrationbundle_celebration_existingSpeakers");
	
	// Initialization
	locations = createLocationsList(locationContainer);
	speakers = createSpeakersList(speakersContainer);
	initLocationSearch(locationContainer);
	initSpeakerSearch(speakersContainer);
	
	initSpeakerList(speakersContainer);
	initLocationList(locationContainer);
	
	
	// Location search is edited
	$("form").on('keyup', '#locationSearch', function() {
    	locationSearch($(this).val());
	});
	
	// Select a location
	$("form").on('click', 'ul.location li', function() {
    	addLocation($(this).attr("id"));
	});
	
	// Remove a location
	$("form").on('click', '#removeLocation', function() {
        removeLocation($(this).data('location'));
	});
	
	// Speaker search is edited
	$("form").on('keyup', '#speakersSearch', function() {
    	speakerSearch($(this).val());
	});
	
	// Select a speaker
	$("form").on('click', 'ul.speaker li', function() {
    	addSpeaker($(this).attr("id"));
	});
	
	// Add another speaker
	$("form").on('click', '#addSpeaker', function() {
        initSpeakerSearch(speakersContainer);
	});
	
	// Remove a speaker
	$("form").on('click', '#removeSpeaker', function() {
        removeSpeaker($(this).data('speaker'));
	});
});


function initSpeakerList(select) {
    
    $('option[selected="selected"]', select).each( function() {
        
        addSpeaker($(this).val());
    });
}

function initLocationList(select) {
    
    $('option[selected="selected"]', select).each( function() {
        
        addLocation($(this).val());
    });
}


/**
 *  create an array of locations
 *  @param select locations
 *  @return allLocations array
 */
function createLocationsList(select) {
    
    var allLocations = [];
    
    $("option", select).each( function() {
    	if($(this).val()) {
    	    var aLocation = [];
    	    aLocation['id'] = $(this).val();
    	    aLocation['name'] = $(this).text();
    	    
    	    var text = stringToText($(this).text());
    	    
    	    aLocation['text'] = text;
    	    
    	    allLocations.push(aLocation);
        }
	});
	
	return allLocations;
}


/**
 *  input search location initialization
 *  @param locationList
 */
function initLocationSearch(locationList) {
    $(locationList).hide();
    
    var html = '<input autocomplete="off" type="text" id="locationSearch" placeholder="search...">';
    
    $(locationList).after(html);
}


/**
 *  show location found
 *  @param value of the input search
 */
function locationSearch(value) {
    
    var html = '';
    
    value = value.toLowerCase();
    
    $(locations).each( function() {
        
        var pos = $(this['text']).arrayFind(value);
        
        if(pos >= 0) {
            html += '<li id="'+ this['id'] +'">'+ this['name'] +'</li>';
        }
    });
    
    if($("ul.location").length) {
        $("ul.location li").remove();
        $("ul.location").append(html);
    } else {
        html = '<ul class="location">'+ html +'</ul>'
        $("#locationSearch").after(html);
    }
    
    console.log("search...");
    
}


/**
 *  add a location
 *  @param id of the location
 */
function addLocation(id) {
    
    var locationContainer = $("#gospelcenter_celebrationbundle_celebration_location");
    
    $("option", locationContainer).attr("selected", false);
    	
    $("option[value="+ id +"]", locationContainer).attr("selected", true);
    
    getLocation(id);
}


/**
 *  get a location
 *  @param id of the location
 */
function getLocation(id) {
    
    var url = "/api/locations/" + id;
    
    $.ajax({
        type: "GET",
        dataType: "json",
        url: url,
        error: function () {
            console.log("error");
        },
        success: function (data) {
            showLocationDetails(data[0]);
        }
    });
    
}


/**
 *  show location details
 *  @param location data
 */
function showLocationDetails(location) {
    
    html = '<article data-location="'+ location.id +'"><h1>'+ location.name +'</h1><p>'+ location.address1 +'</p>';
    if(location.address2 != null) {
        html += '<p>'+ location.address2 +'</p>';
    }
    html += '<p>'+ location.postalCode +' '+  location.city +'</p><p>'+ location.country +'</p>';
    html += '<span id="removeLocation" class="action" data-location="'+ location.id +'">Remove</span>';
    html += '</article>';
    
    
    
    var locationContainer = $("#gospelcenter_celebrationbundle_celebration_location");
    
    $(locationContainer).before(html);
    
    $("#locationSearch").remove();
    
    $("ul.location").remove();
    
}


/**
 *  remove the location
 */
function removeLocation(id) {
    
    $("form article[data-location="+ id +"]").remove();
    
    var locationContainer = $("#gospelcenter_celebrationbundle_celebration_location");
    
    $("option[value="+ id +"]", locationContainer).attr("selected", false);
    
    initLocationSearch(locationContainer);
    
}


/**
 *  create an array of speakers
 *  @param select speakers
 *  @return allSpeakers array
 */
function createSpeakersList(select) {
    
    var allSpeakers = [];
    
    $("option", select).each( function() {
    	if($(this).val()) {
    	    var aSpeaker = [];
    	    aSpeaker['id'] = $(this).val();
    	    aSpeaker['name'] = $(this).text();
    	    
    	    var text = stringToText($(this).text());
    	    
    	    aSpeaker['text'] = text;
    	    
    	    allSpeakers.push(aSpeaker);
        }
	});
	
	return allSpeakers;
}


/**
 *  input search speakers initialization
 *  @param speakersList
 */
function initSpeakerSearch(speakersList) {
    $(speakersList).hide();
    
    var html = '<input autocomplete="off" type="text" id="speakersSearch" placeholder="search...">';
    
    $(speakersList).after(html);
}







/**
 *  show speakers found
 *  @param value of the input search
 */
function speakerSearch(value) {
    
    var html = '';
    
    value = value.toLowerCase();
    
    $(speakers).each( function() {
        
        var pos = $(this['text']).arrayFind(value);
        
        if(pos >= 0) {
            html += '<li id="'+ this['id'] +'">'+ this['name'] +'</li>';
        }
    });
    
    if($("ul.speaker").length) {
        $("ul.speaker li").remove();
        $("ul.speaker").append(html);
    } else {
        html = '<ul class="speaker">'+ html +'</ul>'
        $("#speakersSearch").after(html);
    }
    
}


/**
 *  add a speaker
 *  @param id of the speaker
 */
function addSpeaker(id) {
    
    var speakersContainer = $("#gospelcenter_celebrationbundle_celebration_existingSpeakers");
    	
    $("option[value="+ id +"]", speakersContainer).attr("selected", true);
    
    getSpeaker(id);
}


/**
 *  get a speaker
 *  @param id of the speaker
 */
function getSpeaker(id) {
    
    var url = "/api/speakers/" + id;
    
    $.ajax({
        type: "GET",
        dataType: "json",
        url: url,
        error: function () {
            console.log("error");
        },
        success: function (data) {
            showSpeakerDetails(data[0]);
        }
    });
    
}


/**
 *  show speaker details
 *  @param speaker data
 */
function showSpeakerDetails(speaker) {
    
    html = '<article data-speaker="'+ speaker.person.id +'"><h1>'+ speaker.person.firstname +' '+ speaker.person.lastname +'</h1>';
    if(speaker.person.function != null) {
        html += '<p>'+ speaker.person.function +'</p>';
    }
    html += '<span id="removeSpeaker" class="action" data-speaker="'+ speaker.person.id +'">Remove</span>';
    html += '<span id="addSpeaker" class="action">Add another</span>';
    html += '</article>';
    
    var speakersContainer = $("#gospelcenter_celebrationbundle_celebration_existingSpeakers");
    
    $(speakersContainer).before(html);
    
    $("#speakersSearch").remove();
    
    $("ul.speaker").remove();
    
}


/**
 *  remove a speaker
 *  @param id of the speaker
 */
function removeSpeaker(id) {
    
    $("form article[data-speaker="+ id +"]").remove();
    
    var speakersContainer = $("#gospelcenter_celebrationbundle_celebration_existingSpeakers");
    
    $("option[value="+ id +"]", speakersContainer).attr("selected", false);
    
    
    var isSpeakerSelected = false;
    $("option", speakersContainer).each(function(){
        if ($(this).attr('selected')) {
            isSpeakerSelected = true;
        }
    });
    
    if(!isSpeakerSelected) {
        initSpeakerSearch(speakersContainer);
    }
    
}


/**
 *  string to text
 *  @param string
 *  @return text array
 */
function stringToText(string) {
    
    string = string.toLowerCase();
    
    string = removeDiacritics(string);
    
    var text = whitespaceTokenizer(string);
    
    text = jQuery.grep(text, function(value) {
        return value != '';
    });

    return text;
}


/**
 *  white space Tokenizer
 *  @param string
 *  @return text array
 */
function whitespaceTokenizer(string) {
    
    var reg = new RegExp("[ ,;/.!-]+", "g");
    
    var text = string.split(reg);
    
    return text;
}

$.fn.arrayFind = function(obj, fromIndex) {
	if(fromIndex == null) fromIndex = 0;
	else if(fromIndex < 0) fromIndex = Math.max(0, this.length + fromIndex);
	
	arr = $.makeArray(this);
	for(var i = fromIndex, j = arr.length; i < j; i++) {
		if(arr[i].indexOf(obj) > -1) return i;
	}
	
	return -1;
};