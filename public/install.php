<?php

// Not finished yet.
header("Location: index.php");
die();

$step = 1;
if (isset($_GET["step"]) && !empty($_GET["step"]) && is_numeric($_GET["step"])) {
    $step = $_GET["step"];
}
$steps = [1, 2, 3, 4, 5, 6];
if (!in_array($step, $steps)) $step = 1;

/* ************ *
 * Config Start *
 * ************ */

require "../funky.php";

// Schon installiert?
if (file_exists(ps(__DIR__ . "/../.installed"))) {
    header("Location: index.php");
    die("softare already installed. if it isn't the case, delete .installed in the software root directory.");
}

// Fürs Debugging
$debug = false;
if (isset($_GET["debug"])) {
    $debug = true;
}
$debug == true ? error_reporting(E_ALL) && ini_set('display_errors', 1) : error_reporting(0) && ini_set('display_errors', 0);

// Alles für Smarty, wenn wir bei Schritt drei sind
if ($step == 3) {
    // Hier initialisieren wir die Template-Engine und erstellen direkt ein Element
    require_once ps(__DIR__ . "/../library/smarty/libs/Smarty.class.php");
    $smarty = new Smarty();

    // Hier setzen wir alle wichtige Verzeichnisse
    $smarty->setTemplateDir(platformSlashes($config["smarty"]["template"] . $usertheme));
    $smarty->setConfigDir(platformSlashes($config["smarty"]["config"]));
    $smarty->setCompileDir(platformSlashes($config["smarty"]["compile"]));
    $smarty->setCacheDir(platformSlashes($config["smarty"]["cache"]));
}

// Thema für das Installations-Front-End
$theme = "eve";
if (isset($_GET["theme"]) && !empty($_GET["theme"])) {
    $theme = clean($_GET["theme"]);
}
require file_exists(ps(__DIR__ . "/../library/templates/{$theme}/info.php")) ? ps(__DIR__ . "/../library/templates/{$theme}/info.php") : ps(__DIR__ . "/../library/templates/eve/info.php");

// Das Gleiche für die Sprache
$lang = "en";
if (isset($_GET["lang"]) && !empty($_GET["lang"])) {
    $lang = clean($_GET["lang"]);
}
require file_exists(ps(__DIR__ . "/../library/langs/{$lang}.php")) ? ps(__DIR__ . "/../library/langs/{$lang}.php") : ps(__DIR__ . "/../library/langs/en.php");

/* *********** *
 * Config Ende *
 * *********** */
