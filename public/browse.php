<?php

require "../autoload.php";

$pages["isBrowse"] = true;
switch ($_GET["tab"] ?? "home") {
    case "login":
        $tab = "login";
        break;
    case "signup":
        $tab = "signup";
        break;
    case "options":
        $tab = "options";
        break;
    case "forgot":
        $tab = "forgot";
        break;
    default:
        $tab = "home";
}
$smarty->assign("tab", $tab);
$smarty->assign("pages", $pages);
$smarty->assign("pagetitle", $lang["browse"]);

$smarty->display("part.top.tpl");
$smarty->display("page.browse.tpl");
$smarty->display("part.bottom.tpl");
