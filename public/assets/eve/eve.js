function fill(Value, search = "search", display = "display") {
    $("#" + search).val($("#" + search).val() + Value);
    $("#" + display).hide();
    $("#" + search).focus();
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

function toggleDiv(id) {
    let div = document.getElementById(id);
    if (div.classList.contains("hidden")) {
        div.classList.remove("hidden");
        div.classList.add("block");
    } else {
        div.classList.remove("block");
        div.classList.add("hidden");
    }
}