<?php

require "../autoload.php";

$error = 404;
if (isset($_GET["id"]) && !empty($_GET["id"]) && is_numeric($_GET["id"]))
    $error = clean($_GET["id"]);

$pages["isError"] = true;

$smarty->assign("error", $error);
$smarty->assign("pages", $pages);
$smarty->assign("pagetitle", $lang["error"] . " " . $error);

require "../endtime.php";

$smarty->display("part.top.tpl");
$smarty->display("page.error.tpl");
$smarty->display("part.bottom.tpl");
