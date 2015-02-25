$(document).ready( function() {
	
	// Input file initialization
	$("div#editImage").each( function() {
    	initInputFile(this);
	});
	
	// editImage is clicked
	$("form").on('click', '#editImage', function() {
    	var id = $(this).data("input");
    	$("input[id="+ id +"]").click();
	});
	
	$("input[type=file]").change( function() {
    	showPreview(this);
	});
});


function initInputFile(container) {

    var id = $(container).attr("data-input");


    var input = $("input[id="+ id +"]");

    $(input).hide();

    var div = '<div class="edit">Change the image</div>';

    $(container).append(div);

}


function showPreview(input) {

    var id = $(input).attr("id");

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {

            var image = e.target.result;

            var editImage = $("#editImage[data-input="+ id +"]");

            $("img", editImage).remove();
            $(editImage).prepend('<img class="newImg" src="'+ image +'" alt="preview"/>');
        }

        reader.readAsDataURL(input.files[0]);
    }
}