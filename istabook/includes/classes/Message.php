<?php
if (!defined('MAX_IMAGE_SIZE')) {
    define('MAX_IMAGE_SIZE', 5000000);
}
class Message {
    private $messageModel;
    private $istanetModel;

    public function __construct(){
        $this->messageModel = new MessageDB();
        $this->istanetModel = new IstanetDB();
        $this->notificationModel = new NotificationDB();
    }
    /*** Start Create New Conversation ***/
    function newConversation(){
        global $userid;
        $convWithId = $_POST['withid'];
        $message = $_POST['message'];

        $type = 'person';
        $convTitle = NULL;

        date_default_timezone_set('africa/casablanca');
        $preDate = strtotime(date('Y-m-d H:i:s')) - 3600;
        $date = date('Y:m:d H:i:s', $preDate);
        $massageDate = date('Y:m:d H:i:s', $preDate + 1);

        // Generate Conversation Key
        while (true) {
            $convKey = uniqid();
            $convExistsCheck = $this->messageModel->checkConvIdExists($convKey);
            if ($convExistsCheck->rowCount() == 0) {
                break;
            }
        }

        // Create The Conversation
        $this->messageModel->createNewConversation($userid, $convWithId, $type, $convTitle, $convKey, $date);
        $this->messageModel->createNewConversation($convWithId, $userid, $type, $convTitle, $convKey, $date);
        $this->messageModel->newConvMessage($userid, $massageDate, $message, $convKey);

        header('location: ../messages.php?roomid=' . $convKey);
    }
    /*** End Create New Conversation ***/

