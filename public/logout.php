<?php

require "../autoload.php";

if ($logged) {
    doLog("logout", true, null, $user["_id"]);
    $db["sessions"]->deleteById($session["_id"]);
}

header("Location: account.php");
