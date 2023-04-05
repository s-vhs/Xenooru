<?php

require "../autoload.php";

$pages["isAccount"] = true;
switch ($_GET["tab"] ?? "home") {
    case "login":
        $tab = "login";
        break;
    case "signup":
        $tab = "signup";
        break;
    case "options":
        $tab = "options";
        break;
    case "forgot":
        $tab = "forgot";
        break;
    default:
        $tab = "home";
}
$smarty->assign("tab", $tab);
$smarty->assign("pages", $pages);
$smarty->assign("pagetitle", $lang["my_account"]);

if (!$logged) {
    if (isset($_POST["login"])) {
        $username = clean($_POST["username"]);
        $password = clean($_POST["password"]);

        $error = false;
        if ($config["captcha"]["enabled"]) {
            if ($config["captcha"]["type"] == "hcaptcha") {
                if (!hCaptcha($_POST["h-captcha-response"])) $error = true && $smarty->assign("error", "Captcha is wrong!");
            }
        }
        if (empty($username)) $error = true && $smarty->assign("error", "Username is empty!");
        if (empty($password)) $error = true && $smarty->assign("error", "Password is empty!");
        if (strlen($username) < 3 || strlen($username) > 50) $error = true && $smarty->assign("error", "Username needs to be between 3 and 50 characters.");
        if (strlen($password) < 8 || strlen($password) > 64) $error = true && $smarty->assign("error", "Password needs to be between 8 and 64 characters.");

        if (!$error) {
            $check = $db["users"]->findOneBy(["username", "=", $username]);
            if (!empty($check)) {
                if (password_verify($password, $check["password"])) {
                    if ($check["banned"]) {
                        doLog("login", false, "banned", $check["_id"]);
                        $smarty->assign("error", "Banned! Reason: " . $check["bannedReason"]);
                    } else {
                        $token = genToken();
                        $session = array(
                            "user" => $check["_id"],
                            "token" => $token,
                            "ip" => $_SERVER["REMOTE_ADDR"]
                        );
                        $db["sessions"]->insert($session);
                        setcookie("session", $token, time() + 606024 * 9999, "/");
                        doLog("login", true, null, $check["_id"]);
                        header("Location: account.php?tab=home");
                    }
                } else {
                    doLog("login", false, "wrong password", $check["_id"]);
                    $smarty->assign("error", "Wrong Password!");
                }
            } else {
                doLog("login", false, "user not found");
                $smarty->assign("error", "User not found!");
            }
        } else {
            doLog("login", false, "some error");
        }
    }

    if (isset($_POST["signup"])) {
        $username = clean($_POST["username"]);
        $password = clean($_POST["password"]);
        $password2 = clean($_POST["password2"]);
        $email = clean($_POST["email"]);

        $error = false;
        if ($config["captcha"]["enabled"]) {
            if ($config["captcha"]["type"] == "hcaptcha") {
                if (!hCaptcha($_POST["h-captcha-response"])) $error = true && $smarty->assign("error", "Captcha is wrong!");
            }
        }
        if (empty($username)) $error = true && $smarty->assign("error", "Username is empty!");
        if (empty($password)) $error = true && $smarty->assign("error", "Password is empty!");
        if (strlen($username) < 3 || strlen($username) > 50) $error = true && $smarty->assign("error", "Username needs to be between 3 and 50 characters.");
        if (strlen($password) < 8 || strlen($password) > 64 || strlen($password2) < 8 || strlen($password2) > 64) $error = true && $smarty->assign("error", "Password needs to be between 8 and 64 characters.");
        if ($password != $password2) $error = true && $smarty->assign("error", "Passwords don't match!");
        if (!empty($email) && (strlen($email) < 6 || strlen($email)) > 320) $error = true && $smarty->assign("error", "Email needs to be between 6 and 320 characters.");

        if (!$error) {
            $check = $db["users"]->findOneBy(["username", "=", $username]);
            if (empty($check)) {
                $level = $config["default"]["level"];
                if (empty($db["users"]->findAll()))
                    $level = 100;
                $password = password_hash($password, PASSWORD_BCRYPT);
                $data = array(
                    "username" => $username,
                    "password" => $password,
                    "email" => $email,
                    "level" => $level,
                    "theme" => $usertheme,
                    "lang" => $userlang,
                    "blacklist" => null,
                    "commentThreshold" => 0,
                    "postThreshold" => 0,
                    "myTags" => null,
                    "safeOnly" => false,
                    "banned" => false,
                    "bannedReason" => null,
                    "timestamp" => now()
                );
                $db["users"]->insert($data);
                $token = genToken();
                $check = $db["users"]->findOneBy(["username", "=", $username]);
                $session = array(
                    "user" => $check["_id"],
                    "token" => $token,
                    "ip" => $_SERVER["REMOTE_ADDR"]
                );
                $db["sessions"]->insert($session);
                setcookie("session", $token, time() + 606024 * 9999, "/");
                doLog("signup", true, null, $check["_id"]);
                header("Location: account.php?tab=home");
            } else {
                doLog("signup", false, "username already taken: " . $username);
                $smarty->assign("error", "Username already taken!");
            }
        } else {
            doLog("signup", false, "some error");
        }
    }
}

if (isset($_POST["updateOptions"])) {
    $blacklist = clean($_POST["blacklist"]);
    $cThreshold = clean($_POST["commentThreshold"]);
    $pThreshold = clean($_POST["postThreshold"]);
    $tags = clean($_POST["tags"]);
    $safe = isset($_POST["safeOnly"]) ? true : false;

    $error = false;
    if (!is_numeric($cThreshold) || (empty($cThreshold) && $cThreshold != "0")) $error = true && $smarty->assign("error", "Comment Threshold is not a number!");
    if (!is_numeric($pThreshold) || (empty($pThreshold) && $pThreshold != "0")) $error = true && $smarty->assign("error", "Post Threshold is not a number!");
    if ($cThreshold < 0) $error = true && $smarty->assign("error", "Comment Threshold cannot be lower than 0!");
    if ($pThreshold < 0) $error = true && $smarty->assign("error", "Post Threshold cannot be lower than 0!");

    if (!$error) {
        if ($logged) {
            $data = array(
                "blacklist" => $blacklist,
                "commentThreshold" => $cThreshold,
                "postThreshold" => $pThreshold,
                "myTags" => $tags,
                "safeOnly" => $safe
            );
            $db["users"]->updateById($user["_id"], $data);
        }
        setcookie("blacklist", $blacklist, time() + 606024 * 9999, "/");
        setcookie("commentThreshold", $cThreshold, time() + 606024 * 9999, "/");
        setcookie("postThreshold", $pThreshold, time() + 606024 * 9999, "/");
        setcookie("myTags", $tags, time() + 606024 * 9999, "/");
        setcookie("safeOnly", $safe, time() + 606024 * 9999, "/");
        doLog("options", true, null, $logged ? $user["_id"] : null);
        header("Refresh: 0");
    } else {
        doLog("options", false, "some error", $logged ? $user["_id"] : null);
    }
}

$smarty->display("part.top.tpl");
$smarty->display("page.account.tpl");
$smarty->display("part.bottom.tpl");
