function fill(Value) {
    $('#search').val($('#search').val() + Value);
    $('#display').hide();
    $("#search").focus();
}

// Search
$(document).ready(function () {
    $("#search").keyup(function () {
        let name = $('#search').val();
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: {
                search: name
            },
            success: function (html) {
                $("#display").html(html).show();
            }
        });
    });
});

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