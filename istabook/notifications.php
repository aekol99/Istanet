<?php
	session_start();
	if (!isset($_SESSION['userid'])) {
		header('location: /istanet');
	}
	$userid = $_SESSION['userid'];
	include('./includes/config/dbconnect.php');
	include('./includes/config/istanetDbConnect.php');
	include('./includes/database/IstanetDB.php');
	include('./includes/core/View.php');
?>

<?php $page="notifications"; ?>

<!--Start Header-->
<?php include('includes/chunks/header.php'); ?>
<!--End Header-->

<!--Start Notifications -->
<div class="notifications">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-lg-8 pt-3">
				<div class="p-3 bg-white rounded border">
					<b class="border-bottom border-gray d-block mb-2 pb-2">Notifications :
						<span class="online-members-btn not-active ml-auto d-lg-none">Online (<?php echo $onlineMembersCount; ?>)</span>
					</b>
					<?php
						$notification = new Notification();
						$notification->getNotifications(0, 10);
					?>
				</div>
			</div>
			<div class="col-lg-3 d-none d-lg-block">
			<?php include("includes/chunks/online-members.php") ?>
			</div>
		</div>
	</div>
</div>
<!--End Notifications -->

<!--Start Footer-->
<?php include('includes/chunks/footer.php'); ?>
<!--End Footer-->