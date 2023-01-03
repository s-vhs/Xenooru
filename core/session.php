<?php

$logged = false;
$user = array();
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
