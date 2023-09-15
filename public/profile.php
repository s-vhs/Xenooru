<?php

require "../autoload.php";

$pages["isAccount"] = true;
$uid = $user["_id"];
if (isset($_GET["id"]) && !empty($_GET["id"]) && is_numeric($_GET["id"])) {
    $uid = clean($_GET["id"]);
}
$profile = $db["users"]->findById($uid);
if (empty($profile)) {
    header("Location: error.php");
    die("trolling.");
}
$profilelevel = $db["levels"]->findOneBy(["level", "==", $profile["level"]]);
if (empty($profilelevel)) {
    die("Something went wrong with this user's user level. Please contact the administration.");
}
$profileposts = $db["posts"]->findBy(["user", "==", $profile["_id"]], ["timestamp" => "DESC"]);
$postcount = count($profileposts);
$profileposts = array_slice($profileposts, 0, 6);

$profilefavourites = $db["favourites"]->findBy(["user", "==", $profile["_id"]], ["timestamp" => "DESC"]);
$auxArray = [];
$c = 1;
foreach ($profilefavourites as $pf) {
    if (!$c <= 6) {
        $post = $db["posts"]->findById($pf["post"]);
        if (!empty($post))
            $auxArray[] = $post;
    }
    $c++;
}
$favouritecount = count($profilefavourites);
$profilefavourites = array_slice($auxArray, 0, 6);

$commentcount = count($db["comments"]->findBy(["user", "==", $profile["_id"]]));

$smarty->assign("profile", $profile);
$smarty->assign("profilelevel", $profilelevel);
$smarty->assign("profileposts", $profileposts);
$smarty->assign("postcount", $postcount);
$smarty->assign("profilefavourites", $profilefavourites);
$smarty->assign("favouritecount", $favouritecount);
$smarty->assign("commentcount", $commentcount);
$smarty->assign("pages", $pages);
$smarty->assign("pagetitle", $lang["profile_of"] . " " . $profile["username"]);

require "../endtime.php";

$smarty->display("part.top.tpl");
$smarty->display("page.profile.tpl");
$smarty->display("part.bottom.tpl");
