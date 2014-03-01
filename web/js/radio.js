/**
 *  Radio initialization
 *  @param container
 */
function initRadio(container) {
    
    $(container).parent().addClass("radio");
    
    var name = $(container).data("icon");
    
    var html = '<div id="'+ name +'" class="radio-icon">';
    
    $("input[type=radio]", container).each( function() {
        var value = $(this).val();
        
        var selected = "";
        
        if($(this).attr('checked')) {
            selected = "selected";
        }
        
        html += '<div id="'+ value +'" class="'+ selected +'"></div>';
    });
    
    html += '</div>';
    
    $(container).after(html);
    
    $(container).hide();
}



/**
 *  setRadio
 *  @param icon clicked
 */
function setRadio(icon) {
    
    var name = $(icon).parent().attr("id");
    var value = $(icon).attr("id");
    
    var icons = $(icon).parent();
    
    $("div", icons).each( function() {
        $(this).removeClass("selected");
    });
    
	if($(icon).hasClass('selected')) {
    	$(icon).removeClass('selected');
	} else {
    	$(icon).addClass('selected');
	}
	
	if($("div[data-icon="+ name +"] input[value="+ value +"]").attr('checked')) {
        $("div[data-icon="+ name +"] input[value="+ value +"]").prop('checked', false);
    } else {
        $("div[data-icon="+ name +"] input[value="+ value +"]").prop('checked', true);
    }
}