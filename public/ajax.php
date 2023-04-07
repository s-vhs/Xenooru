<?php

require "../autoload.php";

if (isset($_POST["search"])) {
    $_tag = array_reverse(explode(" ", clean($_POST["search"])));
    $search = clean($_POST["item"] ?? "");
    $display = clean($_POST["display"] ?? "");
    $_tag = $_tag[0];
    if ($usertheme == "eve") {
        echo "<ul class=\"text-sm\">";
        if (strlen($_tag) > 1) {
            $tags = $db["tags"]->createQueryBuilder()
                ->search(["full"], $_tag)
                ->orderBy(["name" => "ASC"]) // sort result
                ->getQuery()
                ->fetch();
            if (!empty($tags)) {
                foreach ($tags as $tag) {
                    if ($tag["order"] == 1)
                        $color = "fuchsia";
                    elseif ($tag["order"] == 2)
                        $color = "lime";
                    elseif ($tag["order"] == 3)
                        $color = "indigo";
                    elseif ($tag["order"] == 4)
                        $color = "red";
                    else
                        $color = "orange";
                    echo "<li onclick=\"fill('" . $tag["full"] . " ', '{$search}', '{$display}', '{$_tag}')\" class=\"text-{$color}-500 cursor-pointer\">" . str_replace("_", " ", $tag["name"]) . " (" . count($db["tagRelations"]->findBy([["name", "==", $tag["name"]], "AND", ["type", "==", $tag["type"]]])) . ")</li>";
                }
            } else {
                echo "<li>Nothing found...</li>";
            }
        } else {
            echo "<li>At least two characters...</li>";
        }
        echo "</ul>";
    }
}

if (isset($_POST["voteUp"])) {
    if (!$userlevel["perms"]["can_vote_post"]) die(json_encode(["Missing permission!", null])) && doLog("upvote", false, "missing permission.", null);
    // Right now, this needs the user to be logged in. I have to rewrite this using IP instead of UID in case no account required to vote
    $id = clean($_POST["voteUp"]);
    if (!is_numeric($id)) die(json_encode(["Invalid ID!", null]));
    $post = $db["posts"]->findById($id);
    if (empty($post)) die(json_encode(["Post not found!", null])) && doLog("upvote", false, "post not found.", $user["_id"]);
    if (empty($db["postVotes"]->findBy([["post", "=", $post["_id"]], "AND", ["user", "=", $user["_id"]], "AND", ["vote", "=", "up"]]))) {
        $deleted = false;
        if (!empty($db["postVotes"]->findBy([["post", "=", $post["_id"]], "AND", ["user", "=", $user["_id"]], "AND", ["vote", "=", "down"]]))) $db["postVotes"]->deleteBy([["post", "=", $post["_id"]], "AND", ["user", "=", $user["_id"]], "AND", ["vote", "=", "down"]]) && $deleted = true;
        $score = $post["score"] + ($deleted ? 2 : 1);
        $db["posts"]->updateById($post["_id"], ["score" => $score]);
        $data = array(
            "post" => $post["_id"],
            "user" => $user["_id"],
            "username" => $user["username"],
            "vote" => "up",
            "timestamp" => now()
        );
        $vote = $db["postVotes"]->insert($data);
        if (!$vote) die(json_encode(["Something went wrong and I don't know what.", $post["score"]])) && doLog("upvote", false, "final step.", $user["_id"]);
        doLog("upvote", true, $post["_id"], $user["_id"]);
        doLog("upvote", true, $post["_id"], $user["_id"]);
        die(json_encode(["Voted up!", $score]));
    } else {
        die(json_encode(["Already voted up!", $post["score"]]));
    }
}

if (isset($_POST["voteDown"])) {
    if (!$userlevel["perms"]["can_vote_post"]) die(json_encode(["Missing permission!", null])) && doLog("downvote", false, "missing permission.", null);
    // Right now, this needs the user to be logged in. I have to rewrite this using IP instead of UID in case no account required to vote
    $id = clean($_POST["voteDown"]);
    $post = $db["posts"]->findById($id);
    if (empty($post)) die(json_encode(["Post not found!", null])) && doLog("downvote", false, "post not found.", $user["_id"]);
    if (empty($db["postVotes"]->findBy([["post", "=", $post["_id"]], "AND", ["user", "=", $user["_id"]], "AND", ["vote", "=", "down"]]))) {
        $deleted = false;
        if (!empty($db["postVotes"]->findBy([["post", "=", $post["_id"]], "AND", ["user", "=", $user["_id"]], "AND", ["vote", "=", "up"]]))) $db["postVotes"]->deleteBy([["post", "=", $post["_id"]], "AND", ["user", "=", $user["_id"]], "AND", ["vote", "=", "up"]]) && $deleted = true;
        $score = $post["score"] - ($deleted ? 2 : 1);
        $db["posts"]->updateById($post["_id"], ["score" => $score]);
        $data = array(
            "post" => $post["_id"],
            "user" => $user["_id"],
            "username" => $user["username"],
            "vote" => "down",
            "timestamp" => now()
        );
        $vote = $db["postVotes"]->insert($data);
        if (!$vote) die(json_encode(["Something went wrong and I don't know what.", $post["score"]])) && doLog("downvote", false, "final step.", $user["_id"]);
        doLog("downvote", true, $post["_id"], $user["_id"]);
        die(json_encode(["Voted down!", $score]));
    } else {
        die(json_encode(["Already voted down!", $post["score"]]));
    }
}

if (isset($_POST["addFavs"])) {
    if (!$logged) die("Not logged in!") && doLog("addFav", false, "not logged in.", null);
    if (!$userlevel["perms"]["can_manage_favourites"]) die("Missing permission!") && doLog("addFav", false, "missing permission.", $user["_id"]);
    $id = clean($_POST["addFavs"]);
    $post = $db["posts"]->findById($id);
    if (empty($post)) die() && doLog("addFav", false, "post not found.", $user["_id"]);
    if (empty($db["favourites"]->findOneBy([["post", "==", $id], "AND", ["user", "==", $user["_id"]]]))) {
        $data = [
            "post" => $id,
            "user" => $user["_id"],
            "username" => $user["username"],
            "timestamp" => now()
        ];
        $db["favourites"]->insert($data);
        doLog("addFav", true, $id, $user["_id"]);
        die($lang["remove_from_favourites"]);
    } else {
        die($lang["post_already_in_your_favorites"]);
    }
}

if (isset($_POST["removeFavs"])) {
    if (!$logged) die("Not logged in!") && doLog("removeFav", false, "not logged in.", null);
    if (!$userlevel["perms"]["can_manage_favourites"]) die("Missing permission!") && doLog("addFav", false, "missing permission.", $user["_id"]);
    $id = clean($_POST["removeFavs"]);
    $post = $db["posts"]->findById($id);
    if (empty($post)) die() && doLog("removeFav", false, "post not found.", $user["_id"]);
    if (!empty($db["favourites"]->findOneBy([["post", "==", $id], "AND", ["user", "==", $user["_id"]]]))) {
        $db["favourites"]->deleteBy([["post", "==", $id], "AND", ["user", "==", $user["_id"]]]);
        doLog("removeFav", true, $id, $user["_id"]);
        die($lang["add_to_favourites"]);
    } else {
        die($lang["post_already_removed_from_your_favorites"]);
    }
}
