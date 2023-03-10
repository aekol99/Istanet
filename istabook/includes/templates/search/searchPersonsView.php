<!-- Start Item -->
<div class="result-item d-flex border-bottom align-items-center">
	<a href="profile.php?uid=<?php echo $userid; ?>&ptab=posts">
		<img src="<?php echo 'storage/images/' . $image;?>" width="50" class="rounded-circle">	
	</a>
	<div class="d-flex flex-column flex-grow-1 ml-2">
		<a href="profile.php?uid=<?php echo $userid; ?>&ptab=posts"><span><?php echo $name; ?></span></a>
		<span><?php echo $filliere . ' ' . $groupe; ?></span>
	</div>
	<!-- <a href="messages.php?roomid=1" class="mr-2 message-btn">
		<i class="fa fa-send"></i>
	</a> -->
</div>
<!-- End Item -->