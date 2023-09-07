<?php

require "../autoload.php";

$smarty->assign("pagetitle", $config["slogan"]);
$smarty->assign("totalposts", str_split($db["posts"]->count()));

require "../endtime.php";

$smarty->display("part.top.tpl");
$smarty->display("page.index.tpl");
$smarty->display("part.bottom.tpl");
