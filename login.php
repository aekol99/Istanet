<?php
session_start();
include('config.php');

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = $con->prepare("SELECT userid FROM users WHERE username = :username AND password = :password");
    $query->bindParam("username", $username);
    $query->bindParam("password", $password);
    $query->execute();

    $row = $query->fetch(PDO::FETCH_ASSOC);

    if($query->rowCount()){
        $_SESSION['userid'] = $row['userid'];
    }

    header('location: /istanet');
}