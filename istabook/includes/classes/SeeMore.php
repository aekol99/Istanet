<?php
class SeeMore {
    private $home;
    private $notification;
    private $forum;
    private $profile;
    private $message;

    public function __construct(){
        $this->home = new Home();
        $this->notification = new Notification();
        $this->forum = new Forum();
        $this->profile = new Profile();
        $this->message = new Message();
        $this->search = new Search();
    }
    // Home More Posts
    function moreHomePosts(){
        $offset = $_POST['offset'];
        $this->home->homePosts($offset, 10);
    }
    // Forum More Posts
    function moreForumPosts(){
        $offset = $_POST['offset'];
        $this->forum->getForumPosts($offset, 10);
    }
    // More Notifications
    function moreNotifications(){
        $offset = $_POST['offset'];
        $this->notification->getNotifications($offset, 10);
    }
    // Profile More Posts
    function profileMorePosts(){
        global $profileid;
        if (isset($_POST['profileid'])) {
            $profileid = $_POST['profileid'];
        }
        $offset = $_POST['offset'];

        $profileTarget = $_POST['profiletarget'];
        if ($profileTarget == 'posts') {
            $this->profile->getProfilePosts($offset, 10);
        }
        if ($profileTarget == 'forum-posts') {
            $this->profile->getForumPosts($offset, 10);
        }
    }
    // More Messages
    function moreMessages(){
        $convKey = $_POST['roomid'];
        $initialCount = $_POST['initialcount'];
        $limit = 10;

        $this->message->getPreviousMessages($convKey,$initialCount,$limit);
    }

    // More Search
    function moreSearch(){
        // $keyword is in search 
        $searchTarget = $_POST['starget'];
        $offset = $_POST['offset'];
        $limit = 10;

        if ($searchTarget == 'posts') {
            $this->search->searchPosts($offset, $limit);
        }

        if ($searchTarget == 'forum-posts') {
            $this->search->searchForumPosts($offset, $limit);
        }
    }
}