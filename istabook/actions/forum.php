<?php
session_start();
include('../includes/config/dbconnect.php');
include('../includes/config/istanetDbConnect.php');
include('../includes/core/View.php');

include('../includes/database/IstanetDB.php');
include('../includes/database/ForumDB.php');
include('../includes/database/NotificationDB.php');

include('../includes/classes/Forum.php');

$userid = $_SESSION['userid'];
$forum = new Forum();

if (isset($_POST['opType'])) {
    if ($_POST['opType'] == 'forum-post-insert') {
        $forum->insertForumPost();
    }
    if ($_POST['opType'] == 'deleteforumpost') {
        $forum->deleteForumPost();
    }
    if ($_POST['opType'] == 'forum-comment-insert') {
        $forum->insertForumComment();
    }
    if ($_POST['opType'] == 'deleteforumcomment') {
        $forum->deleteForumComment();
    }
}