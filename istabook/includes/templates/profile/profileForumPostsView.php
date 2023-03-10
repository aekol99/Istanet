<!-- Start Forum Posts -->
	<!-- Start Item -->
	<div class="card mb-3">
		<div class="card-header d-flex justify-content-between bg-white">
		<div>
			<img src="<?php echo 'storage/images/' . $image; ?>" class="rounded-circle" width="25" height="25">
			<span><?php echo $name; ?></span>
		</div>
		<a href="forum.php?fpostid=<?php echo $postid; ?>">
			View More
		</a>
		</div>
		<div class="card-body">
		<blockquote class="blockquote mb-0">
			<p class="forum-post-description"><?php echo $title; ?></p>		
			<footer class="blockquote-footer d-flex">
			<?php echo $date; ?>
			<?php if ($userid == $profileid) { ?>
				<a href="" class="ml-3 deletePostCommentBtn" data-id="<?php echo $postid; ?>" data-target="forum-post"><i class="fa fa-remove mr-1"></i>Remove</a>
				<?php } ?>
			<div class="ml-auto">
				<i class="fa fa-comments"></i>
				<span><?php echo $nbcomments; ?></span>
			</div>
			</footer>
		</blockquote>
		</div>
	</div>
	<!-- End Item -->
<!-- End Forum Posts -->
