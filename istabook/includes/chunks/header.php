<?php 
	require_once('./includes/database/OnlineMembersDB.php');
	require_once('./includes/classes/OnlineMembers.php');
	require_once('./includes/database/NotificationDB.php');
	require_once('./includes/classes/Notification.php');
?>

<?php include('includes/functions.php'); ?>
<?php
	$onlineMembers = new OnlineMembers();
	$onlineMembers->updateLastImpression();

	$notif = new Notification(); 
	$notif->updateHomeNotifForum($page);

	$roomToIgnore = isset($_GET['roomid']) ? $_GET['roomid'] : '';
	$numbers = $notif->getNotificationNumbers($roomToIgnore);
	$numbersSplit = explode('.', $numbers);
	$homeNumber = $numbersSplit[0];
	$msgNumber = $numbersSplit[1];
	$notifNumber = $numbersSplit[2];	
	$forumNumber = $numbersSplit[3];

	$onlineMembersCount = $onlineMembers->onlineMembersCount();
?>
<!DOCTYPE html>
<html dir="ltr">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Dev 105</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/prism.css">
	<link rel="stylesheet" href="assets/css/main.css">
</head>
<body>


<header>
	<div class="top-bar py-2">
		<img src="assets/images/istantic.png" class="d-block">
		<form class="m-0 d-none d-lg-flex rounded-pill" action="search.php" method="get">
	   		<input type="text" class="form-control grow-1 border-0 rounded" name="keyword" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>">
			<input type="hidden" name="starget" value="<?php echo isset($searchTarget) ? $searchTarget : 'persons'; ?>">
	    	<button type="submit" class="my-auto mr-1 <?php echo ($page=="search") ? "text-light" : "" ;?>"><i class="fa fa-search"></i></button>
		</form>
		<a href="/istanet" class="categories-icon">
			<i class="fa fa-th"></i>
		</a>
		<a href="settings.php?stab=preview" class="<?php echo ($page=="settings") ? "setting-active-icon" : "setting-icon"; ?>">
			<i class="fa fa-cog"></i>
		</a>
	</div>
	<div class="bar-tabs">
		<div class="container">
		<div class="row text-center mx-auto" style="max-width:550px;">
			<a href="index.php" class="col <?php echo isPage("home");?>" title="Home">
				<i class="fa fa-home position-relative">
					<?php 
						echo $homeNumber > 0 ? "<span class='notification-number'>$homeNumber</span>" : "<span class='notification-number d-none'></span>";
					?>
				</i>
			</a>
			<a href="messages.php" class="col <?php echo isPage("messages");?>" title="Messages">
				<i class="fa fa-send position-relative">
					<?php 
						echo $msgNumber > 0 ? "<span class='notification-number'>$msgNumber</span>" : "<span class='notification-number d-none'></span>";
					?>
				</i>
			</a>
			<a href="notifications.php" class="col <?php echo isPage("notifications");?>" title="notifications">
				<i class="fa fa-bell position-relative">
					<?php 
						echo $notifNumber > 0 ? "<span class='notification-number'>$notifNumber</span>" : "<span class='notification-number d-none'></span>";
					?>
				</i>
			</a>
			<a href="forum.php" class="col <?php echo isPage("forum");?>" title="Forum">
				<i class="fa fa-archive position-relative">
					<?php 
						echo $forumNumber > 0 ? "<span class='notification-number'>$forumNumber</span>" : "<span class='notification-number d-none'></span>";
					?>
				</i>
			</a>
			<a href="search.php?starget=persons" class="d-block d-lg-none col <?php echo isPage("search");?>" title="Search">
				<i class="fa fa-search"></i>
			</a>
			<a href="profile.php?ptab=posts" class="col <?php echo isPage("profile");?>" title="profile">
				<i class="fa fa-user" ></i>
			</a>
		</div>
	</div>
	</div>
	<span class="bar-tabs-scrollfix w-100 d-none"></span>
</header>