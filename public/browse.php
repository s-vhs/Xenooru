<?php

require "../autoload.php";

$pages["isBrowse"] = true;
switch ($_GET["page"] ?? "browse") {
    case "random":
        $page = "random";
        $title = $lang["random"];
        header("Location: ?page=post&id=" . rand(1, $db["posts"]->count()));
        break;
    case "post":
        $id = $_GET["id"];
        $post = $db["posts"]->findById($id);
        if (empty($post)) header("Location: browse.php") && die("post not found.");
        $poster = $db["users"]->findById($post["user"]);
        $smarty->assign("post", $post);
        $smarty->assign("poster", $poster);
        $title = "{$post["tags"]} score:{$post["score"]} rating:{$post["rating"]} | {$post["_id"]}";
        $page = "post";
        break;
    case "search":
        $page = "search";
        $skip = (($_GET["pagination"] ?? 1) - 1) * $config["perpage"]["posts"];
        $search = $db["posts"]->createQueryBuilder();
        $searchQuery = strtolower(trim($_GET["query"]));
        if (($pos = strpos($searchQuery, "rating:")) !== false) {
            $rtng = trim(substr($searchQuery, $pos + 7));
            switch ($rtng) {
                case "e":
                case "nsfw":
                case "expl":
                case "explicit":
                    $rating = "explicit";
                    break;
                case "q":
                case "ques":
                case "ecchi":
                case "questionable":
                    $rating = "questionable";
                    break;
                case "qe":
                case "eq":
                case "quex":
                case "quesexpl":
                case "quesnsfw":
                case "questionablensfw":
                case "questionableexplicit":
                    $rating[0] = "questionable";
                    $rating[1] = "explicit";
                    break;
                case "sq":
                case "qs":
                case "saqu":
                case "qusa":
                case "safque":
                case "quesaf":
                case "safequestionable":
                case "questionablesafe":
                    $rating[0] = "safe";
                    $rating[1] = "questionable";
                    break;
                default:
                    $rating = "safe";
            }
            $toSearch = str_replace("rating:" . $rtng, "", $searchQuery);
        } else {
            $toSearch = $searchQuery;
        }
        $posts = $search->search(["tags"], $toSearch)
            ->orderBy(["_id" => "DESC"]) // sort result
            ->limit($config["perpage"]["posts"])
            ->skip($skip)
            ->getQuery()
            ->fetch();
        if (isset($rating)) {
            if (is_array($rating)) {
                $_search = array();
                $c = 0;
                foreach ($rating as $r) {
                    $_search[$c] = array("rating", "=", $r);
                    $c++;
                }
                $search->where([$_search[0], "OR", $_search[1]]);
            } else {
                $search->where(["rating", "=", $rating]);
            }
        }
        $allPosts = $search
            ->search(["tags"], $toSearch)
            ->getQuery()
            ->fetch();
        $totalPages = count($allPosts) / $config["perpage"]["posts"];
        $smarty->assign("totalpages", $totalPages);
        $smarty->assign("pagination", $_GET["pagination"] ?? 1);
        $smarty->assign("posts", $posts);
        $smarty->assign("searchquery", $searchQuery);
        $pagis = array();
        for ($i = 0; $i < $totalPages; $i++) {
            array_push($pagis, $i + 1);
        }
        $smarty->assign("pagis", $pagis);
        $title = "{$lang["search"]}: {$searchQuery} - {$lang["page"]} " . ($_GET["pagination"] ?? 1);
        break;
    default:
        $skip = (($_GET["pagination"] ?? 1) - 1) * $config["perpage"]["posts"];
        $posts = $db["posts"]->createQueryBuilder()
            ->orderBy(["_id" => "DESC"])
            ->limit($config["perpage"]["posts"])
            ->skip($skip)
            ->getQuery()
            ->fetch();
        $totalPages = $db["posts"]->count() / $config["perpage"]["posts"];
        $smarty->assign("totalpages", $totalPages);
        $smarty->assign("pagination", $_GET["pagination"] ?? 1);
        $smarty->assign("posts", $posts);
        $pagis = array();
        for ($i = 0; $i < $totalPages; $i++) {
            array_push($pagis, $i + 1);
        }
        $smarty->assign("pagis", $pagis);
        $page = "browse";
        $title = "{$lang["browse"]} - {$lang["page"]} " . ($_GET["pagination"] ?? 1);
}
$smarty->assign("page", $page);
$smarty->assign("pages", $pages);
$smarty->assign("pagetitle", $title);

