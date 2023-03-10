<!-- Start Post -->
<div class="card mt-3">
    <div class="card-body pb-2">
    <div class="profile d-flex">
        <a href="profile.php?uid=<?php echo $postownerid; ?>&ptab=posts">
            <img src="<?php echo $userImage; ?>" width="50" height="50" class="rounded-circle">
        </a>
        <div class="ml-2 d-inline-flex flex-column">
            <a href="profile.php?uid=<?php echo $postownerid; ?>&ptab=posts" class="text-dark">
                <b class="d-block"><?php echo $ownerName; ?></b>
            </a>
            <span class="post-time"><?php echo $date; ?></span>
        </div>
        <?php 
            if ($userid == $postownerid) {
                echo '<a href="#" class="ml-auto deletePostCommentBtn" data-id="' . $postid . '" data-target="post">Delete</a>';
            }
        ?>
    </div>
    <p class="card-text mt-1" dir="auto" style="text-align:start;"><?php echo nl2br($content); ?></p>
    </div>
    <div class="image-video w-100 position-relative">
    <?php
    if ($postFile) {
        if ($postFile['type'] == 'image') {
            echo '<a href ="storage/images/'. $postFile['name'] . '" target="_blank"><img src="storage/images/'. $postFile['name'] . '" class="card-img-top"></a>';
        }else{
            echo '<video src="storage/videos/'. $postFile['name'] .'" class="w-100" controls muted></video><i class="fa fa-expand videoexpand"></i>';
        }
    }
    ?>
    </div>
    <div class="px-3 likedby my-1" data-id="<?php echo $postid; ?>">
    <?php
        if ($likesNumber > 0) {
            echo '<i class="fa fa-thumbs-o-up mr-1"></i>';
            if($postLiked) {
                if($likesNumber == 1) {
                    echo 'you';
                }elseif($likesNumber == 2){
                    echo 'you and 1 other';
                }else{
                    echo 'you and ' . ($likesNumber - 1) . ' others';
                }
            }else{
                echo $likesNumber;
            }
        }
        
    ?>
    </div>

    <div class="like-comment d-flex justify-content-around">
    <div class="like <?php echo $postLiked ? "liked" : ""; ?>" data-postid="<?php echo $postid; ?>">
        <i class="fa <?php echo $postLiked ? "fa-thumbs-up" : "fa-thumbs-o-up"; ?>"></i>
        <span><?php echo $likesNumber > 0 ? $likesNumber : ""; ?></span>
    </div>
    <div class="comments-btn" data-postid="<?php echo $postid; ?>">
        <i class="fa fa-comments"></i>
        <span><?php echo $commentsNumber > 0 ? $commentsNumber : ''; ?></span>
    </div>
    </div>

</div>
<!-- End Post -->