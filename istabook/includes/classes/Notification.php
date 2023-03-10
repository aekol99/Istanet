<?php
class Notification {
    private $istanetModel;
    private $settingModel;

    function __construct(){
        $this->notificationModel = new NotificationDB();
        $this->istanetModel = new IstanetDB();
    }

    /* Start Get All Notifications */
    function getNotifications($offset, $limit){
        global $userid;
        $notifications = $this->notificationModel->getNotifications($userid, $offset, $limit);
        $count = 1;
        $rowCount = $notifications->rowCount();
        if ($notifications->rowCount() > 0) {
            while ($notification = $notifications->fetch(PDO::FETCH_ASSOC)) {

                $whoUserInfo = $this->istanetModel->getIstanetUserInfo($notification['who']);
                $data['whoimage'] = $this->notificationModel->getUserImage($notification['who']);
                $data['whoname'] = $whoUserInfo['name'];
                $data['type'] = $notification['type'];
                $data['date'] = $notification['date'];

                $datachunks = explode('.',$notification['data']);

                $data['lastRow'] = ($count == $rowCount) ? true : false;

                if ($notification['type'] == 'post-like') {
                    $url = 'index.php?custom=true&pid=' . $datachunks[0] . '&likeid=' . $datachunks[1];
                }
                if ($notification['type'] == 'comment-like') {
                    $url = 'index.php?custom=true&pid=' . $datachunks[0] . '&commentid=' . $datachunks[1]. '&likeid=' . $datachunks[2];
                }
                if ($notification['type'] == 'post-comment') {
                    $url = 'index.php?custom=true&pid=' . $datachunks[0] . '&commentid=' . $datachunks[1];
                }
                if ($notification['type'] == 'forum-post-comment') {
                    $url = 'forum.php?fpostid=' . $datachunks[0] . '&commentid=' . $datachunks[1];
                }
                if ($notification['type'] == 'conv-added-to') {
                    $url = 'messages.php?roomid=' . $datachunks[0];
                }

                $data['url'] = $url;

                View::load('notification/notificationView', $data);
                $count++;
            }
        }else{
            echo "no notfications found";
        }

        if ($this->notificationModel->getNotificationsCount($userid) > ($offset + $limit)) {
            echo '<span class="view-more-notifs" id="see-more">See More <i class="fa fa-refresh ml-1 d-none"></i></span>';
        }  
    }
    /* End Get All Notifications */

    /*** Start Notification Numbers ***/
    function getNotificationNumbers($roomToIgnore){
        global $userid;

        // Get Last Update
        $homeLastUpdate = $this->notificationModel->getHomeLastUpdate($userid);
        $forumLastUpdate = $this->notificationModel->getForumLastUpdate($userid);
        $notificationLastUpdate = $this->notificationModel->getNotifLastUpdate($userid);
        // Get Home Notif Number
        $homeNumber = $this->notificationModel->getHomeNotifNumber($homeLastUpdate, $userid);
        // Get Messgaes Notif Number        
        $messagesNumber = 0;
        $userConversations = $this->notificationModel->getUserConversations($userid);
        while ($row = $userConversations->fetch(PDO::FETCH_ASSOC)) {
            if ($row['conv_key'] == $roomToIgnore) {
                continue;
            }
            $messagesNumber += $this->notificationModel->getMessagesNotifNumber($row['last_update'], $userid, $row['conv_key']);
        }
        // Get Forum Notif Number
        $forumNumber = $this->notificationModel->getForumNotifNumber($forumLastUpdate, $userid);
        // Get Notifications Notif Number
        $NotifNumber = $this->notificationModel->getNotificationNotifNumber($notificationLastUpdate, $userid);

        return $homeNumber . '.' . $messagesNumber . '.' . $NotifNumber . '.' . $forumNumber;
    }
    /*** End Notification Numbers ***/

    /*** Start Update Home Notifications Forum ***/
    function updateHomeNotifForum($page){
        global $userid;

        date_default_timezone_set('africa/casablanca');
        $date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) - 3600);

        if ($page == 'home') {
            $this->notificationModel->updateHomeLastUpdate($userid, $date);
        }
        if ($page == 'notifications') {
            $this->notificationModel->updateNotificationsLastUpdate($userid, $date);
        }
        if ($page == 'forum') {
            $this->notificationModel->updateForumLastUpdate($userid, $date);
        }
    }
    /*** End Update Home Notifications Forum ***/
    
}