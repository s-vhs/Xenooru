<?php

function clean($data)
{
    $data = htmlspecialchars($data);
    $data = strip_tags($data);
    $data = stripslashes($data);
    $data = trim($data);
    return $data;
}

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
    return date("d-m-Y h:i:s");
}

function doLog($action, bool $success, $value = null, $user = null)
{
    require "config.php";
    if ($config["logs"]) {
        require_once "../library/SleekDB/Store.php";
        if (empty($action)) return false;
        if (!empty($user) && !is_numeric($user)) return false;
        $db = new \SleekDB\Store("logs", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Besucher-Logs
        $data = array(
            "action" => clean($action),
            "success" => $success,
            "value" => clean($value),
            "user" => clean($user),
            "ip" => clean($_SERVER["REMOTE_ADDR"]),
            "timestamp" => now()
        );
        $db->insert($data);
    }
    return true;
}

function logTags($post, $before, $after, $user)
{
    require "config.php";
    require_once "../library/SleekDB/Store.php";
    if (empty($post) || !is_numeric($post)) return false;
    if (empty($after)) return false;
    if (!empty($user) && !is_numeric($user)) return false;
    $db = new \SleekDB\Store("tagLogs", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Besucher-Logs
    $data = array(
        "post" => clean($post),
        "before" => clean($before),
        "after" => clean($after),
        "user" => clean($user),
        "ip" => clean($_SERVER["REMOTE_ADDR"]),
        "timestamp" => now()
    );
    $db->insert($data);
    return true;
}

function visit()
{
    require "config.php";
    require_once platformSlashes(__DIR__ . "/../library/SleekDB/Store.php");
    $db = new \SleekDB\Store("visitLogs", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Besucher-Logs
    if (empty($db->findOneBy(["ip", "=", clean($_SERVER["REMOTE_ADDR"])]))) {
        $data = array(
            "ip" => clean($_SERVER["REMOTE_ADDR"]),
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

function startsWith($string, $startString)
{
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}

function toStringWithSpaces(array $array)
{
    if (empty($array) || !is_array($array)) return false;
    $_items = "";
    foreach ($array as $item) {
        $_items .= $item . " ";
    }
    return trim($_items);
}

function toArrayFromSpaces(string $string)
{
    if (empty($string)) return false;
    $_items = array();
    $array = explode(" ", trim($string));
    foreach ($array as $item) {
        array_push($_items, trim($item));
    }
    return $_items;
}

function processTags($tags)
{
    require "config.php";
    require_once platformSlashes(__DIR__ . "/../library/SleekDB/Store.php");
    $db = new \SleekDB\Store("tags", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Besucher-Logs
    if (!is_array($tags)) $tags = explode(" ", clean($tags));
    $tagsArray = array();
    $_tags = "";
    $amount = 0;
    foreach ($tags as $tag) {
        if (!empty($tag)) {
            $tag = clean($tag);
            if (startsWith($tag, "artist:") || startsWith($tag, "tag:") || startsWith($tag, "character:") || startsWith($tag, "char:") || startsWith($tag, "copyright:") || startsWith($tag, "copy:") || startsWith($tag, "meta:")) {
                if (startsWith($tag, "artist:")) {
                    $type = "artist";
                    $tag = substr($tag, 7);
                    $chosen = true;
                } elseif (startsWith($tag, "character:") || startsWith($tag, "char:")) {
                    $type = "character";
                    if (startsWith($tag, "char:"))
                        $tag = substr($tag, 5);
                    else
                        $tag = substr($tag, 10);
                    $chosen = true;
                } elseif (startsWith($tag, "meta:")) {
                    $type = "meta";
                    $tag = substr($tag, 5);
                    $chosen = true;
                } elseif (startsWith($tag, "tag:")) {
                    $type = "tag";
                    $tag = substr($tag, 4);
                    $chosen = true;
                } else {
                    $type = "copyright";
                    if (startsWith($tag, "copy:"))
                        $tag = substr($tag, 5);
                    else
                        $tag = substr($tag, 10);
                    $chosen = true;
                }
            } else {
                $type = "tag";
                $chosen = false;
            }
            $_tag = $db->findBy(["name", "=", $tag]);
            if (($chosen && empty($db->findBy([["name", "=", $tag], "AND", ["type", "=", $type]]))) || (!$chosen && empty($_tag))) {
                switch ($type) {
                    case "copyright":
                        $order = 1;
                        break;
                    case "character":
                        $order = 2;
                        break;
                    case "artist":
                        $order = 3;
                        break;
                    case "tag":
                        $order = 4;
                        break;
                    default:
                        $order = 5;
                }
                $data = array(
                    "name" => $tag,
                    "type" => $type,
                    "order" => $order,
                    "modified" => now(),
                    "timestamp" => now()
                );
                $db->insert($data);
            }
            array_push($tagsArray, $tag);
            $amount++;
        }
    }
    if (!empty($tagsArray)) {
        sort($tagsArray);
        foreach ($tagsArray as $tag) {
            $_tags .= $tag . " ";
        }
    }
    return array("tags" => trim($_tags), "amount" => $amount);
}

function checkTags(int $post, $tags)
{
    if (!is_array($tags)) $tags = toArrayFromSpaces(clean($tags));
    require "config.php";
    require_once platformSlashes(__DIR__ . "/../library/SleekDB/Store.php");
    $db["tags"] = new \SleekDB\Store("tags", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Tags
    $db["tagRelations"] = new \SleekDB\Store("tagRelations", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Tags-Verknüpfungen
    $post = $db["tags"]->findById($post);
    if (empty($post)) return "Post does not exist";
    $relations = $db["tagRelations"]->findBy(["post", "=", $post["_id"]]);
    $_tags = clean(toStringWithSpaces($tags));
    processTags($_tags);
    if (!empty($relations)) {
        foreach ($relations as $rel) {
            if (!in_array($rel["name"], $tags)) $db["tagRelations"]->deleteById($rel["_id"]);
        }
    }
    foreach ($tags as $tag) {
        $tag = clean($tag);
        $_tag = $db["tags"]->findOneBy(["name", "=", $tag]);
        $data = array(
            "tag" => $_tag["_id"],
            "name" => clean($_tag["name"]),
            "type" => $_tag["type"],
            "order" => $_tag["order"],
            "post" => $post["_id"],
            "timestamp" => now()
        );
        if (empty($db["tagRelations"]->findBy([["post", "=", $post["_id"]], "AND", ["name", "=", $tag]]))) $db["tagRelations"]->insert($data);
    }
    return $tags;
}

function isLandsape($file)
{
    list($width, $height) = getimagesize($file);
    return $width > $height ? "landscape" : "portrait";
}
