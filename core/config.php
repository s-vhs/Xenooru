<?php

$config["title"] = "Xenooru";
$config["slogan"] = "Booru made simple";
$config["logo"] = "assets/logo.png";

// Default-Variablen
$config["default"]["theme"] = "eve";
$config["default"]["lang"] = "en";
$config["default"]["level"] = 50;

// X Elemente von Y pro Seite
$config["perpage"]["users"] = 50;
$config["perpage"]["posts"] = 25;
$config["perpage"]["comments"] = 50;
$config["perpage"]["announcements"] = 50;
$config["perpage"]["tags"] = 100;

// Diese Software nutzt Smarty als Template-Engine. Dokumentation:
$config["smarty"]["template"] = __DIR__ . "/../library/templates/"; // Dies muss mit einen Schrägstriche enden!
$config["smarty"]["config"] = __DIR__ . "/../library/smarty/config";
$config["smarty"]["compile"] = __DIR__ . "/../library/smarty/compile";
$config["smarty"]["cache"] = __DIR__ . "/../library/smarty/cache";

// Diese Software nutzt SleekDB als Datenbank. Dokumentation: https://sleekdb.github.io/
$config["db"]["path"] = __DIR__ . "/../database";
$config["db"]["config"] = array(
    "auto_cache" => true,
    "cache_lifetime" => null,
    "timeout" => false, // deprecated! Set it to false!
    "primary_key" => "_id",
    "search" => [
        "min_length" => 2,
        "mode" => "or",
        "score_key" => "scoreKey"
    ],
    "folder_permissions" => 0777
);
