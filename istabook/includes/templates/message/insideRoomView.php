<!-- Start Message -->
<div class="media flex-column text-muted px-3 py-2 bg-white mb-2 border <?php echo $mine; ?>">
	<div class="media-body">
		<a href="profile.php?uid=<?php echo $id; ?>&ptab=posts" class="d-block mb-2"><?php echo $name; ?></a>
		<p class="message-text d-block mb-0"><?php echo $text; ?></p>
	</div>

<?php if (!empty($images)) { ?>
	<div class="message-images d-flex flex-wrap mt-2">
		<?php 
		$i = 1;
		while ($row = $images->fetch(PDO::FETCH_ASSOC)) { 
			if ($i < 4) { ?>
				<div class="message-image m-1">
					<img class="rounded" src="storage/images/<?php echo $row['src']; ?>" width="100">
				</div>
			<?php }elseif ($i == 4) { ?>
				<div class="message-image m-1 position-relative">
					<img class="rounded" src="storage/images/<?php echo $row['src']; ?>" width="100">
					<?php if($images->rowCount() > 4)
					echo '<span class="more-images rounded">' . ($images->rowCount() - 3) . ' Images</span>';
					?>
				</div>
			<?php }else { ?>
				<div class="message-image m-1 d-none">
					<img class="rounded" src="storage/images/<?php echo $row['src']; ?>" width="100">
				</div>
			<?php } ?>
		<?php $i++; } ?>
	</div>
<?php } ?>

</div>
<!-- End Message -->
