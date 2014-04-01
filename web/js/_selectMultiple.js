$(document).ready( function() {
	initSlectMultiple();
	
	$("form").on('click', 'ul.selectMultiple li', function() {
    	setSelectOption(this);
	});
});

function setSelectOption(li) {
    
    var value = $(li).attr("id");
    var id = $(li).parent().data("select");
    
    $(li).toggleClass("selected");
    
    var select = $("select[id="+ id +"]");
    var option = $("option[value="+ value +"]", select);
    
    if($(option).prop("selected")) {
        $(option).attr("selected", false);
    } else {
        $(option).attr("selected", true);
    }
    
}

function initSlectMultiple() {
    $("select.selectMultiple[multiple=multiple]").each( function() {
        
        var selectId = $(this).attr("id");
        
        var source   = $("#selectMultiple").html();
        var template = Handlebars.compile(source);
        
        var options = [];
        
        $("option", this).each( function() {
            
            var option = [];
            
            if($(this).attr("selected")) {
                option['selected'] = 'selected';
            } else {
                option['selected'] = '';
            }
            
            option['id'] = $(this).attr("value");
            option['text'] = $(this).text();
            
            options.push(option);
        });
        
        var context = {
            selectId: selectId,
            options: options
        }
        
        var html    = template(context);
        
        $(this).after(html);
        $(this).hide();
    });
}