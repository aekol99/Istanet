<?php
class Search {
    private $searchModel;
    private $istanetModel;

    public function __construct(){
        $this->searchModel = new SearchDB();
        $this->istanetModel = new IstanetDB();
    }
    /***  Search Persons ***/
    function searchPersons(){
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        if (empty($keyword)) {
            echo '<div class="p-3">Please type something</div>';
        }else{
            $personResults = $this->istanetModel->serachUsers($keyword);
            if ($personResults->rowCount() > 0) {
                while($row = $personResults->fetch(PDO::FETCH_ASSOC)){
                    $userid = $row['userid'];
                    // Get User image
                    $personImage = 'profile.png';
                    if ($this->searchModel->checkUserImage($userid)) {
                        $personImage = $this->searchModel->getUserImage($userid);
                    }
                    
                    $data['userid'] = $userid;
                    $data['name'] = $row['name'];
                    $data['filliere'] = $row['filliere'];
                    $data['groupe'] = $row['groupe'];
                    $data['image'] = $personImage;
    
                    View::load('search/searchPersonsView', $data);
                }
            }else{
                echo '<div class="p-3">No results found</div>';
            }
            
        }
    }
    /***  End Persons ***/

    /*** Start Search Posts ***/
    function searchPosts($offset, $limit){
        global $userid;

        if (isset($_POST['keyword'])) {
            $keyword = $_POST['keyword'];
        }elseif (isset($_GET['keyword'])){
            $keyword = $_GET['keyword'];
        }else{
            $keyword = '';
        }
        
        if (empty($keyword)) {
            echo '<div class="card"><div class="p-3">Please type something</div></div>';
        }else{
            date_default_timezone_set('africa/casablanca');
            $postResults = $this->searchModel->getAllPosts($keyword, $offset, $limit);
            if ($postResults->rowCount() > 0) {
                while ($row = $postResults->fetch(PDO::FETCH_ASSOC)) {
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
                    $userinfo = $this->searchModel->getPostOwnerInfo($postownerid);
                    if ($userinfo->rowCount() > 0) {
                        $userImage = 'storage/images/' . $userinfo->fetch(PDO::FETCH_ASSOC)['image'];
                    }
                
                    // Post likes & comments
                    $postLiked = $this->searchModel->checkPostLikedBy($userid, $postid);
                    $likesNumber = $this->searchModel->getPostLikesNumber($postid);
                    $commentsNumber = $this->searchModel->getPostCommentsNumber($postid);
                
                    // post image/video
                    $postFile = $this->searchModel->getPostFile($postid);
                
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
                    
                    View::load('search/searchPostsView', $data);
                }

                if ($this->searchModel->getAllPostsSearchCount($keyword) > ($offset + $limit)) {
                    echo '<span class="view-more-posts" id="see-more">See More <i class="fa fa-refresh d-none"></i></span>';
                }
            }else {
                echo '<div class="card"><div class="p-3">No results found</div></div>';
            }
        }
    }
    /*** End Search Posts ***/

    /*** Start Search Forum Posts ***/
    function searchForumPosts($offset, $limit){
        global $userid;
        
        if (isset($_POST['keyword'])) {
            $keyword = $_POST['keyword'];
        }elseif (isset($_GET['keyword'])){
            $keyword = $_GET['keyword'];
        }else{
            $keyword = '';
        }

        if (empty($keyword)) {
            echo '<div class="card"><div class="p-3">Please type something</div></div>';
        }else{
            $forumPosts = $this->searchModel->getForumPosts($keyword, $offset, $limit);
            $oMbDisplayed = false;
            if ($forumPosts->rowCount() > 0) {
                while ($row = $forumPosts->fetch(PDO::FETCH_ASSOC)) {
                    $postTitle = $row['title'];
                    $postid = $row['postid'];
                    $date = $row['date'];
                    $ownerid = $row['userid'];
        
                    // get comments count
                    $postCommentsCount = $this->searchModel->getCommentsCount($postid);
                    // get user image
                    $postOwnerImage = $this->searchModel->getOwnerImage($ownerid);
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
        
                    View::load('search/searchForumPostsView', $data);
        
                    $oMbDisplayed = true;
                }

                if ($this->searchModel->getForumPostsSearchCount($keyword) > ($offset + $limit)) {
                    echo '<span class="view-more-posts" id="see-more">See More <i class="fa fa-refresh d-none"></i></span>';
                }
            }else {
                echo '<div class="card"><div class="p-3">No results found</div></div>';
            }
        }
    }
    /*** End Search Forum Posts ***/


}