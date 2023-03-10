<?php
class OnlineMembersDB extends Dbconnect {
	private $con;
	public function __construct(){
		$this->con = $this->connect();
	}
    // Check User image
	function checkUserImage($userid){
		$query = $this->con->prepare("SELECT * FROM userinfo WHERE userid = :userid");
        $query->bindParam(':userid', $userid);
		$query->execute();
		return !empty($query->fetch(PDO::FETCH_ASSOC));
	}
    // Get Desktop Online Member Image
    function desktopOnlineUserImage($userid){
		$query = $this->con->prepare("SELECT * FROM userinfo WHERE userid = :userid");
        $query->bindParam(':userid', $userid);
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC)['image'];
	}
    // Check Conversation With
	function checkConversationWith($userid,$withid){
		$query = $this->con->prepare("SELECT * FROM conversation WHERE userid = :userid AND conv_with = :conv_with AND type = 'person'");
        $query->bindParam(':userid', $userid);
		$query->bindParam(':conv_with', $withid);
        $query->execute();
        return $query;
	}
	// Last Online Impression
	function lastOnlineImpression($userid){
		$query = $this->con->prepare("SELECT last_update FROM online_members WHERE userid = :userid");
        $query->bindParam(':userid', $userid);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC)['last_update'];
	}
	// Update Last Impression
	function updateLastImpression($userid, $newDate){
		$query = $this->con->prepare("UPDATE online_members SET last_update = :new_date WHERE userid = :userid");
        $query->bindParam(':new_date', $newDate);
		$query->bindParam(':userid', $userid);
        return $query->execute();
	}
}