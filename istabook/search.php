<?php
	session_start();
	if (!isset($_SESSION['userid'])) {
		header('location: /istanet');
	}
	include('./includes/config/dbconnect.php');
	include('./includes/config/istanetDbConnect.php');
	include('./includes/database/IstanetDB.php');
	include('./includes/core/View.php');

	include('./includes/database/SearchDB.php');
	include('./includes/classes/Search.php');
?>

<?php $page="search"; ?>

<?php
	if (isset($_GET['starget']) && !empty($_GET['starget'])) {
		$searchTarget = $_GET['starget'];
	}
	$userid = $_SESSION['userid'];

	$numbPersons = "none";
	$numbPosts = "none";
	$numbForumPosts = "none";

	if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
		$keyword = $_GET['keyword'];
		$searchModel = new SearchDB();
		$istanetModel = new IstanetDB();
		$numbPersons = $istanetModel->serachUsers($keyword)->rowCount();
		$numbPosts = $searchModel->getAllPostsSearchCount($keyword);
		$numbForumPosts = $searchModel->getForumPostsSearchCount($keyword);
	}
?>

<!--Start Header-->
<?php include('includes/chunks/header.php'); ?>
<!--End Header-->


<!--Start Search-->
<div class="search">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-lg-3 mt-3">
				<span class="online-members-btn not-active ml-auto d-lg-none">Online (<?php echo $onlineMembersCount; ?>)</span>
				<form class="m-0" action="search.php" method="get">
					<b class="d-block mb-1">Search :</b>
					<div class="form-group d-flex bg-white border rounded d-lg-none">
						<input type="text" class="form-control grow-1 border-0 rounded" name="keyword" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>">
						<input type="hidden" name="starget" value="<?php echo isset($searchTarget) ? $searchTarget : 'posts'; ?>">
						<button type="submit" class="my-auto mr-1"><i class="fa fa-search"></i></button>
					</div>
				</form>
				<!-- Start Tabs -->
				<?php include('includes/chunks/search.tabs.php') ?>
				<!-- End Tabs -->
			</div>
			<div class="col-12 col-lg-5 mt-3 order-2 order-lg-1  mb-3">
				<!-- Start Search Results -->
				<div class="results">
				<?php
					$search = new Search();
					if (isset($searchTarget)) {
						if ($searchTarget == "persons") {
							echo '<div class="card">';
							$search->searchPersons();
							echo '</div>';
						}elseif ($searchTarget == "posts"){
							$search->searchPosts(0, 10);
						}elseif ($searchTarget == "forum-posts"){
							//include('includes/views/search.forum.posts.view.php');
							$search->searchForumPosts(0, 10);
						}
					}else {
						echo "<h3 class=\"text-danger\">Error</h3>";
					}
				?>
				</div>
			</div>
			<div class="col-12 col-lg-3 order-1 order-lg-2 d-none d-lg-block">
				<?php include("includes/chunks/online-members.php") ?>
			</div>
		</div>
	</div>
</div>
<!--End Search-->

<!--Start Footer-->
<?php include('includes/chunks/footer.php'); ?>
<!--End Footer-->