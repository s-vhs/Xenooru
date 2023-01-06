<?php

$logged = false;
$user = array(
    "blacklist" => clean($_COOKIE["blacklist"] ?? null),
    "commentThreshold" => clean($_COOKIE["commentThreshold"] ?? null),
    "postThreshold" => clean($_COOKIE["postThreshold"] ?? null),
    "myTags" => clean($_COOKIE["myTags"] ?? null),
    "safeOnly" => clean($_COOKIE["safeOnly"] ?? null)
);
if (isset($_COOKIE["session"]) && !empty($_COOKIE["session"])) {
    $token = clean($_COOKIE["session"]);
    $session = $db["sessions"]->findOneBy(["token", "=", $token]);
    if ($session) {
        $logged = true;
        $user = $db["users"]->findOneBy(["_id", "=", $session["user"]]);
    }
}
$smarty->assign("logged", $logged);
$smarty->assign("user", $user);
