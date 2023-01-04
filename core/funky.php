<?php

function platformSlashes($path)
{
    return str_replace('/', DIRECTORY_SEPARATOR, $path);
}

function genToken()
{
    return md5(rand());
}

function now()
{
    return date("d-m-y h:i:s");
}

function doLog($action, $success, $value = null, $user = null)
{
    require "config.php";
    if ($config["logs"]) {
        require_once "../library/SleekDB/Store.php";
        if (empty($action)) return false;
        if (!empty($user) && !is_numeric($user)) return false;
        $db = new \SleekDB\Store("logs", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Besucher-Logs
        $data = array(
            "action" => $action,
            "success" => $success,
            "value" => $value,
            "user" => $user,
            "ip" => $_SERVER["REMOTE_ADDR"],
            "timestamp" => now()
        );
        $db->insert($data);
    }
    return true;
}

function visit()
{
    require "config.php";
    require_once platformSlashes(__DIR__ . "/../library/SleekDB/Store.php");
    $db = new \SleekDB\Store("visitLogs", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Besucher-Logs
    if (empty($db->findOneBy(["ip", "=", $_SERVER["REMOTE_ADDR"]]))) {
        $data = array(
            "ip" => $config["logs"] ? $_SERVER["REMOTE_ADDR"] : null,
            "timestamp" => now()
        );
        $db->insert($data);
    }
}

function hCaptcha($response)
{
    require "config.php";
    $data = array(
        "secret" => $config["captcha"]["hcaptcha"]["secret"],
        "response" => $response
    );
    $verify = curl_init();
    curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
    curl_setopt($verify, CURLOPT_POST, true);
    curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
    $responseData = json_decode(curl_exec($verify));
    return $responseData->success ? true : false;
}

function formatBytes($size, $precision = 2)
{
    $base = log($size, 1024);
    $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');
    return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
}

function genUuid()
{
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0C2f) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0x2Aff),
        mt_rand(0, 0xffD3),
        mt_rand(0, 0xff4B)
    );
}

function processTags($tags)
{
    require "config.php";
    require_once platformSlashes(__DIR__ . "/../library/SleekDB/Store.php");
    $db = new \SleekDB\Store("tags", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Besucher-Logs
    $tags = explode(" ", $tags);
    $_tags = "";
    foreach ($tags as $tag) {
        if (!empty($tag)) {
            if (empty($db->findBy(["name", "=", $tag]))) {
                $data = array(
                    "name" => $tag,
                    "modified" => now(),
                    "timestamp" => now()
                );
                $tag = $db->insert($data);
            }
            $_tags .= $tag["name"] . " ";
        }
    }
    return trim($_tags);
}

function isLandsape($file)
{
    list($width, $height) = getimagesize($file);
    return $width > $height ? "landscape" : "portrait";
}
