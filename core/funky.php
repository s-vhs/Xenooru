<?php

function clean($data)
{
    $data = htmlspecialchars($data);
    $data = strip_tags($data);
    $data = stripslashes($data);
    $data = trim($data);
    return $data;
}

function stripNumbers($input)
{
    return preg_replace('/[^0-9]/', '', json_encode($input));
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
        require_once platformSlashes(__DIR__ . "/../library/SleekDB/Store.php");
        $db = new \SleekDB\Store("logs", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Logs
        if (empty($action)) return false;
        if (!empty($user) && !is_numeric($user)) return false;
        $data = array(
            "action" => clean($action),
            "success" => $success,
            "value" => clean($value),
            "user" => $user,
            "ip" => clean($_SERVER["REMOTE_ADDR"]),
            "timestamp" => now()
        );
        $db->insert($data);
    }
    return true;
}

function logTags(int $post, string $rating, string $before, string $after, string $source, string $title, int $user, string $username)
{
    require "config.php";
    require_once platformSlashes(__DIR__ . "/../library/SleekDB/Store.php");
    $db = new \SleekDB\Store("tagLogs", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Tag-Logs
    if (empty($post) || !is_numeric($post)) return false;
    if (empty($after)) return false;
    if (empty($rating)) return false;
    if (!empty($user) && !is_numeric($user)) return false;
    $data = array(
        "post" => stripNumbers($post),
        "rating" => clean(strtolower($rating)),
        "before" => clean(strtolower($before)),
        "after" => clean(strtolower($after)),
        "source" => clean($source),
        "title" => clean($title),
        "user" => $user,
        "username" => clean($username),
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
    if (empty($db->findOneBy(["ip", "==", clean($_SERVER["REMOTE_ADDR"])]))) {
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
    return (substr($string, 0, $len) == $startString);
}

function toStringWithSpaces(array $array)
{
    if (empty($array) || !is_array($array)) return false;
    $_items = "";
    foreach ($array as $item) {
        $_items .= substr(clean($item), 0, 75) . " ";
    }
    return trim($_items);
}

function toArrayFromSpaces(string $string): array
{
    $trimmedString = trim(clean($string));
    if (empty($trimmedString)) {
        return [];
    }
    $items = explode(' ', $trimmedString);
    $result = [];
    foreach ($items as $item) {
        $result[] = substr(trim($item), 0, 75);
    }
    return $result;
}

// function toArrayFromSpaces(string $string)
// {
//     if (empty($string)) return false;
//     $_items = array();
//     $array = explode(" ", trim(clean($string)));
//     foreach ($array as $item) {
//         array_push($_items, trim(substr($item, 0, 75)));
//     }
//     return $_items;
// }

function processTags($tags)
{
    require "config.php";
    require_once platformSlashes(__DIR__ . "/../library/SleekDB/Store.php");

    if (!is_array($tags)) $tags = toArrayFromSpaces($tags);

    $db = new \SleekDB\Store("tags", platformSlashes($config["db"]["path"]), $config["db"]["config"]);
    $tagsArray = [];
    $tagsArrayRaw = [];
    $_tags = "";
    $_tagsRaw = "";

    foreach ($tags as $tag) {
        $tag = trim($tag);
        if (empty($tag)) {
            continue;
        }

        $tagRaw = $tag;
        $tag = substr(clean($tag), 0, 75);
        $tag = strtolower($tag);

        $type = "tag";
        $prefixes = ["artist:", "a:", "character:", "char:", "c:", "meta:", "m:", "copyright:", "copy:", "cp:", "tag:", "t:"];
        foreach ($prefixes as $prefix) {
            if (startsWith($tag, $prefix)) {
                switch ($prefix) {
                    case "artist:":
                    case "a:":
                        $type = "artist";
                        break;
                    case "character:":
                    case "char:":
                    case "c:":
                        $type = "character";
                        break;
                    case "meta:":
                    case "m:":
                        $type = "meta";
                        break;
                    case "copyright:":
                    case "copy:":
                    case "cp:":
                        $type = "copyright";
                        break;
                    case "tag:":
                    case "t:":
                    default:
                        $type = "tag";
                        break;
                }
                $tag = substr($tag, strlen($prefix));
                break;
            }
        }

        $_tag = $db->findOneBy([["name", "==", $tag], "AND", ["type", "==", $type]]);
        if (empty($_tag)) {
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
                default:
                    $order = 4;
                    break;
            }
            $data = [
                "name" => $tag,
                "type" => $type,
                "order" => $order,
                "modified" => now(),
                "timestamp" => now(),
            ];
            $db->insert($data);
        }

        $tagsArray[] = $tag;
        $tagsArrayRaw[] = $tagRaw;
    }

    if (!empty($tagsArray) && !empty($tagsArrayRaw)) {
        sort($tagsArray);
        foreach ($tagsArray as $tag) {
            $_tags .= trim(clean($tag)) . " ";
        }

        sort($tagsArrayRaw);
        foreach ($tagsArrayRaw as $tag) {
            $_tagsRaw .= trim(clean($tag)) . " ";
        }
    }

    return [
        "tags" => trim($_tags),
        "raw" => $_tagsRaw,
        "amount" => count($tagsArray),
    ];
}

function whateverThisDoes($tag)
{
    $type = "tag";
    $prefixes = ["artist:", "a:", "character:", "char:", "c:", "meta:", "m:", "copyright:", "copy:", "cp:", "tag:", "t:"];
    foreach ($prefixes as $prefix) {
        if (startsWith($tag, $prefix)) {
            switch ($prefix) {
                case "artist:":
                case "a:":
                    $type = "artist";
                    break;
                case "character:":
                case "char:":
                case "c:":
                    $type = "character";
                    break;
                case "meta:":
                case "m:":
                    $type = "meta";
                    break;
                case "copyright:":
                case "copy:":
                case "cp:":
                    $type = "copyright";
                    break;
                case "tag:":
                case "t:":
                default:
                    $type = "tag";
                    break;
            }
            $tag = substr($tag, strlen($prefix));
            break;
        }
    }
    return array($type, $tag);
}

function checkTags(int $post, $raws)
{
    if (!is_array($raws)) $raws = toArrayFromSpaces(clean($raws));
    require "config.php";
    require_once platformSlashes(__DIR__ . "/../library/SleekDB/Store.php");
    $db["tags"] = new \SleekDB\Store("tags", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Tags
    $db["tagRelations"] = new \SleekDB\Store("tagRelations", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Tags-Verknüpfungen
    $post = $db["tags"]->findById($post);
    if (empty($post)) return "Post does not exist";
    // $relations = $db["tagRelations"]->findBy(["post", "==", $post["_id"]]);
    // $_tags = clean(toStringWithSpaces($tags));
    // $tags = toArrayFromSpaces(processTags($_tags)["raw"]);
    // print_r($tags);
    // if (!empty($relations)) {
    //     foreach ($relations as $rel) {
    //         if (!in_array($rel["name"], $tags)) $db["tagRelations"]->deleteById($rel["_id"]);
    //     }
    // }
    foreach ($raws as $tag) {
        $type = whateverThisDoes($tag)[0];
        $tag = whateverThisDoes($tag)[1];
        $search = $db["tagRelations"]->findBy([["post", "==", $post["_id"]], "AND", ["name", "==", $tag], "AND", ["type", "==", $type]]);
        if (empty($search)) {
            $tag = strtolower(substr(clean($tag), 0, 75));
            $_tag = $db["tags"]->findOneBy([["name", "==", $tag], "AND", ["type", "==", $type]]);
            $data = array(
                "tag" => $_tag["_id"],
                "name" => clean($_tag["name"]),
                "type" => $_tag["type"],
                "order" => $_tag["order"],
                "post" => $post["_id"],
                "timestamp" => now()
            );
            empty($db["tagRelations"]->findBy([["post", "==", $post["_id"]], "AND", ["name", "==", $tag], "AND", ["type", "==", $_tag["type"]]])) ? $db["tagRelations"]->insert($data) : null;
        } else {
            $rel = $db["tagRelations"]->findOneBy([["post", "==", $post["_id"]], "AND", ["name", "==", $tag]]);
            if (!empty($rel["_id"]))
                $db["tagRelations"]->deleteById($rel["_id"]);
        }
    }
    return $raws;
}

function isLandsape($file)
{
    list($width, $height) = getimagesize($file);
    return $width > $height ? "landscape" : "portrait";
}
