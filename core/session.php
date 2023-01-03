<?php

$logged = false;
$user = array(
    "blacklist" => $_COOKIE["blacklist"] ?? null,
    "commentThreshold" => $_COOKIE["commentThreshold"] ?? null,
    "postThreshold" => $_COOKIE["postThreshold"] ?? null,
    "myTags" => $_COOKIE["myTags"] ?? null,
    "safeOnly" => $_COOKIE["safeOnly"] ?? null
);
if (isset($_COOKIE["session"]) && !empty($_COOKIE["session"])) {
    $token = $_COOKIE["session"];
    $session = $db["sessions"]->findOneBy(["token", "=", $token]);
    if ($session) {
        $logged = true;
        $user = $db["users"]->findOneBy(["_id", "=", $session["user"]]);
    }
}
$smarty->assign("logged", $logged);
$smarty->assign("user", $user);
