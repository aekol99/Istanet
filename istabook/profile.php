<?php
	session_start();
	if (!isset($_SESSION['userid'])) {
		header('location: /istanet');
	}

	$userid = $_SESSION['userid'];

	if (isset($_GET['uid'])) {
		$profileid = $_GET['uid'];
	}else {
		$profileid = $userid;
	}
	
	include('./includes/config/dbconnect.php');
	include('./includes/config/istanetDbConnect.php');
	include('./includes/database/IstanetDB.php');
	include('./includes/core/View.php');

	include('./includes/database/ProfileDB.php');
	include('./includes/classes/Profile.php');
?>

<?php $page="profile"; ?>

<!--Start Header-->
<?php include('includes/chunks/header.php'); ?>
<!--End Header-->

<?php
	if (isset($_GET['ptab']) && !empty($_GET['ptab'])) {
		$profileTab = $_GET['ptab'];
	}
?>

<!--Start Prifile -->
	<div class="profile-content">
	<!-- Start Nav Content -->
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-lg-3 mt-3">
				<!-- Start Profile Info -->
				<?php 
					$profile = new Profile();
					$profile->getProfileInfos();
				?>
				<!-- End Profile Info -->

				<!-- Start Profile Tabs -->
				<?php include('includes/chunks/profile.tabs.php') ?>
				<!-- End Profile Tabs -->
			</div>
			<div class="col-12 col-lg-5 mt-3">
				<?php
					// Get Profile Specific Tab
					if (isset($profileTab)) {
						if ($profileTab == "posts") {
							$profile->getProfilePosts(0, 10);
						} else if ($profileTab == "forum-posts") {
							$profile->getForumPosts(0, 10);
						} else {
							echo "<h3 class=\"text-danger\">Error</h3>";
						}
					} else {
						echo "<h3 class=\"text-danger\">Error</h3>";
					}
				?>
			</div>
			<div class="col-3 d-none d-lg-block">
				<?php include("includes/chunks/online-members.php") ?>
			</div>
		</div>
	</div>
	<!-- Start Nav Content -->
</div>
<!--End Profile -->

<!--Start Footer-->
<?php include('includes/chunks/footer.php'); ?>
<!--End Footer-->