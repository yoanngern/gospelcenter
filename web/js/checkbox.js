/**
 *  Checkbox initialization
 *  @param checkbox
 */
function initCheckBox(checkbox) {
    $(checkbox).parent().addClass("checkbox");
    
    var name = $(checkbox).data("icon");
    
    $(checkbox).after('<div id="'+ name +'" class="icon"></div>');
    
    if($(checkbox).attr('checked')) {
        $("div[id="+ name +"]").addClass('selected');
    }
    
    $(checkbox).hide();
}


/**
 *  setCheckbox
 *  @param icon clicked
 */
function setCheckbox(icon) {
    
    var name = $(icon).attr("id");
    
    console.log(name);
    
	if($(icon).hasClass('selected')) {
    	$(icon).removeClass('selected');
	} else {
    	$(icon).addClass('selected');
	}
	
	if($("input[data-icon="+ name +"]").attr('checked')) {
        $("input[data-icon="+ name +"]").prop('checked', false);
    } else {
        $("input[data-icon="+ name +"]").prop('checked', true);
    }
}