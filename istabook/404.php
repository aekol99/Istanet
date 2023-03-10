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
?>

<!--Start Header-->
<?php include('includes/chuncks/header.php'); ?>
<!--End Header-->

<!--Start Posts-->
<div class="posts">
	<div class="container p-4">
		<h3 class="text-danger text-center">Error 404</h3>
	</div>
</div>
<!--End Posts-->

<!--Start New Post Modal-->
<?php include('includes/modals/new.post.php'); ?>
<!--End New Post Modal-->

<!--Start Footer-->
<?php include('includes/chuncks/footer.php'); ?>
<!--End Footer-->