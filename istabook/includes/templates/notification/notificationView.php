<!-- Start Notification -->
<a href="<?php echo $url; ?>" class="media text-muted py-2 px-2 <?php echo $lastRow ? '': 'border-bottom border-gray'; ?>">
    <img class="bd-placeholder-img mr-2 rounded-circle" src="<?php echo 'storage/images/' . $whoimage; ?>" width="40" height="40">
    <div class="ml-2">
        <p class="mb-0">
        <?php
            // post like
            if ($type == 'post-like') {
                echo "<b>".$whoname."</b>"." liked your post.";
            }
            //comment like
            if ($type == 'comment-like') {
                echo "<b>".$whoname."</b>"." liked your comment.";
            }
            // post-comment and forum-post-comment
            if ($type == 'post-comment' || $type == 'forum-post-comment') {
                echo "<b>".$whoname."</b>"." commented in your post.";
            }
            if ($type == 'conv-added-to') {
                echo "<b>".$whoname."</b>"." added you to a group conversation.";
            }
        ?>
        </p>
        <p class="mb-0"><?php echo $date; ?></p>
    </div>
</a>
<!-- End Notification -->