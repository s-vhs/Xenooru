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

function flagForDeletion(postId) {
    const input = prompt("Why should this post be deleted?");

    if (input) {
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: {
                deletionFlag: postId,
                reason: input
            },
            success: function (response) {
                if (response == "flagged") {
                    alert("Success!");
                    let deletion = document.getElementById("deletionFlag");
                    addClass(deletion, "hidden");
                } else {
                    alert(response);
                }
            },
            error: function () {
                alert("Error!");
            }
        });
    } else {
        alert("Canceled!");
    }
}

function deletePost(postId) {
    const input = prompt("Why are you deleting this post?");

    if (input) {
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: {
                deletePost: postId,
                reason: input
            },
            success: function (response) {
                if (response == "deleted") {
                    alert("Success!");
                    location.reload();
                } else {
                    alert(response);
                }
            },
            error: function () {
                alert("Error!");
            }
        });
    } else {
        alert("Canceled!");
    }
}

function recoverPost(postId) {
    if (confirm("Are you sure you want to recover this post?")) {
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: {
                recoverPost: postId
            },
            success: function (response) {
                if (response == "recovered") {
                    alert("Success!");
                    location.reload();
                } else {
                    alert(response);
                }
            },
            error: function () {
                alert("Error!");
            }
        });
    } else {
        alert("Canceled!");
    }
}