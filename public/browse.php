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
        $id = clean($_GET["id"]);
        $post = $db["posts"]->findById($id);
        if (empty($post)) header("Location: browse.php") && die("post not found.");
        $poster = $db["users"]->findById($post["user"]);
        $smarty->assign("post", $post);
        $smarty->assign("poster", $poster);
        if ($logged && $userlevel["perms"]["can_manage_favourites"]) {
            $favourited = $db["favourites"]->findOneBy([["user", "==", $user["_id"]], "AND", ["post", "==", $post["_id"]]]);
            if (!empty($favourited))
                $favourited = true;
            else
                $favourited = false;
        } else {
            $favourited = false;
        }
        $smarty->assign("favourited", $favourited);
        $title = "{$post["tags"]} score:{$post["score"]} rating:{$post["rating"]} | {$post["_id"]}";
        $page = "post";
        break;
    case "favourites":
        $id = clean($_GET["user"]);
        $favouriter = $db["users"]->findById($id);
        if (!empty($favouriter)) {
            $title = "{$lang["favourites_of"]} {$favouriter["username"]} - {$lang["page"]} " . (clean($_GET["pagination"] ?? 1));
            $page = "favourites";

            $skip = ((clean($_GET["pagination"] ?? 1)) - 1) * $config["perpage"]["posts"];
            $favourites = $db["favourites"]->createQueryBuilder()
                ->orderBy(["_id" => "DESC"])
                ->limit($config["perpage"]["posts"])
                ->skip($skip)
                ->where(["user", "==", $favouriter["_id"]])
                ->getQuery()
                ->fetch();
            $posts = array();
            foreach ($favourites as $fav) {
                $post = $db["posts"]->findById($fav["post"]);
                if ($post) array_push($posts, $post);
            }
            $totalPages = $db["posts"]->count() / $config["perpage"]["posts"];
            $pagis = array();
            for ($i = 0; $i < $totalPages; $i++) {
                array_push($pagis, $i + 1);
            }

            $smarty->assign("totalpages", $totalPages);
            $smarty->assign("pagination", clean($_GET["pagination"] ?? 1));
            $smarty->assign("posts", $posts);
            $smarty->assign("favouriter", $favouriter);
            $smarty->assign("pagis", $pagis);
            break;
        } else {
            header("Location: browse.php");
            die("user does not exist.");
        }
    case "search":
        $page = "search";
        $skip = ((clean($_GET["pagination"] ?? 1)) - 1) * $config["perpage"]["posts"];
        $search = $db["posts"]->createQueryBuilder();
        $searchQuery = strtolower(trim(clean($_GET["query"])));
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
        $smarty->assign("pagination", clean($_GET["pagination"] ?? 1));
        $smarty->assign("posts", $posts);
        $smarty->assign("searchquery", $searchQuery);
        $pagis = array();
        for ($i = 0; $i < $totalPages; $i++) {
            array_push($pagis, $i + 1);
        }
        $smarty->assign("pagis", $pagis);
        $title = "{$lang["search"]}: {$searchQuery} - {$lang["page"]} " . (clean($_GET["pagination"] ?? 1));
        break;
    default:
        $skip = ((clean($_GET["pagination"] ?? 1)) - 1) * $config["perpage"]["posts"];
        $posts = $db["posts"]->createQueryBuilder()
            ->orderBy(["_id" => "DESC"])
            ->limit($config["perpage"]["posts"])
            ->skip($skip)
            ->getQuery()
            ->fetch();
        $totalPages = $db["posts"]->count() / $config["perpage"]["posts"];
        $smarty->assign("totalpages", $totalPages);
        $smarty->assign("pagination", clean($_GET["pagination"] ?? 1));
        $smarty->assign("posts", $posts);
        $pagis = array();
        for ($i = 0; $i < $totalPages; $i++) {
            array_push($pagis, $i + 1);
        }
        $smarty->assign("pagis", $pagis);
        $page = "browse";
        $title = "{$lang["browse"]} - {$lang["page"]} " . (clean($_GET["pagination"] ?? 1));
}
$smarty->assign("page", $page);
$smarty->assign("pages", $pages);
$smarty->assign("pagetitle", $title);