    /*** Start New Conversation Search ***/
    function newConvSearch(){
        global $userid;
        $name = $_GET['name'];
        $results = $this->istanetModel->newConvSerachUsers($name, $userid);
        while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['userid'];
            $name = $row['name'];
            $image = 'profile.png';
            if ($this->messageModel->checkUserImage($id)) {
                $image = $this->messageModel->convUserImage($id);
            }
            $data['id'] = $id;
            $data['name'] = $name;
            $data['image'] = $image;
            View::load('message/newConvSearchView', $data);
        }
    }
    /*** End New Conversation Search ***/

    /*** Start Create New Conversation ***/
    function createNewConversation(){
        global $userid;
        $title = $_POST['title'];
        $persons = explode('.', $_POST['persons']);

        $type = 'group';

        date_default_timezone_set('africa/casablanca');
        $preDate = strtotime(date('Y-m-d H:i:s')) - 3600;
        $date = date('Y:m:d H:i:s', $preDate);

        // Generate Conversation Key
        while (true) {
            $convKey = uniqid();
            $convExistsCheck = $this->messageModel->checkConvIdExists($convKey);
            if ($convExistsCheck->rowCount() == 0) {
                break;
            }
        }

        // Create Conversation For Creator
        $this->messageModel->createNewConversation($userid, $userid, $type, $title, $convKey, $date);

        foreach ($persons as $person) {
            // Create Conversation For Invited Persons
            $this->messageModel->createNewConversation($person, $userid, $type, $title, $convKey, $date);
            // Insert Notification For Invited Persons
            $this->notificationModel->insertNotification($person, $userid, 'conv-added-to', $date, 'not seen', $convKey);
        }
        // Important
        echo $convKey;
    }
    /*** End Create New Conversation ***/

    /*** Start Get All Conversations ***/
    function getAllConversations(){
        global $userid;
        $conversations = $this->messageModel->getAllConversations($userid);
        if ($conversations->rowCount() == 0) {
            echo '<p class="mt-2 mb-0">No conversations found</p>';
        }
        while ($row = $conversations->fetch(PDO::FETCH_ASSOC)) {
            $type = $row['type'];
            $convWith = $row['conv_with'];
            $convKey = $row['conv_key'];
            $convLastUpdate = $row['last_update'];

            if ($type == 'group') {
                $convName = $row['conv_title'];
            }else {
                $convName = $this->istanetModel->getIstanetUserInfo($convWith)['name'];
            }

            $lastMessage = 'Send the first message';
            $lastMessageCheck = $this->messageModel->getConvLastMessage($convKey);
            if($lastMessageCheck->rowCount() != 0){
                $lastMessage = $lastMessageCheck->fetch(PDO::FETCH_ASSOC)['content'];
            }

            $unreadMessages = $this->messageModel->getUnreadMessages($userid, $convKey, $convLastUpdate);

            

            if ($type == 'group') {
                $convWithImage = 'conv-group.png';
            }else {
                $convWithImage = $this->messageModel->getUserImage($convWith);
            }

            $data['name'] = $convName;
            $data['image'] = $convWithImage;
            $data['msg'] = $lastMessage;
            $data['key'] = $convKey;
            $data['unread'] = $unreadMessages;
            View::load('message/chatRoomsView', $data);
        }
    }
    /*** End Get All Conversations ***/

    /*** Start New Send Message ***/
    function newMessage(){
        global $userid;
        $convKey = $_POST['roomid'];
        $msgText = isset($_POST['msg-text']) ? $_POST['msg-text'] : '';
        $msgImages = isset($_FILES['msg-images']) ? $_FILES['msg-images'] : [];

        // Set The Date
        date_default_timezone_set('africa/casablanca');
        $preDate = strtotime(date('Y-m-d H:i:s')) - 3600;
        $date = date('Y:m:d H:i:s', $preDate);

        // Check Images Uploaded
        $imagesUploaded = true;
        if (count($msgImages['name']) == 1 && $msgImages['error'][0] > 0) {
            $imagesUploaded = false;
        }

        if (!empty($msgText) || $imagesUploaded) {
            $messageId = $this->messageModel->newMessage($userid, $convKey, $msgText, $date)->lastInsertId();
        }

        // Insert & Upload Images
        if ($imagesUploaded) {
            for ($i=0; $i < count($msgImages['name']); $i++) { 
                $imageSplit = explode('.', $msgImages['name'][$i]);
                $imageName = $imageSplit[0];
                $imageExtension = end($imageSplit);
                $imageSize = $msgImages['size'][$i];
                $imageError = $msgImages['error'][$i];
                $imageTmpName = $msgImages['tmp_name'][$i];
                $imageType = $msgImages['type'][$i];

                $imageTypes = ['image/png', 'image/jpg', 'image/jpeg'];

                // Generate Image Name
                while (true) {
                    $imageNameid = uniqid();
                    $imageDestination = '../storage/images/'. $imageNameid . '.' . $imageExtension;
                    if (!file_exists($imageDestination)) {
                        break;
                    }
                }

                if (in_array($imageType, $imageTypes) && $imageError == 0 && $imageSize < MAX_IMAGE_SIZE) {
                    if ($this->messageModel->messageImage($imageName, $imageNameid.'.'.$imageExtension, $messageId)) {
                        move_uploaded_file($imageTmpName, $imageDestination);
                    }
                }


            }
        }

        if (!empty($msgText) || $imagesUploaded) {
            echo $messageId;
            $this->notificationModel->updateConvLastUpdate($userid, $convKey, $date);
        }
    }
    /*** End New Send Message ***/

    /*** Start Get Conversation Messages ***/
    function getConvMessages(){
        global $userid;
        $convKey = $_GET['roomid'];

        // Get The Date
        date_default_timezone_set('africa/casablanca');
        $preDate = strtotime(date('Y-m-d H:i:s')) - 3600;
        $date = date('Y:m:d H:i:s', $preDate);

        $convLastUpdate = $this->notificationModel->getConvLastUpdate($userid, $convKey);

        $newMessages = $this->messageModel->getConvNewMessages($convKey, $convLastUpdate);

        $newMessagesCount = $newMessages->rowCount();
        if ($newMessagesCount == 0 ) {
            $oldMessages = $this->messageModel->getConvMessages($convKey, $convLastUpdate, 10);
        }
        if ($newMessagesCount > 0) {
            $oldMessagesAmount = ($newMessagesCount < 6) ? (10 - $newMessagesCount) : 4;
            $oldMessages = $this->messageModel->getConvMessages($convKey, $convLastUpdate, $oldMessagesAmount);
        }
        $oldMessagesCount = $oldMessages->rowCount();
        
        $newMessages = array_reverse($newMessages->fetchAll(PDO::FETCH_ASSOC));
        $oldMessages = array_reverse($oldMessages->fetchAll(PDO::FETCH_ASSOC));

        //$firstMessageId = $oldMessages[0]['msgid'];
        $allConvMessagesCount = $this->messageModel->getAllConvMessagesCount($convKey, $convLastUpdate);
    
        if ($allConvMessagesCount > $oldMessagesCount) {
            echo '<span class="view-more-messages" id="see-more" data-initialCount=' . (count($oldMessages) + count($newMessages)) . '>Previous messages<i class="fa fa-refresh ml-1 d-none"></i></span>';
        }

        for ($i=0; $i < count($oldMessages); $i++) { 
            $msgid = $oldMessages[$i]['msgid'];
            $ownerId = $oldMessages[$i]['userid'];
            $ownerName = $this->istanetModel->getIstanetUserInfo($ownerId)['name'];
            $msgText = $oldMessages[$i]['content'];

            $messageImages = $this->messageModel->getMessageImages($msgid);
            $Images = ($messageImages->rowCount() > 0) ? $messageImages : [];

            $data['id'] = $ownerId;
            $data['name'] = $ownerName;
            $data['text'] = $msgText;
            $data['images'] = $Images;
            $data['mine'] = $ownerId == $userid ? 'msg-mine': 'msg-not-mine';

            View::load('message/insideRoomView', $data);
        }


        if ($newMessagesCount > 0 && $oldMessagesCount > 0) {
            echo "<span class='d-block text-center my-2' id='new-messages'>New Messages</span>";
        }


        for ($i=0; $i < count($newMessages); $i++) { 
            $msgid = $newMessages[$i]['msgid'];
            $ownerId = $newMessages[$i]['userid'];
            $ownerName = $this->istanetModel->getIstanetUserInfo($ownerId)['name'];
            $msgText = $newMessages[$i]['content'];

            $messageImages = $this->messageModel->getMessageImages($msgid);
            $Images = ($messageImages->rowCount() > 0) ? $messageImages : [];

            $data['id'] = $ownerId;
            $data['name'] = $ownerName;
            $data['text'] = $msgText;
            $data['images'] = $Images;
            $data['mine'] = $ownerId == $userid ? 'msg-mine': 'msg-not-mine';

            View::load('message/insideRoomView', $data);
        }


        $this->notificationModel->updateConvLastUpdate($userid, $convKey, $date);
    }
    /*** End Get Conversation Messages ***/

    /*** Start Get Previous Messages ***/
    function getPreviousMessages($convKey,$offset,$limit){
        global $userid;
        $previousMessages = $this->messageModel->getConvPreviousMessages($convKey, $offset, $limit);

        $messagesCount = $this->messageModel->getAllMessagesCount($convKey);

        if ($messagesCount > ($offset + $limit)) {
            echo '<span class="view-more-messages" id="see-more" data-initialCount=' . ($offset + $limit) . '>Previous messages<i class="fa fa-refresh ml-1 d-none"></i></span>';
        }

        $previousMessages = array_reverse($previousMessages->fetchAll(PDO::FETCH_ASSOC));
        for ($i=0; $i < count($previousMessages); $i++) { 
            $msgid = $previousMessages[$i]['msgid'];
            $ownerId = $previousMessages[$i]['userid'];
            $ownerName = $this->istanetModel->getIstanetUserInfo($ownerId)['name'];
            $msgText = $previousMessages[$i]['content'];

            $messageImages = $this->messageModel->getMessageImages($msgid);
            $Images = ($messageImages->rowCount() > 0) ? $messageImages : [];

            $data['id'] = $ownerId;
            $data['name'] = $ownerName;
            $data['text'] = $msgText;
            $data['images'] = $Images;
            $data['mine'] = $ownerId == $userid ? 'msg-mine': 'msg-not-mine';

            View::load('message/insideRoomView', $data);
        }
        
    }
    /*** End Get Previous Messages ***/

    /*** Start Get Inserted Message Infos ***/
    function getInsertedMessageInfos(){
        global $userid;
        $msgid = $_GET['messageid'];
        $msgInfos = $this->messageModel->getMessageInfos($msgid);
        $ownerId = $msgInfos['userid'];
        $ownerName = $this->istanetModel->getIstanetUserInfo($ownerId)['name'];
        $msgText = $msgInfos['content'];

        $messageImages = $this->messageModel->getMessageImages($msgid);
        $Images = ($messageImages->rowCount() > 0) ? $messageImages : [];

        $data['id'] = $ownerId;
        $data['name'] = $ownerName;
        $data['text'] = $msgText;
        $data['images'] = $Images;
        $data['mine'] = 'msg-mine';

        View::load('message/insideRoomView', $data);
    }
    /*** End Get Inserted Message Infos ***/

    /*** Start Instant Messages ***/
    function realtimeMessages(){
        global $userid;
        $convKey = $_GET['roomid'];

        // Get The Date
        date_default_timezone_set('africa/casablanca');
        $preDate = strtotime(date('Y-m-d H:i:s')) - 3600;
        $date = date('Y:m:d H:i:s', $preDate);

        $convLastUpdate = $this->notificationModel->getConvLastUpdate($userid, $convKey);
        $newMessages = $this->messageModel->getConvNewMessages($userid, $convKey, $convLastUpdate);

        $newMessages = array_reverse($newMessages->fetchAll(PDO::FETCH_ASSOC));

        for ($i=0; $i < count($newMessages); $i++) { 
            $msgid = $newMessages[$i]['msgid'];
            $ownerId = $newMessages[$i]['userid'];
            $ownerName = $this->istanetModel->getIstanetUserInfo($ownerId)['name'];
            $msgText = $newMessages[$i]['content'];

            $messageImages = $this->messageModel->getMessageImages($msgid);
            $Images = ($messageImages->rowCount() > 0) ? $messageImages : [];

            $data['id'] = $ownerId;
            $data['name'] = $ownerName;
            $data['text'] = $msgText;
            $data['images'] = $Images;

            View::load('message/insideRoomView', $data);
        }
        

        if (count($newMessages) > 0) {

            $this->notificationModel->updateConvLastUpdate($userid, $convKey, $date);
        }
    }
    /*** End Instant Messages ***/

    /*** Start Get Conv NAme ***/
    function getConvName($roomid){
        global $userid;

        $convInfos = $this->messageModel->getConvInfos($userid, $roomid);

        $convName = '<i class="fa fa-group mr-2"></i>' . $convInfos['conv_title'];

        if ($convInfos['type'] == 'person') {
            $convName = '<i class="fa fa-user mr-2"></i>' . $this->istanetModel->getIstanetUserInfo($convInfos['conv_with'])['name'];
        }

        return $convName;
    }
    /*** End Get Conv NAme ***/
}