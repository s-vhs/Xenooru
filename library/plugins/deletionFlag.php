<?php

if (isset($_GET["page"]) && !empty($_GET["page"]) && $_GET["page"] == "post" && isset($_GET["id"]) && !empty($_GET["id"]) && is_numeric($_GET["id"]) && $logged && $userlevel["perms"]["can_report"]) {
    $postId = clean($_GET["id"]);
    if (empty($db["posts"]->findById($postId))) {
        doLog("flagPost", false, "unknown post: " . $postId, $user["_id"]);
        die("unknown post.");
    }
    $flagged = $db["flagsDeletion"]->findOneBy([["user", "==", $user["_id"]], "AND", ["post", "==", $postId]]);
    if (empty($flagged))
        $_flagged = false;
    else
        $_flagged = true;

    if ($_flagged) {
        $reason = $flagged["rejectedReason"];
        $smarty->assign("deletionFlagRejectionReason", $reason);
    }
    $smarty->assign("hasFlaggedForDeletion", $_flagged);
}
