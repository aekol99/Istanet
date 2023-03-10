<?php
class SettingDB extends Dbconnect {
	private $con;
	public function __construct(){
		$this->con = $this->connect();
	}

    // Get user Image
	function getUserInfo($userid){
		$query = $this->con->prepare("SELECT * FROM userinfo WHERE userid = :userid");
        $query->bindParam(':userid', $userid);
		$query->execute();
		return $query;
	}
	// Insert User Image
	function insertUserImage($userid,$image){
		$query = $this->con->prepare("INSERT INTO userinfo(userid,image) VALUES(:userid, :image)");
        $query->bindParam(':userid', $userid);
		$query->bindParam(':image', $image);
		return $query->execute();
	}
	// Update User Image
	function updateUserImage($userid,$image){
		$query = $this->con->prepare("UPDATE userinfo SET image = :image WHERE userid = :userid");
        $query->bindParam(':userid', $userid);
		$query->bindParam(':image', $image);
		return $query->execute();
	}
	// Insert Social Media
	function insertSocialMedia($userid,$email,$facebook,$whatsapp){
		$query = $this->con->prepare("INSERT INTO userinfo(userid,email,facebook,whatsapp) VALUES(:userid, :email,:facebook,:whatsapp)");
        $query->bindParam(':userid', $userid);
		$query->bindParam(':email', $email);
		$query->bindParam(':facebook', $facebook);
		$query->bindParam(':whatsapp', $whatsapp);
		return $query->execute();
	}
	// Update Social Media
	function updateSocialMedia($userid,$email,$facebook,$whatsapp){
		$query = $this->con->prepare("UPDATE userinfo SET email=:email, facebook=:facebook, whatsapp=:whatsapp WHERE userid = :userid");
        $query->bindParam(':userid', $userid);
		$query->bindParam(':email', $email);
		$query->bindParam(':facebook', $facebook);
		$query->bindParam(':whatsapp', $whatsapp);
		return $query->execute();
	}
}