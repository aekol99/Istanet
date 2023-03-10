<!-- Start Item -->
<h4 class="mb-3 text-capitalize"><?php echo $title; ?></h4>
<div class="card mb-3">
	<div class="card-header bg-white d-flex">
		<img src="storage/images/<?php echo $image; ?>" class="rounded-circle mr-1" width="25" height="25">
		<a href="profile.php?uid=<?php echo $userid; ?>&ptab=posts"><?php echo $name;?></a>

		<?php if($userid == $postOwner){ ?>
		<a href="" class="deletePostCommentBtn ml-auto" data-id="<?php echo $postid; ?>" data-target="forum-post">
			<i class="fa fa-remove mr-1"></i>
			Remove
		</a>
    	<?php } ?>
	</div>
	
	<div class="card-body">
		<blockquote class="blockquote mb-0">
			<!-- Start Post Content -->
			<?php 
			for ($i=0; $i < count($postInfos); $i++) {
				$type = $postInfos[$i]['type'];
				$contentType = $postInfos[$i]['content_type'];
				$content = $postInfos[$i]['content'];

					if (substr($contentType, 0, 4) == 'text') {
						if ($contentType == 'text-header') {
							if ($type == 'db') {
								echo '<h5>' . $content . '</h5>';
							}else{
								echo '<h5>' . file_get_contents('storage/files/' . $content) . '</h5>';
							}
						}elseif ($contentType == 'text-paragraph') {
							if ($type == 'db') {
								echo '<p>' . nl2br($content) . '</p>';
							}else{
								echo '<p>' . nl2br(file_get_contents('storage/files/' . $content)) . '</p>';
							}
						}else{
							if ($type == 'db') {
								echo '<p>' . nl2br($content) . '</p>';
							}else{
								echo '<p>' . nl2br(file_get_contents('storage/files/' . $content)) . '</p>';
							}
						}
					}else{
						if ($type == 'db') {
							echo '<pre class="rounded"><code class="' . $contentType . '">' . htmlspecialchars($content) . '</code></pre>';
						}else {
							echo '<pre class="rounded"><code class="' . $contentType . '">' . htmlspecialchars(file_get_contents('storage/files/' . $content)) . '</code></pre>';
						}
					}
			}
			if (count($postInfos) != 0) {
				echo '<div class="separator mt-4"></div>';
			}
			?>
			<!-- End Post Content -->
			<?php if ($attachements->rowCount() != 0) { ?>
			<div class="attachements mb-4">
				<h5 class="ml-2">attachements :</h5>
				<?php while ($row = $attachements->fetch(PDO::FETCH_ASSOC)) { ?>
					<a href="<?php echo 'storage/images/'.$row['src']; ?>" class="ml-4 d-block" target="_blank">
						<i class="fa fa-image"></i>
						<span><?php echo $row['name']; ?></span>
					</a>
				<?php } ?>
			</div>
			<?php } ?>
			<footer class="blockquote-footer d-flex">
				<?php echo $date; ?>
			<div class="ml-auto">
				<i class="fa fa-commenting forum-comment-btn mr-2"></i>
			</div>
			</footer>
		</blockquote>
	</div>
</div>
<!-- End Item -->