<?php
class Profile {
    private $forumModel;
    private $istanetModel;

    public function __construct(){
        $this->profileModel = new ProfileDB();
        $this->istanetModel = new IstanetDB();
    }
    /*** Start Get Profile Posts ***/
    function getProfilePosts($offset, $limit){
        global $profileid;
        global $userid;
        date_default_timezone_set('africa/casablanca');
        // get user name
        $userInfos = $this->istanetModel->getIstanetUserInfo($profileid);
        $userName = $userInfos['name'];
        // get user image
        $userImage = 'storage/images/profile.png';
        $userinfo = $this->profileModel->getUserInfo($profileid);
        if ($userinfo->rowCount() > 0) {
            $userImage = 'storage/images/' . $userinfo->fetch(PDO::FETCH_ASSOC)['image'];
        }

        $profilePosts = $this->profileModel->getAllPosts($profileid, $offset, $limit);

        if ($profilePosts->rowCount() > 0) {
            while ($row = $profilePosts->fetch(PDO::FETCH_ASSOC)) {
                $postid = $row['postid'];
                $content = $row['content'];
                $date = $row['date'];
                
                if (strlen($content) > 93) {
                    $content = substr($content, 0, 93) . '...';
                    $content .= '<a href="" data-commentid=' . $postid . ' id="see_more">See more</a>';
                }
            
                // Post likes & comments
                $postLiked = $this->profileModel->checkPostLikedBy($userid, $postid);
                $likesNumber = $this->profileModel->getPostLikesNumber($postid);
                $commentsNumber = $this->profileModel->getPostCommentsNumber($postid);
            
                // post image/video
                $postFile = $this->profileModel->getPostFile($postid);
            
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
                
                $data['userid'] = $userid;
                $data['profileid'] = $profileid;
                $data['date'] = $date;
                $data['userImage'] = $userImage;
                $data['userName'] = $userName;
                $data['postid'] = $postid;
                $data['content'] = $content;
                $data['postFile'] = $postFile;
                $data['likesNumber'] = $likesNumber;
                $data['postLiked'] = $postLiked;
                $data['commentsNumber'] = $commentsNumber;
                
                View::load('profile/profilePostsView', $data);
            }
        }else {
            echo '<div class="card"><div class="p-3">No results found</div></div>';
        }

        if ($this->profileModel->getPostsCount($profileid) > ($offset + $limit)) {
            echo '<span class="view-more-posts" id="see-more">See More <i class="fa fa-refresh d-none"></i></span>';
        }
    }
    /*** End Get Profile Posts ***/
    /*** Start Get Profile Forum Posts ***/
    function getForumPosts($offset, $limit){
        global $profileid;
        global $userid;

        // get user name
        $userName = $this->istanetModel->getIstanetUserInfo($profileid)['name'];
        // get user image
        $userImage = $this->profileModel->getOwnerImage($profileid);

        $forumPosts = $this->profileModel->getForumPosts($profileid, $offset, $limit);

        if ($forumPosts->rowCount() > 0) {
            while ($row = $forumPosts->fetch(PDO::FETCH_ASSOC)) {
                $postTitle = $row['title'];
                $postid = $row['postid'];
                $date = $row['date'];
    
                // get comments count
                $postCommentsCount = $this->profileModel->getCommentsCount($postid);
    
                $data['userid'] = $userid;
                $data['profileid'] = $profileid;
                $data['postid'] = $postid;
                $data['title'] = $postTitle;
                $data['date'] = $date;
                $data['name'] = $userName;
                $data['image'] = $userImage;
                $data['nbcomments'] = $postCommentsCount;
    
                View::load('profile/profileForumPostsView', $data);
            }
        }else {
            echo '<div class="card"><div class="p-3">No results found</div></div>';
        }

        if ($this->profileModel->getForumPostsCount($profileid) > ($offset + $limit)) {
            echo '<span class="view-more-posts" id="see-more">See More <i class="fa fa-refresh d-none"></i></span>';
        }
    }
    /*** End Get Profile Forum Posts ***/
    /*** Start Get Profile Info ***/
    function getProfileInfos(){
        global $profileid;
        // get user name
        $userInfos = $this->istanetModel->getIstanetUserInfo($profileid);
        $userName = $userInfos['name'];
        if ($userInfos['filliere'] == 'dev') {
            $filliere = 'Développement Digitale';
        }elseif ($userInfos['filliere'] == 'inf') {
            $filliere = 'Infrastructure Digitale';
        }
        $groupe = $userInfos['groupe'];
        // get user image
        $userImage = 'storage/images/profile.png';
        $userinfo = $this->profileModel->getUserInfo($profileid);
        $email = '';
        $facebook = '';
        $whatsapp = '';
        if ($userinfo->rowCount() > 0) {
            $profileInfos = $userinfo->fetch(PDO::FETCH_ASSOC);
            $userImage = 'storage/images/' . $profileInfos['image'];
            $email = $profileInfos['email'];
            $facebook = $profileInfos['facebook'];
            $whatsapp = $profileInfos['whatsapp'];
        }

        $data['name'] = $userName;
        $data['filliere'] = $filliere;
        $data['groupe'] = $groupe;
        $data['image'] = $userImage;
        $data['email'] = $email;
        $data['facebook'] = $facebook;
        $data['whatsapp'] = $whatsapp;

        View::load('profile/profileInfoView', $data);
    }
    /*** End Get Profile Info ***/
}