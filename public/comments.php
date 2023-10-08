<?php

require "../autoload.php";

$pages["isComments"] = true;

// Pagination
$page = stripNumbers($_GET["pagination"] ?? 1);
$limit = 10;
$skip = ((stripNumbers($_GET["pagination"] ?? 1)) - 1) * $config["perpage"]["comments"];

$comments = $db["comments"]->findAll(["timestamp" => "DESC"], $limit, $skip);
foreach ($comments as $key => $comment) {
    // Get user data from users collection
    $xuser = $db["users"]->findOneBy(["_id", "==", $comment["user_id"]]);
    $xpost = $db["posts"]->findById($comment["post_id"]);
    // Add user data to comment
    $_tags["copyrights"] = $db["tagRelations"]->createQueryBuilder()->where([["order", "==", 1], "AND", ["post", "==", $xpost["_id"]]])->orderBy(["name" => "ASC"])->distinct("name")->getQuery()->fetch();
    $_tags["characters"] = $db["tagRelations"]->createQueryBuilder()->where([["order", "==", 2], "AND", ["post", "==", $xpost["_id"]]])->orderBy(["name" => "ASC"])->distinct("name")->getQuery()->fetch();
    $_tags["artists"] = $db["tagRelations"]->createQueryBuilder()->where([["order", "==", 3], "AND", ["post", "==", $xpost["_id"]]])->orderBy(["name" => "ASC"])->distinct("name")->getQuery()->fetch();
    $_tags["tags"] = $db["tagRelations"]->createQueryBuilder()->where([["order", "==", 4], "AND", ["post", "==", $xpost["_id"]]])->orderBy(["name" => "ASC"])->distinct("name")->getQuery()->fetch();
    $_tags["metas"] = $db["tagRelations"]->createQueryBuilder()->where([["order", "==", 5], "AND", ["post", "==", $xpost["_id"]]])->orderBy(["name" => "ASC"])->distinct("name")->getQuery()->fetch();

    $comments[$key]["user"] = $xuser;
    $comments[$key]["post"] = $xpost;
    $comments[$key]["postTags"] = $_tags;
}
$totalPages = ceil($db["comments"]->count() / $config["perpage"]["comments"]);
$pagis = array();
for ($i = 0; $i < $totalPages; $i++) {
    array_push($pagis, $i + 1);
}

$smarty->assign("pagis", $pagis);
$smarty->assign("totalpages", $totalPages);
$smarty->assign("comments", $comments);
$smarty->assign("pagination", stripNumbers($_GET["pagination"] ?? 1));
$smarty->assign("pages", $pages);
$smarty->assign("pagetitle", "Comments");

require "../endtime.php";

$smarty->display("part.top.tpl");
$smarty->display("page.comments.tpl");
$smarty->display("part.bottom.tpl");
