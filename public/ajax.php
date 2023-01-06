<?php

require "../autoload.php";

if (isset($_POST["search"])) {
    $_tag = array_reverse(explode(" ", $_POST["search"]));
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
                    echo "<li onclick=\"fill('" . substr($tag["name"], strlen($_tag)) . " ')\" class=\"text-" . $color . "-500 cursor-pointer\">" . str_replace("_", " ", $tag["name"]) . " (" . count($db["tagRelations"]->findBy(["name", "=", $tag["name"]])) . ")</li>";
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
    if (!$logged) die(json_encode(["Not logged in!", null]));
    $id = $_POST["voteUp"];
    $post = $db["posts"]->findById($id);
    if (empty($post)) die(json_encode(["Post not found!", null]));
    if (empty($db["postVotes"]->findBy([["post", "=", $post["_id"]], "AND", ["user", "=", $user["_id"]], "AND", ["vote", "=", "up"]]))) {
        $deleted = false;
        if (!empty($db["postVotes"]->findBy([["post", "=", $post["_id"]], "AND", ["user", "=", $user["_id"]], "AND", ["vote", "=", "down"]]))) $db["postVotes"]->deleteBy([["post", "=", $post["_id"]], "AND", ["user", "=", $user["_id"]]]) && $deleted = true;
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
        if (!$vote) die(json_encode(["Something went wrong and I don't know what.", $post["score"]]));
        die(json_encode(["Voted up!", $score]));
    } else {
        die(json_encode(["Already voted up!", $post["score"]]));
    }
}

if (isset($_POST["voteDown"])) {
    if (!$logged) die(json_encode(["Not logged in!", null]));
    $id = $_POST["voteDown"];
    $post = $db["posts"]->findById($id);
    if (empty($post)) die(json_encode(["Post not found!", null]));
    if (empty($db["postVotes"]->findBy([["post", "=", $post["_id"]], "AND", ["user", "=", $user["_id"]], "AND", ["vote", "=", "down"]]))) {
        $deleted = false;
        if (!empty($db["postVotes"]->findBy([["post", "=", $post["_id"]], "AND", ["user", "=", $user["_id"]], "AND", ["vote", "=", "up"]]))) $db["postVotes"]->deleteBy([["post", "=", $post["_id"]], "AND", ["user", "=", $user["_id"]]]) && $deleted = true;
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
        if (!$vote) die(json_encode(["Something went wrong and I don't know what.", $post["score"]]));
        die(json_encode(["Voted down!", $score]));
    } else {
        die(json_encode(["Already voted down!", $post["score"]]));
    }
}
