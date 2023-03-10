<?php
session_start();
include('../includes/config/dbconnect.php');
include('../includes/config/istanetDbConnect.php');
include('../includes/core/View.php');

include('../includes/database/IstanetDB.php');
include('../includes/database/HomeDB.php');
include('../includes/database/NotificationDB.php');
include('../includes/database/MessageDB.php');
include('../includes/database/ProfileDB.php');
include('../includes/database/ForumDB.php');
include('../includes/database/SearchDB.php');

include('../includes/classes/Home.php');
include('../includes/classes/Message.php');
include('../includes/classes/Notification.php');
include('../includes/classes/Profile.php');
include('../includes/classes/Forum.php');
include('../includes/classes/Search.php');
include('../includes/classes/SeeMore.php');

$userid = $_SESSION['userid'];
$profileid = $userid;

$seeMore = new SeeMore();

if (isset($_POST['dataTarget'])) {
    if ($_POST['dataTarget'] == 'home') {
        $seeMore->moreHomePosts();
    }
    if ($_POST['dataTarget'] == 'notifications') {
        $seeMore->moreNotifications();
    }
    if ($_POST['dataTarget'] == 'forum') {
        $seeMore->moreForumPosts();
    }
    if ($_POST['dataTarget'] == 'profile') {
        $seeMore->profileMorePosts();
    }
    if ($_POST['dataTarget'] == 'messages') {
        $seeMore->moreMessages();
    }
    if ($_POST['dataTarget'] == 'search') {
        $seeMore->moreSearch();
    }
}