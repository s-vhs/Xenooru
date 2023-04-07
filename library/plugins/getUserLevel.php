<?php

$db["levels"] = new \SleekDB\Store("levels", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Levels
if (!$logged) $user["level"] = 0;
$userlevel = $db["levels"]->findOneBy(["level", "==", $user["level"]]);
$smarty->assign("userlevel", $userlevel);