if ($page == "browse" || $page == "search" || $page == "post") {
    /* Tag creation begin */
    $tags["copyrights"] = array();
    $tags["characters"] = array();
    $tags["artists"] = array();
    $tags["tags"] = array();
    $tags["metas"] = array();
    if ($page == "browse" || $page == "search") {
        $_tags["copyrights"] = $db["tagRelations"]->createQueryBuilder()->where(["order", "=", 1])->limit(5)->orderBy(["name" => "ASC"])->distinct("name")->getQuery()->fetch();
        $_tags["characters"] = $db["tagRelations"]->createQueryBuilder()->where(["order", "=", 2])->limit(5)->orderBy(["name" => "ASC"])->distinct("name")->getQuery()->fetch();
        $_tags["artists"] = $db["tagRelations"]->createQueryBuilder()->where(["order", "=", 3])->limit(5)->orderBy(["name" => "ASC"])->distinct("name")->getQuery()->fetch();
        $_tags["tags"] = $db["tagRelations"]->createQueryBuilder()->where(["order", "=", 4])->limit(30)->orderBy(["name" => "ASC"])->distinct("name")->getQuery()->fetch();
        $_tags["metas"] = $db["tagRelations"]->createQueryBuilder()->where(["order", "=", 5])->limit(5)->orderBy(["name" => "ASC"])->distinct("name")->getQuery()->fetch();
    } elseif ($page == "post") {
        $_tags["copyrights"] = $db["tagRelations"]->createQueryBuilder()->where([["order", "=", 1], "AND", ["post", "=", $post["_id"]]])->orderBy(["name" => "ASC"])->distinct("name")->getQuery()->fetch();
        $_tags["characters"] = $db["tagRelations"]->createQueryBuilder()->where([["order", "=", 2], "AND", ["post", "=", $post["_id"]]])->orderBy(["name" => "ASC"])->distinct("name")->getQuery()->fetch();
        $_tags["artists"] = $db["tagRelations"]->createQueryBuilder()->where([["order", "=", 3], "AND", ["post", "=", $post["_id"]]])->orderBy(["name" => "ASC"])->distinct("name")->getQuery()->fetch();
        $_tags["tags"] = $db["tagRelations"]->createQueryBuilder()->where([["order", "=", 4], "AND", ["post", "=", $post["_id"]]])->orderBy(["name" => "ASC"])->distinct("name")->getQuery()->fetch();
        $_tags["metas"] = $db["tagRelations"]->createQueryBuilder()->where([["order", "=", 5], "AND", ["post", "=", $post["_id"]]])->orderBy(["name" => "ASC"])->distinct("name")->getQuery()->fetch();
    }
    foreach ($_tags["copyrights"] as $tag) {
        $tag["count"] = count($db["tagRelations"]->findBy(["name", "=", $tag["name"]]));
        \array_splice($_tags["copyrights"], 0, 1);
        array_push($tags["copyrights"], $tag);
    }
    foreach ($_tags["characters"] as $tag) {
        $tag["count"] = count($db["tagRelations"]->findBy(["name", "=", $tag["name"]]));
        \array_splice($_tags["characters"], 0, 1);
        array_push($tags["characters"], $tag);
    }
    foreach ($_tags["artists"] as $tag) {
        $tag["count"] = count($db["tagRelations"]->findBy(["name", "=", $tag["name"]]));
    }
    foreach ($_tags["tags"] as $tag) {
        $tag["count"] = count($db["tagRelations"]->findBy(["name", "=", $tag["name"]]));
        \array_splice($_tags["tags"], 0, 1);
        array_push($tags["tags"], $tag);
    }
    foreach ($_tags["metas"] as $tag) {
        $tag["count"] = count($db["tagRelations"]->findBy(["name", "=", $tag["name"]]));
        \array_splice($_tags["metas"], 0, 1);
        array_push($tags["metas"], $tag);
    }
    $smarty->assign("tags", $tags);
    /* Tag creation end */
}

if ($page == "post") {
    if ($logged) {
        if (isset($_POST["edit"])) {
            $error = false;
            if ($config["captcha"]["enabled"]) {
                if ($config["captcha"]["type"] == "hcaptcha") {
                    if (!hCaptcha($_POST['h-captcha-response'])) $error = true && $smarty->assign("error", "Captcha is wrong!");
                }
            }

            if (!$error) {
                if (isset($_POST["rating"])) {
                    switch ($_POST["rating"]) {
                        case "questionable":
                            $rating = "questionable";
                            break;
                        case "explicit":
                            $rating = "explicit";
                            break;
                        default:
                            $rating = "safe";
                    }


                    $source = $_POST["source"];
                    $title = $_POST["title"];
                    $tags = processTags($_POST["tags"]);

                    if ($tags["amount"] < $config["upload"]["min"]) {
                        $error = true;
                        doLog("upload", false, "only {$tags["amount"]} of {$config["upload"]["min"]}. post: " . $post["_id"], $user["_id"]);
                        $smarty->assign("error", "You need to have at least {$config["upload"]["min"]} tags!");
                    } else {
                        $tags = $tags["tags"];
                        $data = array(
                            "source" => $source,
                            "title" => $title,
                            "tags" => $tags,
                            "rating" => $rating
                        );
                        checkTags($post["_id"], toArrayFromSpaces($tags));
                        logTags($post["_id"], $post["tags"], $tags, $user["_id"]);
                        $db["posts"]->updateById($post["_id"], $data);
                        doLog("edit", true, $post["_id"], $user["_id"]);
                        header("Location: browse.php?page=post&id=" . $post["_id"]);
                    }
                } else {
                    doLog("edit", false, "no rating given. post: " . $post["_id"], $user["_id"]);
                    $smarty->assign("error", "No rating given!");
                }
            }
        }
    }
}

$smarty->display("part.top.tpl");
$smarty->display("page.browse.tpl");
$smarty->display("part.bottom.tpl");
