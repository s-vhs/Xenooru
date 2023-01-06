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
                ->search(["name"], $_tag)
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
                    echo "<li onclick=\"fill('" . substr($tag["name"], strlen($_tag)) . " ', '{$search}', '{$display}')\" class=\"text-{$color}-500 cursor-pointer\">" . str_replace("_", " ", $tag["name"]) . " (" . count($db["tagRelations"]->findBy(["name", "=", $tag["name"]])) . ")</li>";
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
    if (!$logged) die(json_encode(["Not logged in!", null])) && doLog("upvote", false, "not logged in.", null);
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
    if (!$logged) die(json_encode(["Not logged in!", null])) && doLog("downvote", false, "not logged in.", null);
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
