<?php

require "../autoload.php";

$pages["isBrowse"] = true;
switch ($_GET["page"] ?? "home") {
    case "post":
        $page = "post";
        $id = clean($_GET["id"]);
        $post = $db["posts"]->findById($id);
        if (empty($post)) header("Location: browse.php") && die("No post found.");
        // $history = $db["tagLogs"]->findBy(["post", ""])
        $history = $db["tagLogs"]->findBy(["post", "=", "{$post["_id"]}"], ["timestamp" => "desc"]);
        $smarty->assign("post", $post);
        $smarty->assign("history", $history);
        break;
    case "wiki":
        $page = "wiki";
        $id = clean($_GET["id"]);
        $term = $db["wikiTerms"]->findById($id);
        if (empty($term)) header('Location: ' . $_SERVER['HTTP_REFERER']) && die("No term found.");
        $history = $db["wikiLogs"]->findBy(["term", "==", $id], ["timestamp" => "desc"]);
        $smarty->assign("term", $term);
        $smarty->assign("history", $history);
        break;
    case "user":
        $page = "user";
        $id = clean($_GET["id"]);
        break;
    default:
        header("Location: browse.php");
}
$smarty->assign("page", $page);
$smarty->assign("pages", $pages);
$smarty->assign("pagetitle", $lang["logs"]);

require "../endtime.php";

$smarty->display("part.top.tpl");
$smarty->display("page.logs.tpl");
$smarty->display("part.bottom.tpl");
