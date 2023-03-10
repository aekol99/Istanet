<?php
session_start();
include('../includes/config/dbconnect.php');
include('../includes/config/istanetDbConnect.php');
include('../includes/core/View.php');

include('../includes/database/IstanetDB.php');
include('../includes/database/OnlineMembersDB.php');

include('../includes/classes/OnlineMembers.php');

$userid = $_SESSION['userid'];
$onlineMembers = new OnlineMembers();

if (isset($_POST['opType'])) {
    if ($_POST['opType'] == 'update-last-impression') {
        $onlineMembers->updateLastImpression();
    }
    if ($_POST['opType'] == 'update-online-members') {
        $onlineMembers->updateOnlineMembers();
    }
}