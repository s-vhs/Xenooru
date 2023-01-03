<?php

require "autoload.php";

if ($logged) {
    $db["sessions"]->deleteById($session["_id"]);
}

header("Location: account.php");
