$(document).ready(function () {

    $("form").on('keyup', 'section.selectList input.search', function () {

        searchSelectList($(this).val(), $(this).parent().parent());

    });

});


/**
 * selectItemSelectList
 * @param item
 */
function selectItemSelectList(item) {

    var container = $(item).parent();

    var input_id = $(container).parent().attr("data-input_id");

    $("li.item", container).removeClass("selected");

    $(item).addClass("selected");

    var id = $(item).attr("data-id");

    $("#" + input_id).val(id);
}


/**
 * selectItemSelectMultipleList
 * @param item
 */
function selectItemSelectMultipleList(item) {

    var container = $(item).parent();
    var input_id = $(container).parent().attr("data-input_id");
    var select = $("#" + input_id);
    var id = $(item).attr("data-id");


    if($(item).hasClass("selected")) {
        $(item).removeClass("selected");

        $("option[value="+ id +"]", select).attr("selected", false);

    } else {
        $(item).addClass("selected");

        $("option[value="+ id +"]", select).attr("selected", true);

    }

}


/**
 * printSelectList
 * @param container
 * @param items
 * @param input_id
 */
function printSelectList(container, items, input_id) {

    var id = $(container).attr("data-default_id");
    var title = $(container).attr("data-title");

    var context = {
        title: title,
        items: items
    };

    var source = $("#selectList").html();
    var template = Handlebars.compile(source);
    var html = template(context);

    $(container).html(html);

    $(container).attr("data-input_id", input_id);

    var elem = $("#" + input_id);

    $(elem).hide();

    if($(elem).is("input")) {

        $("li.item", container).each(function () {
            if ($(this).attr("data-id") == $(elem).val()) {
                selectItemSelectList(this);
            }
        });
    }

    if($(elem).is("select")) {

        $('option[selected="selected"]', elem).each( function() {

            var item = $('li[data-id="' + $(this).val() + '"]', container);

            selectItemSelectMultipleList(item);
        });
    }



}


/**
 * addItemSelectList
 * @param name
 * @param item
 */
function addItemSelectList(name, item) {

    $(selectList).each(function () {
        if (this.name == name) {
            this.text.push(item);
        }
    });

}


/**
 * filterSelectList
 * @param selectList
 * @param itemFound
 */
function filterSelectList(selectList, itemFound) {

    $("li.item", selectList).addClass("hide");

    $("li.item", selectList).each(function () {

        var id = $(this).attr("data-id");

        id = parseInt(id);

        var pos = $.inArray(id, itemFound);

        if (pos >= 0) {
            $(this).removeClass("hide");
        }
    });

}


/**
 * searchSelectList
 * @param value
 * @param container
 */
function searchSelectList(value, container) {

    value = value.toLowerCase();

    value = removeDiacritics(value);

    var itemFound = [];

    var name = $(container).attr("id");

    var match = [];

    $(selectList).each(function () {

        if (this.name == name) {
            match = this.text;
        }
    });

    $(match).each(function () {

        var pos = $(this.text).arrayFind(value);

        if (pos >= 0) {
            itemFound.push(this.id);
        }
    });

    filterSelectList(container, itemFound);

}