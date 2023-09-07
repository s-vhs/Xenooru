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
    if (!$userlevel["perms"]["can_vote_post"]) doLog("upvote", false, "missing permission.", null) && die(json_encode(["Missing permission!", null]));
    // Right now, this needs the user to be logged in. I have to rewrite this using IP instead of UID in case no account required to vote
    $id = clean($_POST["voteUp"]);
    if (!is_numeric($id)) die(json_encode(["Invalid ID!", null]));
    $post = $db["posts"]->findById($id);
    if (empty($post)) doLog("upvote", false, "post not found.", $user["_id"]) && die(json_encode(["Post not found!", null]));
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
        if (!$vote) doLog("upvote", false, "final step.", $user["_id"]) && die(json_encode(["Something went wrong and I don't know what.", $post["score"]]));
        doLog("upvote", true, $post["_id"], $user["_id"]);
        doLog("upvote", true, $post["_id"], $user["_id"]);
        die(json_encode(["Voted up!", $score]));
    } else {
        die(json_encode(["Already voted up!", $post["score"]]));
    }
}

if (isset($_POST["voteDown"])) {
    if (!$userlevel["perms"]["can_vote_post"]) doLog("downvote", false, "missing permission.", null) && die(json_encode(["Missing permission!", null]));
    // Right now, this needs the user to be logged in. I have to rewrite this using IP instead of UID in case no account required to vote
    $id = clean($_POST["voteDown"]);
    $post = $db["posts"]->findById($id);
    if (empty($post)) doLog("downvote", false, "post not found.", $user["_id"]) && die(json_encode(["Post not found!", null]));
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
        if (!$vote) doLog("downvote", false, "final step.", $user["_id"]) && die(json_encode(["Something went wrong and I don't know what.", $post["score"]]));
        doLog("downvote", true, $post["_id"], $user["_id"]);
        die(json_encode(["Voted down!", $score]));
    } else {
        die(json_encode(["Already voted down!", $post["score"]]));
    }
}

if (isset($_POST["addFavs"])) {
    if (!$logged) doLog("addFavs", false, "not logged in.", null) && die("Not logged in!");
    if (!$userlevel["perms"]["can_manage_favourites"]) doLog("addFavs", false, "missing permission.", $user["_id"]) && die("Missing permission!");
    $id = clean($_POST["addFavs"]);
    $post = $db["posts"]->findById($id);
    if (empty($post)) doLog("addFavs", false, "post not found.", $user["_id"]) && die("Post not found!");
    if (empty($db["favourites"]->findOneBy([["post", "==", $id], "AND", ["user", "==", $user["_id"]]]))) {
        $data = [
            "post" => $id,
            "user" => $user["_id"],
            "username" => $user["username"],
            "timestamp" => now()
        ];
        $db["favourites"]->insert($data);
        doLog("addFavs", true, $id, $user["_id"]);
        die($lang["remove_from_favourites"]);
    } else {
        die($lang["post_already_in_your_favorites"]);
    }
}

if (isset($_POST["removeFavs"])) {
    if (!$logged) doLog("removeFavs", false, "not logged in.", null) && die("Not logged in!");
    if (!$userlevel["perms"]["can_manage_favourites"]) doLog("removeFavs", false, "missing permission.", $user["_id"]) && die("Missing permission!");
    $id = clean($_POST["removeFavs"]);
    $post = $db["posts"]->findById($id);
    if (empty($post)) doLog("removeFavs", false, "post not found.", $user["_id"]) && die("Post not found!");
    if (!empty($db["favourites"]->findOneBy([["post", "==", $id], "AND", ["user", "==", $user["_id"]]]))) {
        $db["favourites"]->deleteBy([["post", "==", $id], "AND", ["user", "==", $user["_id"]]]);
        doLog("removeFavs", true, $id, $user["_id"]);
        die($lang["add_to_favourites"]);
    } else {
        die($lang["post_already_removed_from_your_favorites"]);
    }
}

if (isset($_POST["deletionFlag"])) {
    if (!$logged) doLog("deletionFlag", false, "not logged in.", null) && die("Not logged in!");
    if (!$userlevel["perms"]["can_report"]) doLog("flagPost", false, "missing permission.", $user["_id"]) && die("Missing permission!");
    if (!is_numeric($_POST["deletionFlag"])) doLog("flagPost", false, "invalid post id: " . $_POST["deletionFlag"], $user["_id"]) && die("Invalid post ID!");
    if (empty($_POST["reason"])) doLog("flagPost", false, "missing reason.", $user["_id"]) && die("Missing reason!");
    $id = clean($_POST["deletionFlag"]);
    $post = $db["posts"]->findById($id);
    if (empty($post)) doLog("flagPost", false, "post not found.", $user["_id"]) && die("Post not found!");
    $reason = clean($_POST["reason"]);

    if (empty($db["flagsDeletion"]->findOneBy([["user", "==", $user["_id"]], "AND", ["post", "==", $id]]))) {
        $data = [
            "post" => $id,
            "user" => $user["_id"],
            "username" => $user["username"],
            "status" => 0,
            "reason" => $reason,
            "rejectedReason" => null,
            "processedBy" => null,
            "timestamp" => now()
        ];
        $flag = $db["flagsDeletion"]->insert($data);
        doLog("flagPost", true, $flag["_id"], $user["_id"]);
        die("flagged");
    } else {
        doLog("flagPost", false, "arleady flagged: " . $id, $user["_id"]);
        die("Already flagged!");
    }
}

