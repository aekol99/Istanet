<footer class="mt-3">
<?php if ($page != 'profile' && $page != 'setting') {
	/** Start Mobile Online Members Modal **/
	include('includes/modals/mobile.online.members.php');
	/** End Mobile Online Members Modal **/
} 
?>

<?php 
	if (($page == 'home') || ($page == 'profile' && $profileTab == 'posts') || ($page == 'search' && $searchTarget == 'posts')) {
		/** Start Liked By Modal **/
		include('includes/modals/liked.by.php');
		/** End Liked By Modal **/
		/** Start Post Comments Modal **/
		include('includes/modals/post.comments.php');
		/** End Post Comments Modal **/
	}
?>

<?php 
	if (($page == 'home') || ($page == 'profile') || ($page == 'search') || ($page == 'forum')) {
		/** Start Delete Post Comment Modal **/
		include('includes/modals/delete.post.comment.php');
		/** End Delete Posts Comments Modal **/
	}
?>

<?php
	if (($page == 'search' && $searchTarget == 'persons') || ($page == 'profile')) {
		/** Start First Message Modal **/
	include('includes/modals/first.message.php');
	/** End First Message Modal **/
	}
?>

<!--Start Other Online Members Modal-->
<?php include('includes/modals/other.online.members.php'); ?>
<!--End Other Online Members Modal-->
<!-- Start Online Members First Message Modal -->
<?php include('includes/modals/online.members.first.message.php'); ?>
<!-- End Online Members First Message Modal -->
</footer>
<script type="text/javascript">
	var PAGE = "<?php echo $page; ?>";
	var ROOMID = "<?php echo isset($_GET['roomid']) ? $_GET['roomid'] : ''; ?>";
	
	var PROFILE_TARGET = "<?php echo ($page == 'profile' && isset($_GET['ptab'])) ? $_GET['ptab'] : ''; ?>";
	var PROFILEID = "<?php echo ($page == 'profile' && isset($_GET['uid'])) ? $_GET['uid'] : ''; ?>";

	var SEARCH_KEYWORD = "<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>";
	var SEARCH_TARGET = "<?php echo isset($_GET['starget']) ? $_GET['starget'] : ''; ?>";
</script>
<script src="assets/js/jquery-3.4.1.min.js" type="text/javascript"></script>
	<script src="assets/js/popper.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="assets/js/prism.js" type="text/javascript"></script>
	<script src="assets/js/main.js" type="text/javascript"></script>
</body>
</html>
