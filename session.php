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
    $session = $db["sessions"]->findOneBy(["token", "==", $token]);
    if (!empty($session)) {
        $user = $db["users"]->findOneBy(["_id", "==", $session["user"]]);
        if (!empty($user)) {
            $logged = true;
        }
    }
}
$smarty->assign("logged", $logged);
$smarty->assign("user", $user);
