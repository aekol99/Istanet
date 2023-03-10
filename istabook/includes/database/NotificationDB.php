<?php
class NotificationDB extends Dbconnect {
	private $con;
	public function __construct(){
		$this->con = $this->connect();
	}

    // Start Get All Notifications
    function getNotifications($userid, $offset, $limit){
        $query = $this->con->prepare("SELECT * FROM notification WHERE userid = :userid ORDER BY date DESC LIMIT :offset, :limit");
        $query->bindParam(':userid', $userid);
        $query->bindParam(':offset', $offset, PDO::PARAM_INT);
        $query->bindParam(':limit', $limit, PDO::PARAM_INT);
        $query->execute();
        return $query;
    }
    // Start Notifications Count
    function getNotificationsCount($userid){
        $query = $this->con->prepare("SELECT COUNT(*) as total FROM notification WHERE userid = :userid");
        $query->bindParam(':userid', $userid);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC)['total'];
    }
    //Start Insert Notification 
    function insertNotification($userid, $who, $type, $date, $status, $data){
        $query = $this->con->prepare("INSERT INTO notification(userid, who, type, date, status, data) VALUES(:userid, :who, :type, :date, :status, :data)");
        $query->bindParam(':userid', $userid);
        $query->bindParam(':who', $who);
        $query->bindParam(':type', $type);
        $query->bindParam(':date', $date);
        $query->bindParam(':status', $status);
        $query->bindParam(':data', $data);
		return $query->execute();
    }
    // Get user Image
	function getUserImage($userid){
		$query = $this->con->prepare("SELECT * FROM userinfo WHERE userid = :userid");
        $query->bindParam(':userid', $userid);
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC)['image'];
	}
    // Get Conv Last Update
	function getConvLastUpdate($userid, $convKey){
		$query = $this->con->prepare("SELECT last_update FROM conversation WHERE userid = :userid AND conv_key = :conv_key");
        $query->bindParam(':userid', $userid);
        $query->bindParam(':conv_key', $convKey);
        $query->execute();
		return $query->fetch(PDO::FETCH_ASSOC)['last_update'];
	}
    // Update Conv Last Update
	function updateConvLastUpdate($userid, $convKey, $date){
		$query = $this->con->prepare("UPDATE conversation SET last_update = :last_update WHERE userid = :userid AND conv_key = :conv_key");
        $query->bindParam(':userid', $userid);
        $query->bindParam(':conv_key', $convKey);
        $query->bindParam(':last_update', $date);
		return $query->execute();
	}
    // Get Home Notification Number
	function getHomeNotifNumber($last_update, $userid){
		$query = $this->con->prepare("SELECT COUNT(*) as total FROM post WHERE date > :last_update AND userid != :userid");
        $query->bindParam(':userid', $userid);
		$query->bindParam(':last_update', $last_update);
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC)['total'];
	}
    // Get Messages Notification Number
	function getMessagesNotifNumber($last_update, $userid, $conv_key){
		$query = $this->con->prepare("SELECT COUNT(*) as total FROM message WHERE date > :last_update AND userid != :userid AND conv_key = :conv_key");
        $query->bindParam(':userid', $userid);
        $query->bindParam(':conv_key', $conv_key);
		$query->bindParam(':last_update', $last_update);
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC)['total'];
	}
    // Get Forum Notification Number
	function getForumNotifNumber($last_update, $userid){
		$query = $this->con->prepare("SELECT COUNT(*) as total FROM forum_post WHERE date > :last_update AND userid != :userid");
        $query->bindParam(':userid', $userid);
		$query->bindParam(':last_update', $last_update);
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC)['total'];
	}
    // Get Notification Notification Number
	function getNotificationNotifNumber($last_update, $userid){
		$query = $this->con->prepare("SELECT COUNT(*) as total FROM notification WHERE date > :last_update AND userid = :userid");
        $query->bindParam(':userid', $userid);
		$query->bindParam(':last_update', $last_update);
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC)['total'];
	}
    // Get Home last Update
    function getHomeLastUpdate($userid){
        $query = $this->con->prepare("SELECT last_update FROM home_update WHERE userid = :userid ");
		$query->bindParam(':userid', $userid);
		$query->execute();
        return $query->fetch(PDO::FETCH_ASSOC)['last_update'];
    }
    // Get Messages last Update
    function getMessagesLastUpdate($userid){
        $query = $this->con->prepare("SELECT last_update FROM messages_update WHERE userid = :userid ");
		$query->bindParam(':userid', $userid);
		$query->execute();
        return $query->fetch(PDO::FETCH_ASSOC)['last_update'];
    }
    // Get Forum last Update
    function getForumLastUpdate($userid){
        $query = $this->con->prepare("SELECT last_update FROM forum_update WHERE userid = :userid ");
		$query->bindParam(':userid', $userid);
		$query->execute();
        return $query->fetch(PDO::FETCH_ASSOC)['last_update'];
    }
    // Get Notificaion last Update
    function getNotifLastUpdate($userid){
        $query = $this->con->prepare("SELECT last_update FROM notification_update WHERE userid = :userid ");
		$query->bindParam(':userid', $userid);
		$query->execute();
        return $query->fetch(PDO::FETCH_ASSOC)['last_update'];
    }
    // Update Home Last Update
    function updateHomeLastUpdate($userid, $last_update){
        $query = $this->con->prepare("UPDATE home_update SET last_update = :last_update WHERE userid = :userid");
        $query->bindParam(':userid', $userid);
        $query->bindParam(':last_update', $last_update);
		return $query->execute();
    }
    // Update Messages Last Update
    function updateMessagesLastUpdate($userid, $last_update){
        $query = $this->con->prepare("UPDATE messages_update SET last_update = :last_update WHERE userid = :userid");
        $query->bindParam(':userid', $userid);
        $query->bindParam(':last_update', $last_update);
		return $query->execute();
    }
    // Update Notifications Last Update
    function updateNotificationsLastUpdate($userid, $last_update){
        $query = $this->con->prepare("UPDATE notification_update SET last_update = :last_update WHERE userid = :userid");
        $query->bindParam(':userid', $userid);
        $query->bindParam(':last_update', $last_update);
		return $query->execute();
    }
    // Update Forum Last Update
    function updateForumLastUpdate($userid, $last_update){
        $query = $this->con->prepare("UPDATE forum_update SET last_update = :last_update WHERE userid = :userid");
        $query->bindParam(':userid', $userid);
        $query->bindParam(':last_update', $last_update);
		return $query->execute();
    }
    // Get User Conversations
    function getUserConversations($userid){
        $query = $this->con->prepare("SELECT conv_key, last_update FROM conversation WHERE userid = :userid ");
		$query->bindParam(':userid', $userid);
		$query->execute();
        return $query;
    }
}