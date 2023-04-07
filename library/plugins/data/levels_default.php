<?php

$levels = [
    array(
        "level" => 0,
        "name" => "Guest",
        "perms" => array(
            "can_post" => false,
            "can_comment" => false,
            "can_report" => false,
            "needs_approval" => false,

            "can_edit_wiki" => false,
            "can_edit_tag" => false,
            "can_edit_post" => false,
            "can_lock_wiki" => false,
            "can_delete_post" => false,
            "can_manage_favourites" => false,
            "can_vote_post" => false,

            "can_post_forum" => false,
            "can_reply_forum" => false,
            "is_forum_mod" => false,
            "is_forum_admin" => false,

            "can_ban" => false,
            "can_unban" => false,
            "can_manage_reports" => false,
            "can_edit_user" => false,
        )
    ),
    array(
        "level" => 1,
        "name" => "Banned Member",
        "perms" => array(
            "can_post" => false,
            "can_comment" => false,
            "can_report" => false,
            "needs_approval" => false,

            "can_edit_wiki" => false,
            "can_edit_tag" => false,
            "can_edit_post" => false,
            "can_lock_wiki" => false,
            "can_delete_post" => false,
            "can_manage_favourites" => false,
            "can_vote_post" => false,

            "can_post_forum" => false,
            "can_reply_forum" => false,
            "is_forum_mod" => false,
            "is_forum_admin" => false,

            "can_ban" => false,
            "can_unban" => false,
            "can_manage_reports" => false,
            "can_edit_user" => false,
        )
    ),
    array(
        "level" => 49,
        "name" => "Unactivated Member",
        "perms" => array(
            "can_post" => false,
            "can_comment" => true,
            "can_report" => true,
            "needs_approval" => true,

            "can_edit_wiki" => false,
            "can_edit_tag" => false,
            "can_edit_post" => false,
            "can_lock_wiki" => false,
            "can_delete_post" => false,
            "can_manage_favourites" => true,
            "can_vote_post" => true,

            "can_post_forum" => false,
            "can_reply_forum" => false,
            "is_forum_mod" => false,
            "is_forum_admin" => false,

            "can_ban" => false,
            "can_unban" => false,
            "can_manage_reports" => false,
            "can_edit_user" => false,
        )
    ),
    array(
        "level" => 50,
        "name" => "Regular Member",
        "perms" => array(
            "can_post" => true,
            "can_comment" => true,
            "can_report" => true,
            "needs_approval" => false,

            "can_edit_wiki" => true,
            "can_edit_tag" => false,
            "can_edit_post" => true,
            "can_lock_wiki" => false,
            "can_delete_post" => false,
            "can_manage_favourites" => true,
            "can_vote_post" => true,

            "can_post_forum" => true,
            "can_reply_forum" => true,
            "is_forum_mod" => false,
            "is_forum_admin" => false,

            "can_ban" => false,
            "can_unban" => false,
            "can_manage_reports" => false,
            "can_edit_user" => false,
        )
    ),
    array(
        "level" => 75,
        "name" => "Moderator",
        "perms" => array(
            "can_post" => true,
            "can_comment" => true,
            "can_report" => true,
            "needs_approval" => false,

            "can_edit_wiki" => true,
            "can_edit_tag" => true,
            "can_edit_post" => true,
            "can_lock_wiki" => true,
            "can_delete_post" => true,
            "can_manage_favourites" => true,
            "can_vote_post" => true,

            "can_post_forum" => true,
            "can_reply_forum" => true,
            "is_forum_mod" => true,
            "is_forum_admin" => false,

            "can_ban" => true,
            "can_unban" => true,
            "can_manage_reports" => true,
            "can_edit_user" => true,
        )
    ),
    array(
        "level" => 100,
        "name" => "Administrator",
        "perms" => array(
            "can_post" => true,
            "can_comment" => true,
            "can_report" => true,
            "needs_approval" => false,

            "can_edit_wiki" => true,
            "can_edit_tag" => true,
            "can_edit_post" => true,
            "can_lock_wiki" => true,
            "can_delete_post" => true,
            "can_manage_favourites" => true,
            "can_vote_post" => true,

            "can_post_forum" => true,
            "can_reply_forum" => true,
            "is_forum_mod" => true,
            "is_forum_admin" => true,

            "can_ban" => true,
            "can_unban" => true,
            "can_manage_reports" => true,
            "can_edit_user" => true,
        )
    )
];
