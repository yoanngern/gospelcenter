// @codekit-append "_selectMultiple.js"
// @codekit-append "vendor/removeDiacritics.js"
// @codekit-append "_selectList.js"

Handlebars.registerHelper("simpleDate", function (datetime) {
    var date = new Date(datetime);

    return $.format.date(date, "dd MMMM yyyy");
});

$(document).ready(function () {

    $("input[type='checkbox']").each(function () {
        var label = $(this).attr("placeholder");

        var value = $(this).prop("checked");

        var box = '<div class="checkbox"></div>';
        var html = '<div class="box"><div class="chip"></div></div><label>' + label + '</label>';

        $(this).wrap(box);
        $(this).after(html);

        if (value) {
            $(this).parent().attr("data-checked", true);
        } else {
            $(this).parent().attr("data-checked", false);
        }

    });


    $("div[data-prototype]").each(function () {
        setCollection(this);
    });


    $("form").on('click', '#addItem', function (event) {

        event.preventDefault();

        var elem = $(this).parent();

        addItem(elem);
    });


    $("div.radio").each(function () {

        $(this).find('input[type="radio"]').each(function () {

            var id = $(this).attr("id");

            var label = $('label[for="' + id + '"]');

            var box = '<div class="radio-checkbox"></div>';
            var html = '<div class="box"><div class="chip"></div></div>';

            $(this).wrap(box);
            $(this).after(html);

            $(this).parent().append(label);

            var value = $(this).prop("checked");

            if (value) {
                $(this).parent().attr("data-checked", true);
            } else {
                $(this).parent().attr("data-checked", false);
            }

        });

    });


    $("form").on('click', 'div.checkbox', function () {

        var input = $(this).find("input[type='checkbox']");

        var value = input.prop("checked");

        if (value) {
            input.prop("checked", false);
            $(this).attr("data-checked", false);
        } else {
            input.prop("checked", true);
            $(this).attr("data-checked", true);
        }

    }).on('click', 'div.radio-checkbox', function () {

        var container = $(this).parent();

        var input = $(this).find("input[type='radio']");

        var value = input.prop("checked");

        if (value) {
            //input.prop("checked", false);
        } else {
            input.prop("checked", true);
        }

        $(container).find(".radio-checkbox").each(function () {

            var valueLocal = $(this).find('input[type="radio"]').prop("checked");

            if (valueLocal) {
                $(this).attr("data-checked", true);
            } else {
                $(this).attr("data-checked", false);
            }

        });
    });

});


function setCollection(elem) {

    var addLabelFirst = $(elem).attr("data-add_first");
    var addLabel = $(elem).attr("data-add");

    var nbItem = $(elem).find('> div').length;

    $(elem).attr("data-nbItem", nbItem);

    if (nbItem === 0) {

        var addItemLink = $('<a href="#" id="addItem" class="button">' + addLabelFirst + '</a>');

    } else {

        var addItemLink = $('<a href="#" id="addItem" class="button">' + addLabel + '</a>');

        $(elem).children('div').each(function () {
            addRemoveLink(this);
        });
    }

    $(elem).append(addItemLink);
}


function addItem(elem) {

    var nbItem = $(elem).attr("data-nbItem");
    var labelName = $(elem).attr("data-label");

    var addLabel = $(elem).attr("data-add");

    $("#addItem", elem).html(addLabel);

    nbItem = parseInt(nbItem);

    var prototype = $(elem).attr('data-prototype').replace(/__name__label__/g, labelName + ' ' + nbItem).replace(/__name__/g, nbItem);

    $("#addItem", elem).before(prototype);

    var newElem = $("> div", elem).last();

    addRemoveLink(newElem);

    $(elem).attr("data-nbItem", nbItem + 1);
}


function addRemoveLink(elem) {

    var container = $(elem).parent();

    var deleteLabel = $(container).attr("data-remove");

    $removeLink = $('<a href="#" class="delete">' + deleteLabel + '</a>');

    $(elem).prepend($removeLink);

    $removeLink.click(function (event) {
        elem.remove();
        event.preventDefault();
        return false;
    });
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

    text = jQuery.grep(text, function (value) {
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

$.fn.arrayFind = function (obj, fromIndex) {
    if (fromIndex == null) fromIndex = 0;
    else if (fromIndex < 0) fromIndex = Math.max(0, this.length + fromIndex);

    arr = $.makeArray(this);
    for (var i = fromIndex, j = arr.length; i < j; i++) {
        if (arr[i].indexOf(obj) > -1) return i;
    }

    return -1;
};