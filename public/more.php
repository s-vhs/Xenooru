<?php

require "../autoload.php";

$pages["isMore"] = true;
switch ($_GET["tab"] ?? "home") {
    case "about":
        $tab = "about";
        break;
    case "help":
        $tab = "help";
        break;
    case "tos":
        $tab = "tos";
        break;
    case "privacy":
        $tab = "privacy";
        break;
    default:
        $tab = "home";
}
$smarty->assign("tab", $tab);
$smarty->assign("pages", $pages);
$smarty->assign("pagetitle", $lang["more"]);

$smarty->display("part.top.tpl");
$smarty->display("page.more.tpl");
$smarty->display("part.bottom.tpl");
