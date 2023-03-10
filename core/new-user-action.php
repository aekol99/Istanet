<?php
include('../config.php');

echo "<pre>";
print_r($_POST);
echo "</pre>";

$userid = $_POST['userid'];
$name = $_POST['name'];
$username = $_POST['username'];
$filliere = $_POST['filiere'];
$groupe = $_POST['groupe'];
$password = $_POST['password'];


$query = $con->prepare("INSERT INTO users(userid, name, username, filliere, groupe, password) VALUES(:userid, :name, :username, :filliere, :groupe, :password)");
$query->bindParam(":userid", $userid);
$query->bindParam(":name", $name);
$query->bindParam(":username", $username);
$query->bindParam(":filliere", $filliere);
$query->bindParam(":groupe", $groupe);
$query->bindParam(":password", $password);

if ($query->execute()) {
    // Get The date
    date_default_timezone_set('africa/casablanca');
    $preDate = strtotime(date('Y-m-d H:i:s')) - 3600;
    $date = date('Y:m:d H:i:s', $preDate);

    // Home Update
    $query = $istabookCon->prepare("INSERT INTO home_update(userid, last_update) VALUES(:userid, :last_update)");
    $query->bindParam(":userid", $userid);
    $query->bindParam(":last_update", $date);
    $query->execute();

    // Message Update
    $query = $istabookCon->prepare("INSERT INTO messages_update(userid, last_update) VALUES(:userid, :last_update)");
    $query->bindParam(":userid", $userid);
    $query->bindParam(":last_update", $date);
    $query->execute();

    // Notification Update
    $query = $istabookCon->prepare("INSERT INTO notification_update(userid, last_update) VALUES(:userid, :last_update)");
    $query->bindParam(":userid", $userid);
    $query->bindParam(":last_update", $date);
    $query->execute();

    // Forum Update
    $query = $istabookCon->prepare("INSERT INTO forum_update(userid, last_update) VALUES(:userid, :last_update)");
    $query->bindParam(":userid", $userid);
    $query->bindParam(":last_update", $date);
    $query->execute();

    // Online Members Update
    $query = $istabookCon->prepare("INSERT INTO online_members(userid, last_update) VALUES(:userid, :last_update)");
    $query->bindParam(":userid", $userid);
    $query->bindParam(":last_update", $date);
    $query->execute();

    // Insert User Infos
    $image = 'profile.png';
    $query = $istabookCon->prepare("INSERT INTO userinfo(userid, image) VALUES(:userid, :image)");
    $query->bindParam(":userid", $userid);
    $query->bindParam(":image", $image);
    $query->execute();
}

header('location: /istanet');