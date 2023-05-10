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
} else {
    $tab = "home";
}

$pages["isWiki"] = true;

$smarty->assign("tab", $tab);
$smarty->assign("pages", $pages);
$smarty->assign("pagetitle", $lang["wiki"] . ($tab == "term" ? " - \"" . sanitizeText($_GET["term"]) . "\"" : ""));

$smarty->display("part.top.tpl");
$smarty->display("page.wiki.tpl");
$smarty->display("part.bottom.tpl");
