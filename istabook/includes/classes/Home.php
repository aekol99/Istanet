<?php
if (!defined('MAX_IMAGE_SIZE')) {
    define('MAX_IMAGE_SIZE', 5000000);
}
if (!defined('MAX_VIDEO_SIZE')) {
    define('MAX_VIDEO_SIZE', 50000000);
}

class Home {
    private $homeModel;
    private $istanetModel;

    public function __construct(){
        $this->homeModel = new HomeDB();
        $this->istanetModel = new IstanetDB();
        $this->notificationModel = new NotificationDB();
    }

    /*** Start Home Posts ***/
    function homePosts($offset, $limit){
        date_default_timezone_set('africa/casablanca');
        $query = $this->homeModel->getAllPosts($offset, $limit);
        if ($query->rowCount() == 0) {
            echo '<div class="p-3 bg-white rounded border mt-3">No posts found</div>';
        }        
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            global $userid;
            $postid = $row['postid'];
            $postownerid = $row['userid'];
            $content = $row['content'];
            $date = $row['date'];
        
            // User Name
            $istanetOwnerInfos = $this->istanetModel->getIstanetUserInfo($postownerid);
            $ownerName = $istanetOwnerInfos['name'];
            
            if (strlen($content) > 93) {
                $content = substr($content, 0, 93) . '...';
                $content .= '<a href="" data-commentid=' . $postid . ' id="see_more">See more</a>';
            }
            // get post owner infos
            $userImage = 'storage/images/' . 'profile.png';
            $userinfo = $this->homeModel->getPostOwnerInfo($postownerid);
            if ($userinfo->rowCount() > 0) {
                $userImage = 'storage/images/' . $userinfo->fetch(PDO::FETCH_ASSOC)['image'];
            }
        
            // Post likes & comments
            $postLiked = $this->homeModel->checkPostLikedBy($userid, $postid);
            $likesNumber = $this->homeModel->getPostLikesNumber($postid);
            $commentsNumber = $this->homeModel->getPostCommentsNumber($postid);
        
            // post image/video
            $postFile = $this->homeModel->getPostFile($postid);
        
            //Time Processing
            $dateNow = strtotime(date('Y-m-d H:i:s')) - 3600;
            $dateNow = new DateTime(date('Y-m-d H:i:s', $dateNow));
            $postDate = new DateTime($date);
            $dateDiff = $dateNow->diff($postDate);
        
            if ($dateDiff->d < 7) {
                if ($dateDiff->d >= 1) {
                    $date = $dateDiff->d;
                    $date .= ' day' . ($dateDiff->d == 1 ? '' : 's'); 
                } elseif ($dateDiff->h >= 1) {
                    $date = $dateDiff->h;
                    $date .= ' hour' . ($dateDiff->h == 1 ? '' : 's');
                } elseif($dateDiff->i >= 1) {
                    $date = $dateDiff->i;
                    $date .= ' minute' . ($dateDiff->i == 1 ? '' : 's');
                } else {
                    $date = $dateDiff->s;
                    $date .= ' seconde' . ($dateDiff->s == 1 ? '' : 's');
                }
            }
            $data['date'] = $date;
            $data['postownerid'] = $postownerid;
            $data['userImage'] = $userImage;
            $data['ownerName'] = $ownerName;
            $data['userid'] = $userid;
            $data['postid'] = $postid;
            $data['content'] = $content;
            $data['postFile'] = $postFile;
            $data['likesNumber'] = $likesNumber;
            $data['postLiked'] = $postLiked;
            $data['commentsNumber'] = $commentsNumber;
            
            View::load('home/homePostView', $data);
        }

