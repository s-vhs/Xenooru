<?php

// Wie lange braucht die Seite um zu laden?
$starttime = microtime(true);

// Erst nehmen wir alles wichtige
require "config.php";
$config["debug"] == true ? error_reporting(E_ALL) && ini_set('display_errors', 1) : error_reporting(0) && ini_set('display_errors', 0);
require_once "funky.php";

// Nun initialisieren wir die Datenbank. Später erstellen wir die einzelnen Elemente
require_once "library/SleekDB/Store.php";

// Hier initialisieren wir die Template-Engine und erstellen direkt ein Element
require_once "library/smarty/libs/Smarty.class.php";
$smarty = new Smarty();

// Nun sind die Elemente für die Datenbank dran
$db["posts"] = new \SleekDB\Store("posts", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Posts
$db["users"] = new \SleekDB\Store("users", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Nutzer
$db["comments"] = new \SleekDB\Store("comments", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Kommentare
$db["tags"] = new \SleekDB\Store("tags", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Tags
$db["tagRelations"] = new \SleekDB\Store("tagRelations", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Tag-Verknüpfungen
$db["announcements"] = new \SleekDB\Store("announcements", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Ankündigungen
$db["forums"] = new \SleekDB\Store("forums", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Foren
$db["forumPosts"] = new \SleekDB\Store("forumPosts", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Foren-Beiträge
$db["sessions"] = new \SleekDB\Store("sessions", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Sitzungen
$db["logs"] = new \SleekDB\Store("logs", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Besucher-Logs
$db["visitLogs"] = new \SleekDB\Store("visitLogs", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Besucher-Logs
$db["postVotes"] = new \SleekDB\Store("postVotes", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Votes
$db["commentVotes"] = new \SleekDB\Store("commentVotes", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Kommentar-Votes
$db["tagLogs"] = new \SleekDB\Store("tagLogs", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Tag-Logs
$db["favourites"] = new \SleekDB\Store("favourites", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Favoriten
$db["flagsDeletion"] = new \SleekDB\Store("flagsDeletion", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Lösch-Anfragen

// Sitzungs-überprüfung
require "session.php";
$usertheme = $logged ? $user["theme"] : $_COOKIE["theme"] ?? $config["default"]["theme"];
$userlang = $logged ? $user["lang"] : $_COOKIE["lang"] ?? $config["default"]["lang"];
require file_exists("library/templates/{$usertheme}/info.php") ? "library/templates/{$usertheme}/info.php" : "library/templates/{$config["default"]["theme"]}/info.php";
require file_exists("library/langs/{$userlang}.php") ? "library/langs/{$userlang}.php" : "library/langs/{$config["default"]["lang"]}.php";

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
$smarty->assign("totalvisits", $db["visitLogs"]->count());

// Für das Menü
$pages = array(
    "isAccount" => false,
    "isBrowse" => false,
    "isComments" => false,
    "isTags" => false,
    "isForums" => false,
    "isWiki" => false,
    "isMore" => false
);

// Nun alles unwichtige andere
visit();
$url = trim(parse_url((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}", PHP_URL_SCHEME) . '://' . parse_url((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}", PHP_URL_HOST), "/");
$url = $url . substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], '/') + 1);
$smarty->assign("url", $url);

// Theme und/oder Sprache ändern
if (isset($_POST["customize"])) {
    $_theme = $_POST["theme"];
    $_lang = $_POST["lang"];

    if ($logged) {
        $db["users"]->updateById($user["_id"], ["theme" => $_theme, "lang" => $_lang]);
    }
    setcookie("theme", $_theme, time() + 606024 * 9999, "/");
    setcookie("lang", $_lang, time() + 606024 * 9999, "/");
    doLog("customize", true, "theme: " . $_theme . "; lang: " . $_lang, $logged ? $user["_id"] : null);
    header("Refresh: 0");
}

// Arrays für Themes und Sprachen erstellen
$langs = array();
$themes = array();
foreach (glob(platformSlashes(__DIR__ . "/library/langs/*.php")) as $_lang) {
    require $_lang;
    array_push($langs, $lang[0]);
}
foreach (glob(platformSlashes($config["smarty"]["template"] . "*")) as $_theme) {
    require_once platformSlashes($_theme . "/info.php");
    array_push($themes, $theme);
}
$smarty->assign("langs", $langs);
$smarty->assign("themes", $themes);

$endtime = microtime(true);
$smarty->assign("loadingtime", substr($endtime - $starttime, 0, -10));

// Getting all plugins for the Theme
foreach ($theme["plugins"] as $reqPlugin) {
    if (!file_exists(ps(__DIR__ . "/library/plugins/" . $reqPlugin . ".php")))
        die("This theme requires following plugin to be enabled: " . $reqPlugin);
    require_once ps(__DIR__ . "/library/plugins/" . $reqPlugin . ".php");
}
