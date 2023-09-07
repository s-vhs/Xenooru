<?php

require "../autoload.php";

if (isset($_GET["term"]) && empty($_GET["term"])) {
    header("Location: wiki.php");
    die("No term given.");
}

if (isset($_GET["term"])) {
    $exists = false;
    $term = clean($_GET["term"]);

    $tag = $db["tags"]->findOneBy(["full", "==", $term]);
    if (!empty($tag)) {
        $smarty->assign("tag", $tag);
        $term = $db["wikiTerms"]->findOneBy(["term", "==", $term]);
        if (!empty($term)) {
            $exists = true;
            $smarty->assign("term", $term);
        }
    } else {
        header("Location: wiki.php");
        die("Tag does not exist.");
    }

    $smarty->assign("exists", $exists);
    $tab = "term";

    if ($logged && $userlevel["perms"]["can_edit_wiki"]) {
        if (isset($_POST["editTerm"])) {
            $description = clean($_POST["description"]);
        }
    }
} else {
    $tab = "home";
    $pagination = 1;
    if (isset($_GET["pagination"]) && !empty($_GET["pagination"]) && is_numeric($_GET["pagination"]))
        $pagination = clean($_GET["pagination"]);
    $smarty->assign("pagination", $pagination);
}

$pages["isWiki"] = true;

$smarty->assign("tab", $tab);
$smarty->assign("pages", $pages);
$smarty->assign("pagetitle", $lang["wiki"] . ($tab == "term" ? " - \"" . sanitizeText($_GET["term"]) . "\"" : ""));

require "../endtime.php";

$smarty->display("part.top.tpl");
$smarty->display("page.wiki.tpl");
$smarty->display("part.bottom.tpl");
