function fill(Value, search = "search", display = "display", Current = "tag:") {
    let inputField = document.getElementById(search);
    let cursorPosition = getCursorPosition(inputField);
    deleteCharactersBeforePosition(inputField, cursorPosition, Current.length);

    $("#" + search).val($("#" + search).val() + Value);
    $("#" + display).hide();
    $("#" + search).focus();
}

function getCursorPosition(inputField) {
    if (inputField.selectionStart) {
        return inputField.selectionStart;
    } else if (document.selection) {
        inputField.focus();
        let range = document.selection.createRange();
        range.moveStart('character', -inputField.value.length);
        return range.text.length;
    }
    return 0;
}

function deleteCharactersBeforePosition(inputField, position, numberOfCharacters) {
    let currentValue = inputField.value;
    let newValue = currentValue.substring(0, position - numberOfCharacters) + currentValue.substring(position);
    inputField.value = newValue;
    inputField.setSelectionRange(position - numberOfCharacters, position - numberOfCharacters);
}


function doSearch(search = "search", display = "display") {
    let name = $("#" + search).val();
    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: {
            search: name,
            item: search,
            display: display
        },
        success: function (html) {
            $("#" + display).html(html).show();
        }
    });
}

function votePostUp(id) {
    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: {
            voteUp: id
        },
        success: function (json) {
            let text = JSON.parse(json);
            $("#voteDiv").html(text[0]).show();
            $("#scoreCount").html(text[1]);
        }
    });
}

function votePostDown(id) {
    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: {
            voteDown: id
        },
        success: function (json) {
            let text = JSON.parse(json);
            $("#voteDiv").html(text[0]).show();
            $("#scoreCount").html(text[1]);
        }
    });
}

function addToFavs(id) {
    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: {
            addFavs: id
        },
        success: function (text) {
            $("#favouriteText").text(text);
            changeAttribute("favouriteText", "onclick", "removeFromFavs(" + id + ")");
        }
    });
}

function removeFromFavs(id) {
    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: {
            removeFavs: id
        },
        success: function (text) {
            $("#favouriteText").html(text);
            changeAttribute("favouriteText", "onclick", "addToFavs(" + id + ")");
        }
    });
}

function changeAttribute(elementID, attributeName, attributeValue) {
    let element = document.getElementById(elementID);
    element.setAttribute(attributeName, attributeValue);
}


function toggleDiv(id) {
    const div = document.getElementById(id);
    const isHidden = div.classList.contains('hidden');

    div.classList.remove(isHidden ? 'hidden' : 'block');
    div.classList.add(isHidden ? 'block' : 'hidden');
}
