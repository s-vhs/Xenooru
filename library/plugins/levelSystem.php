<?php

if (!file_exists(ps(__DIR__ . "/data/levels.php")))
    if (file_exists(ps(__DIR__ . "/data/levels_default.php")))
        require_once ps(__DIR__ . "/data/levels_default.php");
    else
        die("Error: No levels_default.php or levels.php file for plugin levelSystem found.");
else
    require ps(__DIR__ . "/data/levels.php");

$db["levels"] = new \SleekDB\Store("levels", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Levels

if (isset($_GET["reloadLevels"])) {
    if ($logged) {
        $_levels = $db["levels"]->findAll();
        foreach ($_levels as $_level) {
            $db["levels"]->deleteById($_level["_id"]);
        }
    }
}

$finalLevels = array();
foreach ($levels as $level) {
    $check = $db["levels"]->findOneBy([["name", "==", $level["name"]], "AND", ["perms", "==", $level["perms"]]]);
    if (empty($check))
        $db["levels"]->insert($level);
    $finalLevels[$level["level"]] = $level["name"];
}

$smarty->assign("levels", $finalLevels);
