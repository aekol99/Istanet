<?php
session_start();
include('../includes/config/dbconnect.php');
include('../includes/config/istanetDbConnect.php');
include('../includes/core/View.php');

include('../includes/database/IstanetDB.php');
include('../includes/database/MessageDB.php');
include('../includes/database/NotificationDB.php');

include('../includes/classes/Message.php');

$userid = $_SESSION['userid'];
$message = new Message();

if (isset($_POST['opType'])) {
    if ($_POST['opType'] == 'new-conv') {
        $message->newConversation();
    }
    if ($_POST['opType'] == 'create-new-conv') {
        $message->createNewConversation();
    }
    if ($_POST['opType'] == 'new-message') {
        $message->newMessage();
    }
    if ($_POST['opType'] == 'update-lst-update') {
        //$message->updateconlasup();
        echo "hhhhhhhhhhh";
    }
}


if (isset($_GET['opType'])) {
    if ($_GET['opType'] == 'new-conv-search') {
        $message->newConvSearch();
    }
    if ($_GET['opType'] == 'get-conv-messages') {
        $message->getConvMessages();
    }
    if ($_GET['opType'] == 'inserted-message-infos') {
        $message->getInsertedMessageInfos();
    }
    if ($_GET['opType'] == 'realtime-messages') {
        $message->realtimeMessages();
    }
}