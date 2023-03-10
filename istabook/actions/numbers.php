<?php
session_start();
include('../includes/config/dbconnect.php');
include('../includes/config/istanetDbConnect.php');
include('../includes/core/View.php');

include('../includes/database/IstanetDB.php');
include('../includes/database/NotificationDB.php');

include('../includes/classes/Notification.php');

$userid = $_SESSION['userid'];
$notification = new Notification();

if (isset($_POST['opType'])) {
    if ($_POST['opType'] == 'get-numbers') {
        echo $notification->getNotificationNumbers('');
    }
}