<?php
session_start();
include('../includes/config/dbconnect.php');
include('../includes/config/istanetDbConnect.php');
include('../includes/core/View.php');

include('../includes/database/IstanetDB.php');
include('../includes/database/HomeDB.php');
include('../includes/database/NotificationDB.php');

include('../includes/classes/Home.php');

$userid = $_SESSION['userid'];
$homeController = new Home();

if (isset($_POST['opType'])) {
    if ($_POST['opType'] == 'insert') {
        $homeController->insertPost();
    }
    if ($_POST['opType'] == 'delete') {
        $homeController->deletePost();
    }
    if ($_POST['opType'] == 'insertLike') {
        $homeController->insertPostLike();
    }
    if ($_POST['opType'] == 'removeLike') {
        $homeController->deletePostLike();
    }
    if ($_POST['opType'] == 'deletecomment') {
        $homeController->deleteComment();
    }
    if ($_POST['opType'] == 'insertCommentLike') {
        $homeController->insertCommentLike();
    }
    if ($_POST['opType'] == 'removeCommentLike') {
        $homeController->removeCommentLike();
    }
    if ($_POST['opType'] == 'insertComment') {
        $homeController->insertComment();
    }
}

if (isset($_GET['opType'])) {
    if ($_GET['opType'] == 'getComments') {
        $postid = $_GET['postid'];
        $homeController->getPostComments($postid);
    }
    if ($_GET['opType'] == 'getPostLikedBy') {
        $postid = $_GET['postid'];
        $homeController->getPostLikedBy($postid);
    }
    if ($_GET['opType'] == 'getCommentsLikedBy') {
        $commentid = $_GET['commentid'];
        $homeController->getCommentsLikedBy($commentid);
    } 
}