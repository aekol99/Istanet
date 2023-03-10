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

	include('./includes/database/ForumDB.php');
	include('./includes/classes/Forum.php');
?>

<?php $page="forum"; ?>

<!--Start Header-->
<?php include('includes/chunks/header.php'); ?>
<!--End Header-->

<!-- Start Forum -->
<div class="forum">
	<div class="container">
		<div class="row justify-content-center">
			<!-- Start Cols -->
			<?php $forum = new Forum(); ?>
			<?php if (isset($_GET['fpostid'])) { ?>
				<div class="col-12 col-lg-8 mt-3">
				<span class="online-members-btn not-active ml-auto d-lg-none">Online (<?php echo $onlineMembersCount; ?>)</span>
				<div class="clearfix"></div>
					<?php 
						$forum->getForumPostInfos();
						$commentsCount = $forum->ForumPostCommentsCount($_GET['fpostid']);
						
						if ($commentsCount != 0) {
							echo "<h5 class='mt-5 mb-3'>$commentsCount Answers</h5>";
						}

						 $forum->getForumCommentsInfos();
					?>
				</div>
			<?php } ?>
			<?php if(!isset($_GET['fpostid'])){ ?>
				<div class="col-12 col-lg-3 mt-3">
                    <div class="new-post p-3 rounded">
                        <span class="online-members-btn not-active ml-auto d-lg-none">Online (<?php echo $onlineMembersCount; ?>)</span>
                        <b class="d-block mb-2">New forum post:</b>
                        <!-- Start Button trigger modal -->
                        <button type="button" class="btn new-forum-post-btn w-100">
                        Create
                        </button>
                        <!-- End Button trigger modal -->
                    </div>
                </div>
            	<div class="col-12 col-lg-5 mt-3">
				<?php $forum->getForumPosts(0, 10); ?>
				</div>
			<?php } ?>
			<!-- End Cols -->
			<div class="col-lg-3 d-none d-lg-block">
				<?php include("includes/chunks/online-members.php") ?>
			</div>
		</div>
	</div>
	<?php include('includes/modals/forum.post.php');?>
	<?php include('includes/modals/forum.comment.php');?>
</div>
<!-- End Forum -->

<!--Start Footer-->
<?php include('includes/chunks/footer.php'); ?>
<!--End Footer-->