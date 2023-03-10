<?php
class MessageDB extends Dbconnect {
	private $con;
	public function __construct(){
		$this->con = $this->connect();
	}
    // Get Conv With Image
	function convUserImage($userid){
		$query = $this->con->prepare("SELECT * FROM userinfo WHERE userid = :userid");
        $query->bindParam(':userid', $userid);
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC)['image'];
	}
    // Check User image
	function checkUserImage($userid){
		$query = $this->con->prepare("SELECT * FROM userinfo WHERE userid = :userid");
        $query->bindParam(':userid', $userid);
		$query->execute();
		return !empty($query->fetch(PDO::FETCH_ASSOC));
	}
    // Check Conv Id Exists
    function checkConvIdExists($convKey){
        $query = $this->con->prepare("SELECT * FROM conversation WHERE conv_key = :conv_key");
        $query->bindParam(':conv_key', $convKey);
		$query->execute();
		return $query;
    }
    // Create New Conversation
    function createNewConversation($userid, $convWithId, $type, $convTitle, $convKey, $lastUpdate){
        $query = $this->con->prepare("INSERT INTO conversation (userid, conv_with, type, conv_title, conv_key, last_update) VALUES (:userid, :conv_with, :type, :conv_title, :conv_key, :last_update)");
        $query->bindParam(':userid', $userid);
        $query->bindParam(':conv_with', $convWithId);
        $query->bindParam(':type', $type);
        $query->bindParam(':conv_title', $convTitle);
        $query->bindParam(':conv_key', $convKey);
        $query->bindParam(':last_update', $lastUpdate);
		return $query->execute();
    }
    // New Conv Message
    function newConvMessage($userid, $date, $content, $convKey){
        $query = $this->con->prepare("INSERT INTO message (userid, date, content, conv_key) VALUES (:userid, :date, :content, :conv_key)");
        $query->bindParam(':userid', $userid);
        $query->bindParam(':date', $date);
        $query->bindParam(':content', $content);
        $query->bindParam(':conv_key', $convKey);
		return $query->execute();
    }
    // Get All Conversation
    function getAllConversations($userid){
        $query = $this->con->prepare("SELECT * FROM conversation WHERE userid = :userid ORDER BY last_update DESC");
        $query->bindParam(':userid', $userid);
		$query->execute();
		return $query;
    }
    // GET Conv LAst Message
    function getConvLastMessage($convKey){
        $query = $this->con->prepare("SELECT content FROM message WHERE conv_key = :conv_key ORDER BY date DESC LIMIT 1");
        $query->bindParam(':conv_key', $convKey);
		$query->execute();
		return $query;
    }
    // Insert New Message
    function newMessage($userid, $convKey, $content, $date){
        $query = $this->con->prepare("INSERT INTO message (userid, conv_key, content, date) VALUES (:userid, :conv_key, :content, :date)");
        $query->bindParam(':userid', $userid);
        $query->bindParam(':conv_key', $convKey);
        $query->bindParam(':content', $content);
        $query->bindParam(':date', $date);
        $query->execute();
		return $this->con;
    }
    // Insert Message Images
    function messageImage($imageName, $src, $messageId){
        $query = $this->con->prepare("INSERT INTO message_image(name, src, msgid) VALUES(:name, :src, :msgid)");
        $query->bindParam(':name', $imageName);
        $query->bindParam(':src', $src);
        $query->bindParam(':msgid', $messageId);
        return $query->execute();
    }
    // Get Conversation New Messages
    function getConvNewMessages($convKey, $lastUpdate){
        $query = $this->con->prepare("SELECT * FROM message WHERE conv_key = :conv_key AND date > :last_update ORDER BY date DESC");
        $query->bindParam(':conv_key', $convKey);
        $query->bindParam(':last_update', $lastUpdate);
		$query->execute();
		return $query;
    }
    // Get Conversation Messages
    function getConvMessages($convKey, $lastUpdate, $number){
        $query = $this->con->prepare("SELECT * FROM message WHERE conv_key = :conv_key AND date <= :last_update ORDER BY date DESC LIMIT :number");
        $query->bindParam(':conv_key', $convKey);
        $query->bindParam(':last_update', $lastUpdate);
        $query->bindParam(':number', $number, PDO::PARAM_INT);
		$query->execute();
		return $query;
    }
    // Get Conversation Messages
    function getConvPreviousMessages($convKey, $offset, $limit){
        $query = $this->con->prepare("SELECT * FROM message WHERE conv_key = :conv_key ORDER BY date DESC LIMIT :offset, :limit");
        $query->bindParam(':conv_key', $convKey);
        $query->bindParam(':offset', $offset, PDO::PARAM_INT);
        $query->bindParam(':limit', $limit, PDO::PARAM_INT);
		$query->execute();
		return $query;
    }
    // Get All Messages Count
    function getAllMessagesCount($convKey){
        $query = $this->con->prepare("SELECT COUNT(*) as total FROM message WHERE conv_key = :conv_key");
        $query->bindParam(':conv_key', $convKey);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC)['total'];
    }
    // Get All Conversation Messages Count
    function getAllConvMessagesCount($convKey, $lastUpdate){
        $query = $this->con->prepare("SELECT COUNT(*) as total FROM message WHERE conv_key = :conv_key AND date <= :last_update ORDER BY date DESC");
        $query->bindParam(':conv_key', $convKey);
        $query->bindParam(':last_update', $lastUpdate);
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC)['total'];
    }
    // Get Message Images
    function getMessageImages($msgid){
        $query = $this->con->prepare("SELECT src FROM message_image WHERE msgid = :msgid");
        $query->bindParam(':msgid', $msgid);
		$query->execute();
		return $query;
    }
    // Get Conv Infos
    function getConvInfos($userid, $roomid){
        $query = $this->con->prepare("SELECT * FROM conversation WHERE userid = :userid AND conv_key = :conv_key");
        $query->bindParam(':userid', $userid);
        $query->bindParam(':conv_key', $roomid);
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC);
    }
    // Get Message Infos
    function getMessageInfos($msgid){
        $query = $this->con->prepare("SELECT * FROM message WHERE msgid = :msgid");
        $query->bindParam(':msgid', $msgid);
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC);
    }
    // Get Desktop Online Member Image
    function desktopOnlineUserImage($userid){
		$query = $this->con->prepare("SELECT * FROM userinfo WHERE userid = :userid");
        $query->bindParam(':userid', $userid);
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC)['image'];
	}
    // Get User Image
    function getUserImage($userid){
		$query = $this->con->prepare("SELECT * FROM userinfo WHERE userid = :userid");
        $query->bindParam(':userid', $userid);
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC)['image'];
	}
    // Check Conversation With
	function checkConversationWith($userid,$withid){
		$query = $this->con->prepare("SELECT * FROM conversation WHERE userid = :userid AND conv_with = :conv_with");
        $query->bindParam(':userid', $userid);
		$query->bindParam(':conv_with', $withid);
        $query->execute();
        return $query;
	}
    // Get Unread Messages
	function getUnreadMessages($userid, $conv_key, $lastUpdate){
		$query = $this->con->prepare("SELECT COUNT(*) as total FROM message WHERE date > :last_update AND userid != :userid AND conv_key = :conv_key");
        $query->bindParam(':userid', $userid);
        $query->bindParam(':conv_key', $conv_key);
		$query->bindParam(':last_update', $lastUpdate);
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC)['total'];
	}
}