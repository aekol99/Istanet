<?php
if (!defined('MAX_IMAGE_SIZE')) {
    define('MAX_IMAGE_SIZE', 5000000);
}
class Forum {
    private $forumModel;
    private $istanetModel;

    public function __construct(){
        $this->forumModel = new ForumDB();
        $this->istanetModel = new IstanetDB();
        $this->notificationModel = new NotificationDB();
    }

    /*** Start Get Forum Posts ***/
    function getForumPosts($offset, $limit){
        global $userid;
        $forumPosts = $this->forumModel->getForumPosts($offset, $limit);
        $oMbDisplayed = false;
        if ($forumPosts->rowCount() == 0) {
            echo '<div class="p-3 bg-white rounded border">No forum posts found</div>';
        }
        while ($row = $forumPosts->fetch(PDO::FETCH_ASSOC)) {
            $postTitle = $row['title'];
            $postid = $row['postid'];
            $date = $row['date'];
            $ownerid = $row['userid'];

            // get comments count
            $postCommentsCount = $this->forumModel->getCommentsCount($postid);
            // get user image
            $postOwnerImage = $this->forumModel->getOwnerImage($ownerid);
            // get user name
            $postOwnerName = $this->istanetModel->getIstanetUserInfo($ownerid)['name'];

            
            $data['postid'] = $postid;
            $data['title'] = $postTitle;
            $data['date'] = $date;
            $data['userid'] = $userid;
            $data['ownerid'] = $ownerid;
            $data['name'] = $postOwnerName;
            $data['image'] = $postOwnerImage;
            $data['nbcomments'] = $postCommentsCount;
            $data['oMbDisplayed'] = $oMbDisplayed;

            View::load('forum/forumPostView', $data);

            $oMbDisplayed = true;
        }
        if ($this->forumModel->getForumPostsCount() > ($offset + $limit)) {
            echo '<span class="view-more-posts" id="see-more">See More <i class="fa fa-refresh d-none"></i></span>';
        }
    }
    /*** End Get Forum Posts ***/
    /*** Insert Forum POst ***/
    function insertForumPost(){
        global $userid;

       //< POST FILES ariables 
        $textCodeInputs = isset($_POST['inputtextcode']) ? $_POST['inputtextcode'] : [];
        $inputTypes = isset($_POST['inputtype']) ? $_POST['inputtype'] : [];
        $attachements = isset($_FILES['attachements']) ? $_FILES['attachements'] : [];
        $forumPostTitle = $_POST['fptitle'];
       //>
       //< Date Now 
        date_default_timezone_set('africa/casablanca');
        $preDate = strtotime(date('Y-m-d H:i:s')) - 3600;
        $date = date('Y:m:d H:i:s', $preDate);
       //>
       //< Check Attachements number not 0
        $attachementscount = true;
        if (count($attachements['name']) == 1 && $attachements['error'][0] > 0) {
            $attachementscount = false;
        }
       //>

        if (strlen($forumPostTitle) > 0 && (count($textCodeInputs) > 0 || $attachementscount)) {
            // Generate Post Id
            $postIdExists = true;
            while ($postIdExists) {
                $postid = rand();
                if ($this->forumModel->checkPostIdExists($postid)) {
                    $postIdExists = false;
                }
            }
            // Insrt Forum Post
            $this->forumModel->insertForumPost($postid, $forumPostTitle, $date, $userid);

            // Handle Text Code Inputs
            for ($i=0; $i < count($textCodeInputs); $i++) {
                $contentType = $inputTypes[$i];
                $contentOrder = $i + 1;
                if (strlen($textCodeInputs[$i]) < 255) {
                    $type = 'db';
                    // insert as text type
                    $this->forumModel->insertForumPostContent($type, $contentType, $contentOrder, $postid, $textCodeInputs[$i]);

                }else{
                    $type = 'file';
                    // Generate File Name
                    $fileNameExists = true;
                    while ($fileNameExists) {
                        $fileNameid = uniqid();
                        $fileDestination = '../storage/files/'. $fileNameid .'.txt';
                        if (!file_exists($fileDestination)) {
                            $fileNameExists = false;
                        }
                    }
                    if ($this->forumModel->insertForumPostContent($type, $contentType, $contentOrder, $postid, $fileNameid.'.txt')) {
                        file_put_contents($fileDestination, $textCodeInputs[$i]);
                    }
                }
            }    

            // Handle File Inputd
            for ($i=0; $i < count($attachements['name']); $i++) { 
                $fileSplit = explode('.', $attachements['name'][$i]);
                $fileName = $fileSplit[0];
                $fileExtension = end($fileSplit);
                $fileSize = $attachements['size'][$i];
                $fileError = $attachements['error'][$i];
                $fileTmpName = $attachements['tmp_name'][$i];
                $fileType = $attachements['type'][$i];

                $imageTypes = ['image/png', 'image/jpg', 'image/jpeg'];

                // Generate File Name
                $fileNameExists = true;
                while ($fileNameExists) {
                    $fileNameid = uniqid();
                    $fileDestination = '../storage/images/'. $fileNameid . '.' . $fileExtension;
                    if (!file_exists($fileDestination)) {
                        $fileNameExists = false;
                    }
                }

                if (in_array($fileType, $imageTypes) && $fileError == 0 && $fileSize < MAX_IMAGE_SIZE) {
                    if ($this->forumModel->insertForumPostAttachement($fileName, $fileNameid.'.'.$fileExtension, $postid)) {
                        move_uploaded_file($fileTmpName, $fileDestination);
                    }
                }


            }

            header('location: ../forum.php');
        }
    }
    /*** End Forum POst ***/
    /*** Start Delete Forum Post ***/
    function deleteForumPost(){
        $postid = $_POST['forumpostid'];
        $postContent = $this->forumModel->getForumPostContent($postid);
        $postAttachement = $this->forumModel->getForumPostAttachement($postid);
        while ($row = $postContent->fetch(PDO::FETCH_ASSOC)) {
            unlink('../storage/files/' . $row['content']);
        }
        while ($row = $postAttachement->fetch(PDO::FETCH_ASSOC)) {
            unlink('../storage/images/' . $row['src']);
        }
        $this->forumModel->deleteForumPost($postid);
        // deltet images and files
    }
    /*** End Delete Forum Post ***/
    /*** Start Insert Forum Comment ***/
    function insertForumComment(){
        global $userid;
        $postid = $_POST['postid'];
        //< POST FILES ariables 
         $textCodeInputs = isset($_POST['inputtextcode']) ? $_POST['inputtextcode'] : [];
         $inputTypes = isset($_POST['inputtype']) ? $_POST['inputtype'] : [];
         $attachements = isset($_FILES['attachements']) ? $_FILES['attachements'] : [];
        //>
        //< Date Now 
         date_default_timezone_set('africa/casablanca');
         $preDate = strtotime(date('Y-m-d H:i:s')) - 3600;
         $date = date('Y:m:d H:i:s', $preDate);
        //>
        //< Check Attachements number not 0
         $attachementscount = true;
         if (count($attachements['name']) == 1 && $attachements['error'][0] > 0) {
             $attachementscount = false;
         }
        //>
 
         if (count($textCodeInputs) > 0 || $attachementscount) {
             // Generate Post Id
             $commentIdExists = true;
             while ($commentIdExists) {
                 $commentid = rand();
                 if ($this->forumModel->checkCommentIdExists($commentid)) {
                     $commentIdExists = false;
                 }
             }

             // Insrt Forum Comment
             $this->forumModel->insertForumComment($commentid, $date, $userid, $postid);

             // Insert Comment Notification
             //Get Forum Post Owner
             $postOwner = $this->forumModel->getForumPostInfos($postid)['userid'];
             

             // Handle Text Code Inputs
             for ($i=0; $i < count($textCodeInputs); $i++) {
                 $contentType = $inputTypes[$i];
                 $contentOrder = $i + 1;
                 if (strlen($textCodeInputs[$i]) < 255) {
                     $type = 'db';
                     // insert as text type
                     $this->forumModel->insertForumCommentContent($type, $contentType, $contentOrder, $commentid, $textCodeInputs[$i]);
 
                 }else{
                     $type = 'file';
                     // Generate File Name
                     $fileNameExists = true;
                     while ($fileNameExists) {
                         $fileNameid = uniqid();
                         $fileDestination = '../storage/files/'. $fileNameid .'.txt';
                         if (!file_exists($fileDestination)) {
                             $fileNameExists = false;
                         }
                     }
                     if ($this->forumModel->insertForumCommentContent($type, $contentType, $contentOrder, $commentid, $fileNameid.'.txt')) {
                         file_put_contents($fileDestination, $textCodeInputs[$i]);
                     }
                 }
             }    
 
             // Handle File Inputd
             for ($i=0; $i < count($attachements['name']); $i++) { 
                 $fileSplit = explode('.', $attachements['name'][$i]);
                 $fileName = $fileSplit[0];
                 $fileExtension = end($fileSplit);
                 $fileSize = $attachements['size'][$i];
                 $fileError = $attachements['error'][$i];
                 $fileTmpName = $attachements['tmp_name'][$i];
                 $fileType = $attachements['type'][$i];
 
                 $imageTypes = ['image/png', 'image/jpg', 'image/jpeg'];
 
                 // Generate File Name
                 $fileNameExists = true;
                 while ($fileNameExists) {
                     $fileNameid = uniqid();
                     $fileDestination = '../storage/images/'. $fileNameid . '.' . $fileExtension;
                     if (!file_exists($fileDestination)) {
                         $fileNameExists = false;
                     }
                 }
 
                 if (in_array($fileType, $imageTypes) && $fileError == 0 && $fileSize < MAX_IMAGE_SIZE) {
                     if ($this->forumModel->insertForumCommentAttachement($fileName, $fileNameid.'.'.$fileExtension, $commentid)) {
                         move_uploaded_file($fileTmpName, $fileDestination);
                     }
                 }
 
 
             }

            if ($postOwner != $userid) {
                $this->notificationModel->insertNotification($postOwner, $userid, 'forum-post-comment', $date, 'not seen', $postid.'.'.$commentid);
            }
 
             header('location:../forum.php?fpostid=' . $postid);
         }
    }
    /*** End Insert Forum Comment ***/
    /*** Start Get Forum Post Infos ***/
    function getForumPostInfos(){
        global $userid;
        $postid = $_GET['fpostid'];
        $postInfos = $this->forumModel->getForumPostInfos($postid);
        $postOwnerid = $postInfos['userid'];
        $userInfos = $this->istanetModel->getIstanetUserInfo($postOwnerid);
        $postAttachements = $this->forumModel->getForumPostAttachements($postid);
        $data['userid'] = $userid;
        $data['postOwner'] = $postOwnerid;
        $data['name'] = $userInfos['name'];
        $data['image'] = $this->forumModel->getUserImage($postOwnerid);
        $data['postid'] = $postid;
        $data['title'] = $postInfos['title'];
        $data['date'] = $postInfos['date'];
        $data['postInfos'] = $this->forumModel->getForumPostContents($postid)->fetchAll(PDO::FETCH_ASSOC);
        $data['attachements'] = $postAttachements;

        View::load('forum/forumInsidePostView', $data);
    }
    /*** End Get Post Infos ***/
    /*** Start Get Forum Post Infos ***/
    function getForumCommentsInfos(){
        global $userid;
        $postid = $_GET['fpostid'];
        $postComments = $this->forumModel->getForumComments($postid);
        while ($row = $postComments->fetch(PDO::FETCH_ASSOC)) {
            $commentid = $row['commentid'];
            $commentOwnerId = $row['userid'];
            $OwnerInfos = $this->istanetModel->getIstanetUserInfo($commentOwnerId);
            $data['image'] = $this->forumModel->getUserImage($commentOwnerId);

            $commentAttachements = $this->forumModel->getForumCommentAttachements($commentid);

            $data['commentOwner'] = $commentOwnerId;
            $data['userid'] = $userid;
            $data['name'] = $OwnerInfos['name'];
            $data['date'] = $row['date'];
            $data['commentid'] = $commentid;
            $data['commentInfos'] = $this->forumModel->getForumCommentContents($commentid)->fetchAll(PDO::FETCH_ASSOC);
            $data['attachements'] = $commentAttachements;


            View::load('forum/forumInsideCommentView', $data);
        }    
    }
    /*** End Get Post Infos ***/
    /*** Start Delete Forum Comment ***/
    function deleteForumComment(){
        $commentid = $_POST['forumcommentid'];
        $commentContent = $this->forumModel->getForumCommentContents($commentid);
        $commentAttachement = $this->forumModel->getForumCommentAttachements($commentid);

        while ($row = $commentContent->fetch(PDO::FETCH_ASSOC)) {
            unlink('../storage/files/' . $row['content']);
        }
        while ($row = $commentAttachement->fetch(PDO::FETCH_ASSOC)) {
            unlink('../storage/images/' . $row['src']);
        }
        $this->forumModel->deleteForumComment($commentid);
    }
    /*** End Delete Forum Comment ***/
    /*** Start Forum Post Comments Count ***/
    function ForumPostCommentsCount($postid){
        return $this->forumModel->getForumComments($postid)->rowCount();
    }
    /*** Start Forum Post Comments Count ***/
}