if ($page == "browse" || $page == "search" || $page == "post" || $page == "favourites") {
    /* Tag creation begin */
    $tags["copyrights"] = array();
    $tags["characters"] = array();
    $tags["artists"] = array();
    $tags["tags"] = array();
    $tags["metas"] = array();
    if ($page == "browse" || $page == "search") {
        $_tags["copyrights"] = $db["tagRelations"]->createQueryBuilder()->where(["order", "==", 1])->limit(5)->orderBy(["name" => "ASC"])->distinct("name")->getQuery()->fetch();
        $_tags["characters"] = $db["tagRelations"]->createQueryBuilder()->where(["order", "==", 2])->limit(5)->orderBy(["name" => "ASC"])->distinct("name")->getQuery()->fetch();
        $_tags["artists"] = $db["tagRelations"]->createQueryBuilder()->where(["order", "==", 3])->limit(5)->orderBy(["name" => "ASC"])->distinct("name")->getQuery()->fetch();
        $_tags["tags"] = $db["tagRelations"]->createQueryBuilder()->where(["order", "==", 4])->limit(30)->orderBy(["name" => "ASC"])->distinct("name")->getQuery()->fetch();
        $_tags["metas"] = $db["tagRelations"]->createQueryBuilder()->where(["order", "==", 5])->limit(5)->orderBy(["name" => "ASC"])->distinct("name")->getQuery()->fetch();
    } elseif ($page == "post") {
        $id = clean($_GET["id"]);
        $post = $db["posts"]->findById($id);
        if (empty($post)) {
            header("Location: browse.php");
            die("post not found.");
        }
        $_tags["copyrights"] = $db["tagRelations"]->createQueryBuilder()->where([["order", "==", 1], "AND", ["post", "==", $post["_id"]]])->orderBy(["name" => "ASC"])->distinct("name")->getQuery()->fetch();
        $_tags["characters"] = $db["tagRelations"]->createQueryBuilder()->where([["order", "==", 2], "AND", ["post", "==", $post["_id"]]])->orderBy(["name" => "ASC"])->distinct("name")->getQuery()->fetch();
        $_tags["artists"] = $db["tagRelations"]->createQueryBuilder()->where([["order", "==", 3], "AND", ["post", "==", $post["_id"]]])->orderBy(["name" => "ASC"])->distinct("name")->getQuery()->fetch();
        $_tags["tags"] = $db["tagRelations"]->createQueryBuilder()->where([["order", "==", 4], "AND", ["post", "==", $post["_id"]]])->orderBy(["name" => "ASC"])->distinct("name")->getQuery()->fetch();
        $_tags["metas"] = $db["tagRelations"]->createQueryBuilder()->where([["order", "==", 5], "AND", ["post", "==", $post["_id"]]])->orderBy(["name" => "ASC"])->distinct("name")->getQuery()->fetch();
    } elseif ($page == "favourites") {
        // This is my poor attempt for getting all the tags from the favourited posts and put them in an array. It doesn't work obviously.
        $_tags["copyrights"] =  array();
        $_tags["characters"] = array();
        $_tags["artists"] = array();
        $_tags["tags"] = array();
        $_tags["metas"] = array();
        // foreach ($posts as $post) {
        //     $_cprights = $db["tagRelations"]->createQueryBuilder()->where([["order", "==", 1], "AND", ["post", "==", $post["_id"]]])->orderBy(["name" => "ASC"])->distinct("name")->getQuery()->fetch();
        //     array_push($_tags["copyrights"], $_cprights[0] ?? array());

        //     $_chrcters = $db["tagRelations"]->createQueryBuilder()->where([["order", "==", 2], "AND", ["post", "==", $post["_id"]]])->orderBy(["name" => "ASC"])->distinct("name")->getQuery()->fetch();
        //     array_push($_tags["characters"], $_chrcters[0] ?? array());

        //     $_artsts = $db["tagRelations"]->createQueryBuilder()->where([["order", "==", 3], "AND", ["post", "==", $post["_id"]]])->orderBy(["name" => "ASC"])->distinct("name")->getQuery()->fetch();
        //     array_push($_tags["artists"], $_artsts[0] ?? array());

        //     $_tgs = $db["tagRelations"]->createQueryBuilder()->where([["order", "==", 4], "AND", ["post", "==", $post["_id"]]])->orderBy(["name" => "ASC"])->distinct("name")->getQuery()->fetch();
        //     array_push($_tags["tags"], $_tgs[0] ?? array());

        //     $_mts = $db["tagRelations"]->createQueryBuilder()->where([["order", "==", 5], "AND", ["post", "==", $post["_id"]]])->orderBy(["name" => "ASC"])->distinct("name")->getQuery()->fetch();
        //     array_push($_tags["metas"], $_mts[0] ?? array());

        //     // print_r($_tags["copyrights"]);
        //     // if (!empty($_tags["copyrights"][0])) $_tags["copyrights"] = $_tags["copyrights"][0];
        //     // if (!empty($_tags["characters"][0])) $_tags["characters"] = $_tags["characters"][0];
        //     // if (!empty($_tags["artists"][0])) $_tags["artists"] = $_tags["artists"][0];
        //     // if (!empty($_tags["tags"][0])) $_tags["tags"] = $_tags["tags"][0];
        //     // if (!empty($_tags["metas"][0])) $_tags["metas"] = $_tags["metas"][0];
        //     unset($_cprights);
        //     unset($_chrcters);
        //     unset($_artsts);
        //     unset($_tgs);
        //     unset($_mts);
        // }
        // $_tags["copyrights"] = removeDuplicateByName($_tags["copyrights"], "name");
        // $_tags["characters"] = removeDuplicateByName($_tags["characters"], "name");
        // $_tags["artists"] = removeDuplicateByName($_tags["artists"], "name");
        // $_tags["tags"] = removeDuplicateByName($_tags["tags"], "name");
        // $_tags["metas"] = removeDuplicateByName($_tags["metas"], "name");

        // print_r($_tags["metas"]);
    }
    foreach ($_tags["copyrights"] as $tag) {
        $tag["count"] = count($db["tagRelations"]->findBy(["full", "==", $tag["full"]]));
        \array_splice($_tags["copyrights"], 0, 1);
        array_push($tags["copyrights"], $tag);
    }
    foreach ($_tags["characters"] as $tag) {
        $tag["count"] = count($db["tagRelations"]->findBy(["full", "==", $tag["full"]]));
        \array_splice($_tags["characters"], 0, 1);
        array_push($tags["characters"], $tag);
    }
    foreach ($_tags["artists"] as $tag) {
        $tag["count"] = count($db["tagRelations"]->findBy(["full", "==", $tag["full"]]));
        \array_splice($_tags["artists"], 0, 1);
        array_push($tags["artists"], $tag);
    }
    foreach ($_tags["tags"] as $tag) {
        $tag["count"] = count($db["tagRelations"]->findBy(["full", "==", $tag["full"]]));
        \array_splice($_tags["tags"], 0, 1);
        array_push($tags["tags"], $tag);
    }
    foreach ($_tags["metas"] as $tag) {
        $tag["count"] = count($db["tagRelations"]->findBy(["full", "==", $tag["full"]]));
        \array_splice($_tags["metas"], 0, 1);
        array_push($tags["metas"], $tag);
    }
    $smarty->assign("tags", $tags);
    /* Tag creation end */
}

