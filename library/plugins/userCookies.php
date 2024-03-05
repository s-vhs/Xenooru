<?php

if ($logged) {
    setcookie("blacklist", $user["blacklist"] ?? "", time() + 606024 * 9999, "/");
    setcookie("commentThreshold", $user["commentThreshold"] ?? "", time() + 606024 * 9999, "/");
    setcookie("postThreshold", $user["postThreshold"] ?? "", time() + 606024 * 9999, "/");
    setcookie("myTags", $user["myTags"] ?? "", time() + 606024 * 9999, "/");
    setcookie("safeOnly", $user["safeOnly"] ?? "", time() + 606024 * 9999, "/");
}
