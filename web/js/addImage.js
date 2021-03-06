$(document).ready( function() {
	
	// Input file initialization
	$("input[type=file]").each( function() {
    	initInputFile(this);
	});
	
	// addImage is clicked
	$("form").on('click', '#addImage', function() {
    	
    	var id = $(this).data("input");
    	
    	$("input[id="+ id +"]").click();
	});
	
	$("input[type=file]").change( function() {
    	showPreview(this);
	});
	
	$("form").bind('#addImage', 'paste', function (e) {
		
		var id = $(this).data("input");
		
		setTimeout(function () {
			var image = e.target.value;
			
			$("input[id="+ id +"]").val(image);
		}, 0)
	});
	
	
	$("form").on('dragenter', '#addImage, img', function() {
            
            if($(".newImg") != null) {
                
                var width = $("img.newImg").width();
                var height = $("img.newImg").height();
                
                $("#addImage").width(width);
                $("#addImage").height(height);
                
                $("form img").fadeOut();
                $("#addImage").show();
            
            }
            
            
            $(this).addClass("hover");
            return false;
    });
     
    $("form").on('dragover', '#addImage', function(event){
        event.preventDefault();
        event.stopPropagation();
        
        $("#addImage").show();
        $("form img").remove();
        
        $(this).addClass("hover");
        return false;
    });
     
    $("form").on('dragleave', '#addImage', function(event) {
        event.preventDefault();
        event.stopPropagation();
        $(this).removeClass("hover");
        return false;
    });
    
    
    $("form").on('drop', '#addImage', function(event) {
        
        var id = $(this).data("input");
        
        event.stopPropagation();
        event.preventDefault();
        
        var dt = event.originalEvent.dataTransfer;
        var files = dt.files;
        
        //handleFiles(files);
        
        $("input[id="+ id +"]").prop("files", event.originalEvent.dataTransfer.files);
    });
	
});


function initInputFile(input) {
    
    $(input).hide();
    
    var id = $(input).attr("id");
    
    var div = '<div id="addImage" data-input="'+ id +'"><div class="iconImg"></div><div class="txt">Drop the image here.</div></div>';
    
    $(input).after(div);
}


function handleFiles(files) {
    
    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        var imageType = /image.*/;
        
        if (!file.type.match(imageType)) {
            continue;
        }
        
        var img = document.createElement("img");
        img.classList.add("obj");
        img.file = file;
        
        var reader = new FileReader();
        reader.onload = (function(aImg) { return function(e) { aImg.src = e.target.result; }; })(img);
        
        reader.readAsDataURL(file);
    }
}


function showPreview(input) {
    
    var id = $(input).attr("id");
    
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            
            var image = e.target.result;
            
            $("#addImage[data-input="+ id +"]").after('<img class="newImg" src="'+ image +'" alt="preview"/>');
        }

        reader.readAsDataURL(input.files[0]);
    }
    
    $("#addImage[data-input="+ id +"]").hide();
}