if ($page == "post" && $userlevel["perms"]["can_edit_post"] && isset($_POST["edit"])) {
    $error = false;

    if ($config["captcha"]["enabled"] && $config["captcha"]["type"] == "hcaptcha") {
        if (!hCaptcha($_POST['h-captcha-response'])) {
            $error = true;
            $smarty->assign("error", "Captcha is wrong!");
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

            $source = clean($_POST["source"]);
            $title = clean($_POST["title"]);
            $tagsRaw = clean($_POST["tags"]);
            $amount = getTagAmount($tagsRaw);

            if ($amount < $config["upload"]["min"]) {
                $error = true;
                doLog("upload", false, "only {$amount} of {$config["upload"]["min"]}. post: " . $post["_id"], $user["_id"]);
                $smarty->assign("error", "You need to have at least {$config["upload"]["min"]} tags!");
            } else {
                $tags = processTags($post["_id"], $tagsRaw);
                $data = array(
                    "source" => $source,
                    "title" => $title,
                    "tags" => strtolower($tags),
                    "raw" => strtolower($tagsRaw),
                    "rating" => $rating
                );
                logTags($post["_id"], $rating, $post["tags"], $tags, $title, $source, $user["_id"], $user["username"]);
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

if ($page == "post" && $userlevel["perms"]["can_comment"] && isset($_POST["comment"])) {
    $error = false;
    if (empty($_POST["commentPost"])) {
        $error = true;
        $smarty->assign("error", "Comment is empty!");
    }
}

$smarty->display("part.top.tpl");
$smarty->display("page.browse.tpl");
$smarty->display("part.bottom.tpl");
