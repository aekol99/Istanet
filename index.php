<?php
session_start();
include('config.php');
if (isset($_SESSION['userid'])) {
    $loggedIn = true;
    $userid = $_SESSION['userid'];
    $query = $con->prepare("SELECT name FROM users WHERE userid = :userid");
    $query->bindParam("userid", $userid);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
}else {
    $loggedIn = false;
}
?>
<!DOCTYPE html>
<html dir="ltr">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Istanet</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
    <?php 
    if (isset($_SESSION['userid'])) {
        if ($_SESSION['userid'] == '1') {
            echo '<a class="d-block ps-4 pt-3" href="core/new-user.php">New user</a>';
        }
        echo '<a class="d-block ps-4 pt-3" href="core/logout.php">Logout</a>';
    }
    ?>
    <article class="container">
        <h1 class="text-center">
            <?php
                if ($loggedIn) {
                    $name = explode(' ', $row['name']);
                    echo "Hi, " . end($name);
                    
                }else{
                    echo "<h1 class=\"text-center\">";
                    echo "<i class='fa fa-google'></i> ";
                    echo "<strong>Istanet</strong>";
                }
            ?>
        </h1>
        <?php
            if($loggedIn){
        ?>
        <!-- Start Sites -->
        <div class="row sites  text-center">
            <a href="/istanet/istabook" class="col-3 d-flex flex-column align-items-center text-decoration-none" title="Khoual Alaaeddine">
                <img src="assets/icons/icon1.png">
                <small class="text-secondary">istabook</small>
            </a>
            <div class="col-3 d-flex flex-column align-items-center text-decoration-none">
                <img src="assets/icons/icon2.png">
                <small class="text-secondary">name</small>
            </div>
            <div class="col-3 d-flex flex-column align-items-center text-decoration-none">
                <img src="assets/icons/icon2.png">
                <small class="text-secondary">name</small>
            </div>
            <div class="col-3 d-flex flex-column align-items-center text-decoration-none">
                <img src="assets/icons/icon2.png">
                <small class="text-secondary">name</small>
            </div>
            <div class="col-3 d-flex flex-column align-items-center text-decoration-none">
                <img src="assets/icons/icon2.png">
                <small class="text-secondary">name</small>
            </div>
            <div class="col-3 d-flex flex-column align-items-center text-decoration-none">
                <img src="assets/icons/icon2.png">
                <small class="text-secondary">name</small>
            </div>
            <div class="col-3 d-flex flex-column align-items-center text-decoration-none">
                <img src="assets/icons/icon2.png">
                <small class="text-secondary">name</small>
            </div>
            
            
            <div class="col-3">
                <!-- Button trigger modal -->
                <button type="button" class="border-0 bg-transparent" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <img src="assets/icons/threedots.png" alt="">
                </button>
            </div>
        </div>
        <!-- End Sites -->
        <?php
        }else{
        ?>
        <!-- Start Login -->
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="exampleFormControlInput10">Username :</label>
                <input class="form-control" id="exampleFormControlInput0" name="username">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Password :</label>
                <input type="password" class="form-control" id="exampleFormControlInput1" name="password">
            </div>
            <button type="submit" class="btn btn-secondary" name="submit">Login</button>
        </form>
        <!-- End Login -->
        <?php } ?>
</article>

<!-- Vertically centered modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
    </div>
  </div>
</div>

<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>