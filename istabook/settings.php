<?php
	session_start();
	if (!isset($_SESSION['userid'])) {
		header('location: /istanet');
	}else{
		$userid = $_SESSION['userid'];
	}
	include('./includes/config/dbconnect.php');
	include('./includes/config/istanetDbConnect.php');
	include('./includes/database/IstanetDB.php');
	include('./includes/core/View.php');

	include('./includes/database/SettingDB.php');
	include('./includes/classes/Setting.php');
?>

<?php $page="settings"; ?>

<!--Start Header-->
<?php include('includes/chunks/header.php'); ?>
<!--End Header-->

<?php
	if (isset($_GET['stab']) && !empty($_GET['stab'])) {
		$settingTab = $_GET['stab'];
	}
?>

<div class="container mt-3">
	<div class="row">
		<div class="col-12 col-lg-4 mb-3">
			<!-- Start Settings Tabs -->
			<?php include('includes/chunks/setting.tabs.php') ?>
			<!-- End Settings Tabs -->
		</div>
		<div class="col-12 col-lg-8">
			<div class="card p-3 settings">
				<?php
					if ($settingTab) {
						$setting = new Setting();
						if ($settingTab == "preview") { 
							$setting->profilePreview($userid);
						}elseif ($settingTab == "image"){
							include('includes/chunks/image.setting.php');
						}elseif ($settingTab == "smedia"){
							$setting->socialMediaInputs();
						}elseif ($settingTab == "password"){
							include('includes/chunks/password.setting.php');
						}
					}else {
						echo "<h3 class=\"text-danger\">Error</h3>";
					}
				?>
			</div>
		</div>
	</div>
</div>

<!--Start Footer-->
<?php include('includes/chunks/footer.php'); ?>
<!--End Footer-->