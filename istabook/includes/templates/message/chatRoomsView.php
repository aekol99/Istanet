<!-- Start Chat Room -->
<a href="messages.php?roomid=<?php echo $key; ?>" class="media text-muted pt-3 px-2">
	<img class="bd-placeholder-img mr-2 rounded-circle" src="storage/images/<?php echo $image; ?>" width="40" height="40">
	<p class="media-body pb-2 mb-0">
		<strong class="d-block text-gray-dark"><?php echo $name; ?></strong>
	<?php echo $unread > 0 ? "<span class='unread-messages'>$unread</span>": '';?>
	<?php echo empty($msg) ? '<i class="fa fa-image"></i> images' : $msg; ?>
	</p>
</a>
<!-- End Chat Room -->