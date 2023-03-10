<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header('location: /istanet');
}else {
    if ($_SESSION['userid'] != '1') {
        header('location: /istanet');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/css/font-awesome.min.css">
</head>
<body>
<section class="container w-50 mt-4">
    <h2 class="text-center"><i class="fa fa-user"></i> New user</h2>
    <form action="new-user-action.php" method="post">
        <div class="form-group mb-3">
            <label>User id :</label>
            <input class="form-control" name="userid">
        </div>
        <div class="form-group mb-3">
            <label>Name :</label>
            <input class="form-control" name="name">
        </div>
        <div class="form-group mb-3">
            <label>Username :</label>
            <input class="form-control" name="username">
        </div>
        <div class="form-group mb-3">
            <label>Filiere :</label>
            <select name="filiere" class="form-control">
                <option value="dev">Développement digitale</option>
            </select>
        </div>
        <div class="form-group mb-3">
            <label>Groupe :</label>
            <select name="groupe" class="form-control">
                <option value="205">Dev 205</option>
            </select>
        </div>
        <div class="form-group mb-3">
            <label>Password :</label>
            <input type="password" class="form-control" name="password">
        </div>
        <button type="submit" class="btn btn-secondary" name="submit">Create</button>
    </form>
</section>
</body>
</html>