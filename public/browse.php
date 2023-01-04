<?php

require "../autoload.php";

$pages["isBrowse"] = true;
switch ($_GET["page"] ?? "browse") {
    case "random":
        $page = "random";
        $title = $lang["random"];
        break;
    case "post":
        $id = $_GET["id"];
        $post = $db["posts"]->findById($id);
        if (empty($post)) header("Location: browse.php") && die("post not found.");
        $title = $post["tags"] . " | " . $post["_id"];
        $page = "post";
        break;
    case "search":
        $page = "search";
        $searchQuery = strtolower(trim($_GET["query"]));
        $skip = (($_GET["pagination"] ?? 1) - 1) * $config["perpage"]["posts"];
        $posts = $db["posts"]->createQueryBuilder()
            ->search(["tags"], $searchQuery)
            ->orderBy(["_id" => "DESC"]) // sort result
            ->limit($config["perpage"]["posts"])
            ->skip($skip)
            ->getQuery()
            ->fetch();
        $allPosts = $db["posts"]->createQueryBuilder()
            ->search(["tags"], $searchQuery)
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
        $title = $lang["search"];
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
        $title = $lang["browse"];
}
$smarty->assign("page", $page);
$smarty->assign("pages", $pages);
$smarty->assign("pagetitle", $title);

$smarty->display("part.top.tpl");
$smarty->display("page.browse.tpl");
$smarty->display("part.bottom.tpl");
