<?php

// Erst nehmen wir alles wichtige
require_once "core/config.php";
require_once "core/funky.php";
$usertheme = $_COOKIE["theme"] ?? $config["default"]["theme"];
$userlang = $_COOKIE["lang"] ?? $config["default"]["lang"];
require_once "library/langs/{$userlang}.php";
require_once "library/templates/{$usertheme}/info.php";

// Nun initialisieren wir die Datenbank. Später erstellen wir die einzelnen Elemente
require_once "library/SleekDB/Store.php";

// Hier initialisieren wir die Template-Engine und erstellen direkt ein Element
require_once "library/smarty/libs/smarty.class.php";
$smarty = new Smarty();
// Hier setzen wir alle wichtige Verzeichnisse
$smarty->setTemplateDir(platformSlashes($config["smarty"]["template"] . $usertheme));
$smarty->setConfigDir(platformSlashes($config["smarty"]["config"]));
$smarty->setCompileDir(platformSlashes($config["smarty"]["compile"]));
$smarty->setCacheDir(platformSlashes($config["smarty"]["cache"]));
// Hier setzen wir die einzelnen Variablen für Smarty
$smarty->assign("config", $config);
$smarty->assign("lang", $lang);
$smarty->assign("theme", $theme);
$smarty->assign("userlang", $userlang);
$smarty->assign("usertheme", $usertheme);
$smarty->assign("version", file_get_contents(platformSlashes(__DIR__ . "/version.txt")));

// Nun sind die Elemente für die Datenbank dran
$db["posts"] = new \SleekDB\Store("posts", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Posts
$db["users"] = new \SleekDB\Store("users", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Nutzer
$db["comments"] = new \SleekDB\Store("comments", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Kommentare
$db["tags"] = new \SleekDB\Store("tags", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Tags
$db["announcements"] = new \SleekDB\Store("announcements", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Ankündigungen
$db["forums"] = new \SleekDB\Store("forums", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Foren
$db["forumPosts"] = new \SleekDB\Store("forumPosts", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Foren-Beiträge
$db["sessions"] = new \SleekDB\Store("sessions", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Sitzungen
$db["visitLogs"] = new \SleekDB\Store("visitLogs", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Besucher-Logs
$db["editLogs"] = new \SleekDB\Store("editLogs", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Bearbeitungs-Logs

// Sitzungs-überprüfung
require_once "core/session.php";

// Für das Menü
$pages = array(
    "isAccount" => false,
    "isBrowse" => false,
    "isComments" => false,
    "isTags" => false,
    "isForums" => false,
    "isMore" => false
);
