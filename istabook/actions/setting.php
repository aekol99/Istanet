<?php
session_start();
include('../includes/config/dbconnect.php');
include('../includes/config/istanetDbConnect.php');
include('../includes/core/View.php');

include('../includes/database/IstanetDB.php');
include('../includes/database/SettingDB.php');

include('../includes/classes/Setting.php');

$userid = $_SESSION['userid'];
$setting = new Setting();

if (isset($_POST['opType'])) {
    if ($_POST['opType'] == 'cimage') {
        $setting->changeProfileImage();
    }
    if ($_POST['opType'] == 'smedia') {
        $setting->changeSocialMedia();
    }
    if ($_POST['opType'] == 'changePassword') {
        $setting->changePassword();
    }
}
