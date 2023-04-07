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

function toStringWithSpaces(array $array): string
{
    if (empty($array)) {
        return "";
    }
    $items = array_map(function ($item) {
        return substr(strtolower(trim(clean($item))), 0, 75);
    }, $array);
    return implode(" ", $items);
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
        $result[] = substr(strtolower(clean(trim($item))), 0, 75);
    }
    return $result;
}

function getTagAmount($tags)
{
    if (!is_array($tags)) {
        $tags = toArrayFromSpaces($tags);
    }
    return count($tags);
}

function parseTag($tag)
{
    $type = "tag";
    $prefixes = ["artist:", "a:", "character:", "char:", "c:", "meta:", "m:", "copyright:", "copy:", "cp:", "tag:", "t:"];

    foreach ($prefixes as $prefix) {
        if (startsWith($tag, $prefix)) {
            $tag = substr($tag, strlen($prefix));
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
                default:
                    $type = "tag";
            }
            break;
        }
    }

    return ["type" => $type, "tag" => $tag, "full" => $type . ":" . $tag];
}

function ps($path)
{
    return str_replace("/", DIRECTORY_SEPARATOR, $path);
}

function getOrder($type)
{
    $orderMap = [
        "copyright" => 1,
        "character" => 2,
        "artist" => 3,
        "tag" => 4
    ];

    return $orderMap[$type] ?? 5;
}

function processTags(int $postId, $tags)
{
    if (!is_array($tags)) $tags = toArrayFromSpaces($tags);
    require "config.php";
    require_once platformSlashes(__DIR__ . "/../library/SleekDB/Store.php");
    $db["tags"] = new \SleekDB\Store("tags", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Tags
    $db["tagRelations"] = new \SleekDB\Store("tagRelations", platformSlashes($config["db"]["path"]), $config["db"]["config"]); // Tags-Verknüpfungen
    // $post = $db["tags"]->findById($postId);
    // if (empty($post)) return "Post does not exist";
    $finalTags = array();

    $relations = $db["tagRelations"]->findBy(["post", "==", $postId]);
    $rels = array();
    foreach ($relations as $rel) {
        array_push($rels, $rel["full"]);
    }

    foreach ($tags as $_tag) {
        $tag = parseTag($_tag);
        $order = getOrder($tag["type"]);

        $exTag = $db["tags"]->findOneBy([["name", "==", $tag["tag"]], "AND", ["type", "==", $tag["type"]]]);
        $data = [
            "name" => clean($tag["tag"]),
            "type" => $tag["type"],
            "full" => clean($tag["full"]),
            "order" => $order,
            "modified" => now(),
            "timestamp" => now()
        ];
        if (empty($exTag)) {
            $db["tags"]->insert($data);
            $exTag = $db["tags"]->findOneBy([["name", "==", $tag["tag"]], "AND", ["type", "==", $tag["type"]]]);
        }

        $data = [
            "tag" => $exTag["_id"],
            "name" => clean($tag["tag"]),
            "type" => $tag["type"],
            "full" => clean($tag["full"]),
            "order" => $order,
            "post" => $postId,
            "timestamp" => now()
        ];

        $relation = array();
        $relation = $db["tagRelations"]->findOneBy([["post", "==", $postId], "AND", ["full", "==", $tag["full"]]]);
        if (empty($relation))
            $db["tagRelations"]->insert($data);

        array_push($finalTags, $tag["full"]);
    }

    foreach ($rels as $relation) {
        if (!in_array($relation, $finalTags))
            $db["tagRelations"]->deleteBy(["full", "==", clean($relation)]);
    }

    return toStringWithSpaces($finalTags);
}

function isLandsape($file)
{
    list($width, $height) = getimagesize($file);
    return $width > $height ? "landscape" : "portrait";
}
