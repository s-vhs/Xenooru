function fill(Value) {
    $('#search').val($('#search').val() + Value);
    $("#search").focus();
    $('#display').hide();
}

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