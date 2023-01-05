<?php

$config["title"] = "Xenooru";
$config["slogan"] = "Booru made simple";
$config["logo"] = "logo.png";
$config["chibi"] = "chibi.png";
$config["logs"] = true; // Keep logs of actions?

// Emails
$config["email"]["general"] = "hello@domain.com";
$config["email"]["info"] = "info@domain.com";

// Captcha
$config["captcha"]["enabled"] = false;
$config["captcha"]["type"] = "hcaptcha";
$config["captcha"]["hcaptcha"]["secret"] = "";
$config["captcha"]["hcaptcha"]["sitekey"] = "";

// Upload
$config["upload"]["max"] = 22020096; // in Bytes, 21mb is a tribute to 21Alex, old friend. help: https://www.gbmb.org/mb-to-bytes
$config["upload"]["allowed"]["img"] = array(
    ".jpg",
    ".jpeg",
    ".gif",
    ".png",
    ".webp",
);
$config["upload"]["allowed"]["video"] = array(
    ".mp4",
    ".webm",
    ".ogv",
    ".avi",
    ".mkv",
);
$config["upload"]["min"] = 1; // Min amount of tags on new/existing post

// Thumbnails
$config["thumbnail"]["enabled"] = true; // Requires Imagick, generation will keep aspect ratio!
$config["thumbnail"]["width"] = "300"; // Pixel, max-width for generation
$config["thumbnail"]["height"] = "200"; // Pixel, max-height for generation
$config["thumbnail"]["blacklisted"] = "assets/img/nothing.png";

// Default-Variablen
$config["default"]["theme"] = "eve";
$config["default"]["lang"] = "en";
$config["default"]["level"] = 50;

// X Elemente von Y pro Seite
$config["perpage"]["users"] = 50;
$config["perpage"]["posts"] = 36;
$config["perpage"]["comments"] = 50;
$config["perpage"]["announcements"] = 50;
$config["perpage"]["tags"] = 100;

// Diese Software nutzt Smarty als Template-Engine. Dokumentation: https://smarty-php.github.io/smarty/
$config["smarty"]["template"] = __DIR__ . "/../library/templates/"; // Dies muss mit einen Schrägstriche enden!
$config["smarty"]["config"] = __DIR__ . "/../library/smarty/config";
$config["smarty"]["compile"] = __DIR__ . "/../library/smarty/compile";
$config["smarty"]["cache"] = __DIR__ . "/../library/smarty/cache";

// Diese Software nutzt SleekDB als Datenbank. Dokumentation: https://sleekdb.github.io/
$config["db"]["thumbs"][0] = "community/thumbs"; // in /public/
$config["db"]["thumbs"][1] = __DIR__ . "/../public/community/thumbs";
$config["db"]["uploads"][0] = "community/uploads"; // in /public/
$config["db"]["uploads"][1] = __DIR__ . "/../public/community/uploads";
$config["db"]["path"] = __DIR__ . "/../database";
$config["db"]["config"] = array(
    "auto_cache" => true,
    "cache_lifetime" => null,
    "timeout" => false, // deprecated! Set it to false!
    "primary_key" => "_id",
    "search" => [
        "min_length" => 2,
        "mode" => "and",
        "score_key" => "scoreKey"
    ],
    "folder_permissions" => 0777
);
