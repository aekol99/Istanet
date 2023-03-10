<!-- Start Person -->
<a href="profile.php?uid=<?php echo $likeOwnerId; ?>&ptab=posts" class="person d-flex py-2">
    <img src="<?php echo $userImage; ?>" width="40" height="40" class="rounded-circle">
    <div class="ml-2 d-flex flex-column">
        <span class="text-capitalize"><?php echo $likeOwnerName; ?></span>		
        <i class="fa <?php echo $likeIcon;?>"></i>
    </div>        
</a>
<!-- End Person -->