        if ($this->homeModel->getPostsCount() > ($offset + $limit)) {
            echo '<span class="view-more-posts" id="see-more">See More <i class="fa fa-refresh d-none"></i></span>';
        }
    }
    /*** End Home Posts ***/
    /*** Start Custom Post ***/
    function homeCustomPost(){
        global $userid;
        $postid = $_GET['pid'];
        date_default_timezone_set('africa/casablanca');
        $query = $this->homeModel->getCustomPost($postid);
        
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $postid = $row['postid'];
        $postownerid = $row['userid'];
        $content = $row['content'];
        $date = $row['date'];
    
        // User Name
        $istanetOwnerInfos = $this->istanetModel->getIstanetUserInfo($postownerid);
        $ownerName = $istanetOwnerInfos['name'];
        
        if (strlen($content) > 93) {
            $content = substr($content, 0, 93) . '...';
            $content .= '<a href="" data-commentid=' . $postid . ' id="see_more">See more</a>';
        }
        // get post owner infos
        $userImage = 'storage/images/' . 'profile.png';
        $userinfo = $this->homeModel->getPostOwnerInfo($postownerid);
        if ($userinfo->rowCount() > 0) {
            $userImage = 'storage/images/' . $userinfo->fetch(PDO::FETCH_ASSOC)['image'];
        }
    
        // Post likes & comments
        $postLiked = $this->homeModel->checkPostLikedBy($userid, $postid);
        $likesNumber = $this->homeModel->getPostLikesNumber($postid);
        $commentsNumber = $this->homeModel->getPostCommentsNumber($postid);
    
        // post image/video
        $postFile = $this->homeModel->getPostFile($postid);
    
        //Time Processing
        $dateNow = strtotime(date('Y-m-d H:i:s')) - 3600;
        $dateNow = new DateTime(date('Y-m-d H:i:s', $dateNow));
        $postDate = new DateTime($date);
        $dateDiff = $dateNow->diff($postDate);
    
        if ($dateDiff->d < 7) {
            if ($dateDiff->d >= 1) {
                $date = $dateDiff->d;
                $date .= ' day' . ($dateDiff->d == 1 ? '' : 's'); 
            } elseif ($dateDiff->h >= 1) {
                $date = $dateDiff->h;
                $date .= ' hour' . ($dateDiff->h == 1 ? '' : 's');
            } elseif($dateDiff->i >= 1) {
                $date = $dateDiff->i;
                $date .= ' minute' . ($dateDiff->i == 1 ? '' : 's');
            } else {
                $date = $dateDiff->s;
                $date .= ' seconde' . ($dateDiff->s == 1 ? '' : 's');
            }
        }
        $data['date'] = $date;
        $data['postownerid'] = $postownerid;
        $data['userImage'] = $userImage;
        $data['ownerName'] = $ownerName;
        $data['userid'] = $userid;
        $data['postid'] = $postid;
        $data['content'] = $content;
        $data['postFile'] = $postFile;
        $data['likesNumber'] = $likesNumber;
        $data['postLiked'] = $postLiked;
        $data['commentsNumber'] = $commentsNumber;
        
        View::load('home/homePostView', $data);

    }
    /*** End Custom Post***/
    /*** Start Insert Post To Db ***/
    function insertPost(){
        if (empty($_FILES['file']['name']) && empty($_POST['content'])) {
            echo 'there is no text or file to upload';
        }else {
            // Generate Post Id
            $postExists = true;
            while ($postExists) {
                $postid = rand();
                if ($this->homeModel->checkPostIdExists($postid)) {
                        $postExists = false;
                }
            }
            // Other Post Infos
            global $userid;
            date_default_timezone_set('africa/casablanca');
            $date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) - 3600);


            // Content Processing
            $content = $_POST['content'];

            // File Processing
            $fileGood = false;
            if (!empty($_FILES['file']['name'])) {
                $imageExtensions = ['image/png', 'image/jpg', 'image/jpeg'];
                $videoExtensions = ['video/mp4'];
                // Get File Extension
                $splitFile = explode('.', $_FILES['file']['name']);
                $fileExtention = end($splitFile);
                // Generate File Id And Name
                $fileExists = true;
                while ($fileExists) {
                    $fileid = rand();
                    $fileName = uniqid() . '.' . $fileExtention;
                    if ($this->homeModel->checkFileIdExists($fileid) && !file_exists('../storage/images/' . $fileName) && !file_exists('../storage/videos/' . $fileName)) {
                        $fileExists = false;
                    }
                }
                $fileTmpName = $_FILES['file']['tmp_name'];
                $fileType = $_FILES['file']['type'];
                $fileSize = $_FILES['file']['size'];
                $fileError = $_FILES['file']['error'];
                // Check If File Is Good
                $fileNature = '';
                if (in_array($fileType ,$imageExtensions) && $fileSize < MAX_IMAGE_SIZE && $fileError == 0) {
                    $fileGood = true;
                    $fileNature = 'image';
                }
                if (in_array($fileType ,$videoExtensions) && $fileSize < MAX_VIDEO_SIZE && $fileError == 0) {
                    $fileGood = true;
                    $fileNature = 'video';
                    
                }
            }

            if ($fileGood || !empty($content)) {
                $this->homeModel->insertPost($postid,$userid,$content,$date);
                if ($fileGood) {
                    $fileDestination = '../storage/' . $fileNature . 's/' . $fileName;
                    if ($this->homeModel->insertPostFile($fileid,$fileName,$fileNature,$postid)) {
                        move_uploaded_file($fileTmpName, $fileDestination);
                    } 
                }
                header('location: /istabook');
            }
        }   
    }
    /*** End Insert Post To Db ***/

    /*** Start From Post From Db ***/
    function deletePost(){
        global $userid;
        $postid = $_POST['postid'];
        if($this->homeModel->checkPostOwner($userid, $postid)){
            $this->homeModel->deletePost($postid);
            // delete post images and video
        }
    }
    /*** End Delete Post From Db ***/

    /*** Start Insert Post Like ***/
    function insertPostLike(){
        global $userid;
        $postid = $_POST['postid'];
        date_default_timezone_set('africa/casablanca');
        $preDate = strtotime(date('Y-m-d H:i:s')) - 3600;
        $date = date('Y:m:d H:i:s', $preDate);
        $type = 'thumbs-up';

        // Check Like Id Exists
        $likeExists = true;
        while ($likeExists) {
            $likeid = rand();
            if ($this->homeModel->checkLikeIdExists($likeid)) {
                $likeExists = false;
            }
        }

        $this->homeModel->insertPostLike($likeid, $userid, $postid, $date, $type);

        // Get post owner
        $postOwnerId = $this->homeModel->getPostOwnerId($postid)['userid'];

        if ($postOwnerId != $userid) {
            $this->notificationModel->insertNotification($postOwnerId, $userid, 'post-like', $date, 'not seen', $postid.'.'.$likeid);
        }
    }
    /*** End Insert Post Like ***/

    /*** Start Remove Post Like ***/
    function deletePostLike(){
        global $userid;
        $postid = $_POST['postid'];
        $this->homeModel->removePostLike($userid, $postid);
        echo 'removed';
    }
    /*** End Remove Post Like ***/

    /*** Start Remove Comment ***/
    function deleteComment(){
        global $userid;
        $commentid= $_POST['commentid'];
        $this->homeModel->deleteComment($commentid);
    }
    /*** End Remove Comment ***/

    /*** Start Insert Comment Like ***/
    function insertCommentLike(){
        global $userid;
        $commentid = $_POST['commentid'];
        date_default_timezone_set('africa/casablanca');
        $date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) - 3600);
        $type = 'thumbs-up';

        // Check Like Id Exists
        $likeExists = true;
        while ($likeExists) {
            $likeid = rand();
            if ($this->homeModel->checkCommentLikeIdExists($likeid)) {
                $likeExists = false;
            }
        }

        $this->homeModel->insertCommentLike($likeid,$userid, $commentid, $date, $type);

        // Get post owner
        $commentPostOwnerId = $this->homeModel->getCommentPostOwnerId($commentid);

        $commentOwner = $commentPostOwnerId['userid'];
        $postid = $commentPostOwnerId['postid'];

        if ($commentOwner != $userid) {
            $this->notificationModel->insertNotification($commentOwner, $userid, 'comment-like', $date, 'not seen', $postid.'.'.$commentid.'.'.$likeid);
        }
    }
    /*** End Insert Comment Like ***/

    /*** Start Remove Comment Like ***/
    function removeCommentLike(){
        global $userid;
        $commentid = $_POST['commentid'];
        $this->homeModel->removeCommentLike($userid ,$commentid);
    }
    /*** End Remove Comment Like ***/

    /*** Start Insert Comment ***/
    function insertComment(){
        global $userid;
        $postid = $_POST['postid'];
        $content = $_POST['content'];
        date_default_timezone_set('africa/casablanca');
        $date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) - 3600);

        // User Name
        $istanetOwnerInfos = $this->istanetModel->getIstanetUserInfo($userid);
        $ownerName = $istanetOwnerInfos['name'];

        // User Image
        $userImage = 'storage/images/profile.png';
        $userinfo = $this->homeModel->getCommentOwnerInfo($userid);
        if ($userinfo->rowCount() > 0) {
            $userImage = 'storage/images/' . $userinfo->fetch(PDO::FETCH_ASSOC)['image'];
        }

        $commentExists = true;
        while ($commentExists) {
            $commentid = rand();
            if ($this->homeModel->checkCommentIdExists($commentid)) {
                $commentExists = false;
            }
        }
        if ($this->homeModel->insertComment($commentid, $userid, $postid, $content, $date)) {
            
            
            $data['userid'] = $userid;
            $data['ownerName'] = $ownerName;
            $data['content'] = $content;
            $data['commentid'] = $commentid;
            $data['date'] = $date;
            $data['image'] = $userImage;
            View::load('home/postCommentAjaxView', $data);

            // Get post owner
            $postOwnerId = $this->homeModel->getPostOwnerId($postid)['userid'];

            if ($postOwnerId != $userid) {
                $this->notificationModel->insertNotification($postOwnerId, $userid, 'post-comment', $date, 'not seen', $postid.'.'.$commentid);
            }
        }
    }
    /*** End Insert Comment ***/

    /************************ Get ************************/

    /* Start Get Post Comments */
    function getPostComments($postid){
        global $userid;

        $query = $this->homeModel->getPostComments($postid);
        if ($query->rowCount() == 0) {
            echo '<div class="no-comment d-flex flex-column align-items-center">
            <i class="fa fa-comments-o fa-4x"></i>
            <strong>No comments yet</strong>
            <p>Be the first to comment.</p>
            </div>';
        }else {
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
               $commentOwner = $row['userid'];
               $commentId = $row['commentid'];
               $content = $row['content'];
               $date = date('Y-m-d', strtotime($row['date']));
               $image = $this->homeModel->getCommentOwnerInfo($commentOwner)->fetch(PDO::FETCH_ASSOC);
               $image = $image ? $image['image'] : 'profile.png';
               $image = 'storage/images/' . $image;
               $ownerInfos = $this->istanetModel->getIstanetUserInfo($commentOwner);
               $ownerName = $ownerInfos['name'];
               $postLiked = $this->homeModel->checkCommentLikedBy($userid, $commentId);
               $commentLikesNumber = $this->homeModel->getCommentLikesNumber($commentId);

               $data['commentOwner'] = $commentOwner;
               $data['commentId'] = $commentId;
               $data['image'] = $image;
               $data['ownerName'] = $ownerName;
               $data['content'] = $content;
               $data['date'] = $date;
               $data['postLiked'] = $postLiked;
               $data['userid'] = $userid;
               $data['commentLikesNumber'] = $commentLikesNumber;

               View::load('home/postCommentView', $data);
            }
        }
    }
    /* End Get Post Comments */

    /* Start Get People Liked A Post */
    function getPostLikedBy($postid){
        global $userid;
        $query = $this->homeModel->getPostLikes($postid);
        if ($query->rowCount() == 0) {
            echo 'No Likes for this post';
        }else {
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $likeOwnerId = $row['userid'];
                // User Name
                $istanetOwnerInfos = $this->istanetModel->getIstanetUserInfo($likeOwnerId);
                $likeOwnerName = $istanetOwnerInfos['name'];
                // User Image
                $userImage = 'storage/images/profile.png';
                $userinfo = $this->homeModel->getLikeOwnerInfo($likeOwnerId);
                if ($userinfo->rowCount() > 0) {
                    $userImage = 'storage/images/' . $userinfo->fetch(PDO::FETCH_ASSOC)['image'];
                }
                // Like Icon
                $likeIcon = 'fa-thumbs-o-up';

                $data['likeOwnerId'] = $likeOwnerId;
                $data['userImage'] = $userImage;
                $data['likeOwnerName'] = $likeOwnerName;
                $data['likeIcon'] = $likeIcon;

                View::load('home/postLikedbyView', $data);
            }
        }
    }
    /* Start Get People Liked A Post */

    /* Start Get People Liked A Post */
    function getCommentsLikedBy($commentid){
        global $userid;
        $query = $this->homeModel->getCommentLikes($commentid);
        if ($query->rowCount() == 0) {
            echo 'No Likes for this post';
        }else {
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $likeOwnerId = $row['userid'];
                $likeid = $row['likeid'];
                // User Name
                $istanetOwnerInfos = $this->istanetModel->getIstanetUserInfo($likeOwnerId);
                $likeOwnerName = $istanetOwnerInfos['name'];
                // User Image
                $userImage = 'storage/images/profile.png';
                $userinfo = $this->homeModel->getLikeOwnerInfo($likeOwnerId);
                if ($userinfo->rowCount() > 0) {
                    $userImage = 'storage/images/' . $userinfo->fetch(PDO::FETCH_ASSOC)['image'];
                }
                // Like Icon
                $likeIcon = 'fa-thumbs-o-up';

                $data['likeid'] = $likeid;
                $data['likeOwnerId'] = $likeOwnerId;
                $data['userImage'] = $userImage;
                $data['likeOwnerName'] = $likeOwnerName;
                $data['likeIcon'] = $likeIcon;

                View::load('home/commentLikedbyView', $data);
            }
        }
    }
    /* Start Get People Liked A Post */
}