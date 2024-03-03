<?php

$logged = false;
$user = array(
    "blacklist" => clean($_COOKIE["blacklist"] ?? ""),
    "commentThreshold" => clean($_COOKIE["commentThreshold"] ?? ""),
    "postThreshold" => clean($_COOKIE["postThreshold"] ?? ""),
    "myTags" => clean($_COOKIE["myTags"] ?? ""),
    "safeOnly" => clean($_COOKIE["safeOnly"] ?? "")
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
