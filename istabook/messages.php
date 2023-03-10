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

	include('./includes/database/MessageDB.php');
	include('./includes/classes/Message.php');
?>

<?php $page="messages"; ?>

<!--Start Header-->
<?php include('includes/chunks/header.php'); ?>
<!--End Header-->

<!-- Start Messages -->
<div class="chat-rooms inside-chat-room">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-lg-3 <?php echo isset($_GET['roomid']) ? "d-none d-lg-block" : "";?>">
				<?php include('includes/chunks/create.conversation.group.php'); ?>
			</div>
			<div class="col-12 col-lg-5 pt-3 messages-container">
			<?php $message = new Message(); ?>
			<?php if (!isset($_GET['roomid'])) { ?>
				<div class="p-3 bg-white rounded border">
					<b class="border-bottom border-gray d-block pb-2">
						Conversations :
					</b>
					<?php $message->getAllConversations(); ?>
				</div>
			<?php } ?>

			<?php if(isset($_GET['roomid'])){ 
				$convName = $message->getConvName($_GET['roomid']);
				?>
				<div class="d-flex justify-content-between">
					<b class="d-block mb-2"><?php echo $convName; ?></b>
					<span class="online-members-btn not-active d-block d-lg-none">Online (<?php echo $onlineMembersCount; ?>)</span>
				</div>
				<?php
				$message->getConvMessages();
				?>
				<form class="bg-white d-flex rounded-pill border p-2 mt-4 send-msg-form" enctype="multipart/form-data">
					<input type="text" class="form-control w-auto flex-grow-1 rounded-pill border-0 form-text-msg-input" placeholder="please type some message here.." name="msg-text">
					<button type="button" class="btn upload-image-btn px-2">
						<i class="fa fa-image"></i>
					</button>
					<input type="file" name="msg-images[]" id="images-input" hidden multiple>
					<input type="hidden" name="roomid" value="<?php echo $_GET['roomid']; ?>">
					<input type="hidden" name="opType" value="new-message">
					<button type="button" class="btn send-conv-msg-btn">
						<i class="fa fa-send"></i>
					</button>
				</form>
			<?php } ?>
			</div>
			<div class="col-lg-3 d-none d-lg-block">
				<?php include("includes/chunks/online-members.php") ?>
			</div>
		</div>
	</div>
	<?php include('includes/modals/view.images.php'); ?>
</div>
<!-- End Messages -->


<!--Start New Post Modal-->
<?php include('includes/modals/create.conversation.php'); ?>
<!--End New Post Modal-->

<!--Start Footer-->
<?php include('includes/chunks/footer.php'); ?>
<!--End Footer-->