<?php
class OnlineMembers {
    private $onlineMembersModel;
    private $istanetModel;

    public function __construct(){
        $this->onlineMembersModel = new OnlineMembersDB();
        $this->istanetModel = new IstanetDB();
    }

    /*** Start Desktop Online Members ***/
    function desktopOnlineMembers($target){
        global $userid;
        if ($target == 'first8') {
            $users = $this->istanetModel->getAllUsers($userid, 0, 8);
        }elseif ($target == 'others') {
            $users = $this->istanetModel->getAllUsers($userid, 8, 25);
        }

        while ($row = $users->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['userid'];
            $name = $row['name'];

            $image = 'profile.png';
            if ($this->onlineMembersModel->checkUserImage($id)) {
                $image = $this->onlineMembersModel->desktopOnlineUserImage($id);
            }

            // Check already contacted with
            $contactedCheck = $this->onlineMembersModel->checkConversationWith($userid,$id);
        

            $checkMemberOnline = $this->checkMemberOnline($id);
            $memberOnline = $checkMemberOnline < 15 ? '' : ' d-none';
            if ($contactedCheck->rowCount() > 0) {
                $roomid = $contactedCheck->fetch(PDO::FETCH_ASSOC)['conv_key'];
                echo "<a href='messages.php?roomid=$roomid' class='person d-flex py-2 online-member' data-id='$id'>
                <div class='position-relative'>
                <img src='storage/images/$image' width='30' height='30' class='rounded-circle'>
                <span class='online-member-icon$memberOnline'></span>
                </div>
                <span class='ml-2'>
                    $name
                </span>
                </a>";
            }else {
                echo "<a href='#' class='person d-flex py-2 send-message-btn online-member' data-id='$id'>
                <div class='position-relative'>
                <img src='storage/images/$image' width='30' height='30' class='rounded-circle'>
                <span class='online-member-icon$memberOnline'></span>
                </div>
                <span class='ml-2'>
                    $name
                </span>
                </a>";
            }
        }
    }
    /*** End Desktop Online Members ***/

    /* Start Update Last Impression */
    function updateLastImpression(){
        global $userid;
        date_default_timezone_set('africa/casablanca');
        $newDate = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) - 3600);
        $this->onlineMembersModel->updateLastImpression($userid, $newDate);
    }
    /* End Update Last Impression */

    function updateOnlineMembers(){
        $userid = $_POST['userid'];
        echo $this->checkMemberOnline($userid);
    }

    /*************************************/
    /*** Start Check Member Online ***/
    function checkMemberOnline($userid){
        $lastImpression = $this->onlineMembersModel->lastOnlineImpression($userid);
        //Time Processing
        date_default_timezone_set('africa/casablanca');
        $dateNow = strtotime(date('Y-m-d H:i:s')) - 3600;
        $postDate = strtotime($lastImpression);
        $dateDiff = $dateNow - $postDate;

        return $dateDiff;
    }
    /*** End Check Member Online ***/

    /*** Start Online Members Count ***/
    function onlineMembersCount(){
        global $userid;
        $onlineMembersCount = 0;
        $users = $this->istanetModel->getAllUsers($userid, 0, 25);
        while ($row = $users->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['userid'];
            $checkMemberOnline = $this->checkMemberOnline($id);
            if($checkMemberOnline < 15){
                $onlineMembersCount++;
            }
        }
        return $onlineMembersCount;
    }
    /*** End Online Members Count ***/
}