if (isset($_POST["deletePost"])) {
    if (!$logged) doLog("deletePost", false, "not logged in.", null) && die("Not logged in!");
    if (!$userlevel["perms"]["can_delete_post"]) doLog("deletePost", false, "missing permission.", $user["_id"]) && die("Missing permission!");
    if (empty($_POST["deletePost"]) || !isset($_POST["deletePost"])) doLog("deletePost", false, "invalid post id.") && die("Invalid post ID!");
    if (!is_numeric($_POST["deletePost"])) doLog("deletePost", false, "invalid post id: " . $_POST["deletePost"], $user["_id"]) && die("Invalid post ID!");
    if (empty($_POST["reason"])) doLog("deletePost", false, "missing reason.", $user["_id"]) && die("Missing reason!");
    $id = clean($_POST["deletePost"]);
    $post = $db["posts"]->findById($id);
    if (empty($post)) doLog("deletePost", false, "post not found.", $user["_id"]) && die("Post not found!");
    $reason = clean($_POST["reason"]);

    if (!$post["deleted"]) {
        $data = [
            "deleted" => true,
            "deletedReason" => $reason
        ];
        $delete = $db["posts"]->updateById($id, $data);
        doLog("deletePost", true, $delete["_id"], $user["_id"]);
        die("deleted");
    } else {
        doLog("deletePost", false, "arleady deleted: " . $id, $user["_id"]);
        die("Already deleted!");
    }
}

if (isset($_POST["recoverPost"])) {
    if (!$logged) doLog("recoverPost", false, "not logged in.", null) && die("Not logged in!");
    if (!$userlevel["perms"]["can_delete_post"]) doLog("recoverPost", false, "missing permission.", $user["_id"]) && die("Missing permission!");
    if (empty($_POST["recoverPost"]) || !isset($_POST["recoverPost"])) doLog("recoverPost", false, "invalid post id.", $user["_id"]) && die("Invalid post ID!");
    if (!is_numeric($_POST["recoverPost"])) doLog("recoverPost", false, "invalid post id: " . $_POST["recoverPost"], $user["_id"]) && die("Invalid post ID!");
    $id = clean($_POST["recoverPost"]);
    $post = $db["posts"]->findById($id);
    if (empty($post)) doLog("deletePost", false, "post not found: " . $id, $user["_id"]) && die("Post not found!");

    if ($post["deleted"]) {
        $data = [
            "deleted" => false,
            "deletedReason" => null
        ];
        $delete = $db["posts"]->updateById($id, $data);
        doLog("recoverPost", true, $delete["_id"], $user["_id"]);
        die("recovered");
    } else {
        doLog("recoverPost", false, "arleady recovered: " . $id, $user["_id"]);
        die("Already recovered!");
    }
}

if (isset($_POST["updateTerm"])) {
    if (!$logged) doLog("updateTerm", false, "not logged in.", null) && die("Not logged in!");
    if (!$userlevel["perms"]["can_edit_wiki"]) doLog("updateTerm", false, "missing permission.", $user["_id"]) && die("Missing permission!");
    if (empty($_POST["tagId"]) || !isset($_POST["tagId"])) doLog("updateTerm", false, "invalid tag id.", $user["_id"]) && die("Invalid tag ID!");
    if (!is_numeric($_POST["tagId"])) doLog("updateTerm", false, "invalid tag id: " . $_POST["tagId"], $user["_id"]) && die("Invalid tag ID!");
    if (!isset($_POST["description"]) || empty($_POST["description"])) doLog("updateTerm", false, "invalid description.", $user["_id"]) && die("Invalid description!");

    $description = $_POST["description"];
    if (strlen($description) < 15) doLog("updateTerm", false, " description too short.", $user["_id"]) && die("Description too short!");
    $tagId = clean($_POST["tagId"]);

    $tag = $db["tags"]->findById($tagId);
    if (empty($tag))
        doLog("updateTerm", false, "invalid tag id: " . $tagId, $user["_id"]) && die("Invalid tag!");

    $exists = false;
    $term = $db["wikiTerms"]->findOneBy(["term", "==", $tag["full"]]);
    if (!empty($term))
        $exists = true;

    if ($exists)
        if (!isset($_POST["termId"]) || empty($_POST["termId"]) || !is_numeric($_POST["termId"]))
            doLog("updateTerm", false, "invalid post id: " . $_POST["termId"] ? $_POST["termId"] : 0, $user["_id"]) && die("Invalid term ID!");

    if ($exists)
        $termId = clean($_POST["termId"]);

    if (!$exists) {
        $data = array(
            "term" => $tag["full"],
            "description" => $description,
            "tag" => $tagId,
            "creator" => $user["_id"],
            "creator_un" => $user["username"],
            "lastedit" => $user["_id"],
            "lastedit_un" => $user["username"],
            "lastedit_ts" => now(),
            "timestamp" => now(),
        );
        $db["wikiTerms"]->insert($data);
        $term = $data;
        $termId = $db["wikiTerms"]->getLastInsertedId();
    } else {
        $data = array(
            "description" => $description,
            "lastedit" => $user["_id"],
            "lastedit_un" => $user["username"],
            "lastedit_ts" => now(),
        );
        $db["wikiTerms"]->updateById($term["_id"], $data);
    }

    logTerm($termId, $exists ? $term["description"] : "", $description, $user["_id"], $user["username"]);
    die("success");
}

die("Привет!");
