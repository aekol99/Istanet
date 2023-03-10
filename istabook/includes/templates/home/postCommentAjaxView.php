<div class="media px-2 mb-3">
    <a href="profile.php?uid=<?php echo $ownerName; ?>&ptab=posts" class="mr-3">
        <img class="bd-placeholder-img rounded-circle" src="<?php echo $image;?>" width="40" height="40">
    </a>
    <div class="media-body">
        <div class="d-flex justify-content-between">
            <a href="profile.php?uid=<?php echo $userid; ?>&ptab=posts" class="text-muted">
            <strong class="d-block text-gray-dark text-capitalize"><?php echo $ownerName;?></strong>
            </a>
        </div>
        <p class="m-0"><?php echo $content; ?></p>
        <span><?php echo date('Y-m-d', strtotime($date)); ?></span>
        <a href="#" class="ml-2 like-comment-btn" data-id="<?php echo $commentid; ?>">
            Like
        </a>
        
        <a href="#" class="remove-comment ml-2" data-id="<?php echo $commentid; ?>" data-target="comment">
            Remove
        </a>

        <div class="comment-likedby d-inline ml-2">
        </div>
    </div>
</div>