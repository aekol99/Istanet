<?php 
	session_start();
	if (!isset($_SESSION['userid'])) {
		header('location: /istanet');
	}

	$page = "home";
	if (isset($_GET['custom']) && $_GET['custom'] == "true"){
		$custom = true;
	}else {
		$custom = false;
	}
	$userid = $_SESSION['userid'];

	include('./includes/config/dbconnect.php');
	require_once('./includes/config/dbconnect.php');
	include('./includes/config/istanetDbConnect.php');
	include('./includes/database/IstanetDB.php');
	include('./includes/core/View.php');

	include('./includes/database/HomeDB.php');
	include('./includes/classes/Home.php');
?>

<!--Start Header-->
<?php include('includes/chunks/header.php'); ?>
<!--End Header-->

<!--Start Posts-->
<div class="posts">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 d-lg-block col-lg-3">
				<?php include('includes/chunks/create.new.post.php') ?>
			</div>
			<div class="col-12 col-lg-5">
				<!-- Start Posts/Custom Post -->
				<?php 
				$home = new Home();
					if($custom){
						$home->homeCustomPost();
					}else{
						$home->homePosts(0, 10);
					}
				?>
				<!-- End Posts/Custom Post -->
			</div>
			<div class="col-12 col-lg-3 d-none d-lg-block">
				<?php include("includes/chunks/online-members.php") ?>
			</div>
		</div>
	</div>
</div>
<!--End Posts-->

<!--Start New Post Modal-->
<?php include('includes/modals/new.post.php'); ?>
<!--End New Post Modal-->

<!--Start Footer-->
<?php include('includes/chunks/footer.php'); ?>
<!--End Footer-->