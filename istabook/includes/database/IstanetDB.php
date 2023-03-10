<?php
class IstanetDB extends IstanetDbconnect {
    private $con;
    public function __construct(){
        $this->con = $this->connect();
    }
    // Get User Infos
	function getIstanetUserInfo($userid){
		$query = $this->con->prepare("SELECT * FROM users WHERE userid = :userid");
		$query->bindParam(':userid', $userid);
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC);
	}
    // Check Password
    function checkPassword($userid, $password){
        $query = $this->con->prepare('SELECT * FROM users WHERE userid = :userid AND password = :password');
        $query->bindParam(':userid', $userid);
        $query->bindParam(':password', $password);
        $query->execute();
        return $query->rowCount();
    }
    // Update Password
    function updatePassword($userid, $newPassword){
        $query = $this->con->prepare('UPDATE users SET password = :newPassword WHERE userid = :userid');
        $query->bindParam(':userid', $userid);
        $query->bindParam(':newPassword', $newPassword);
        return $query->execute();
    }
    // Search Users
    function serachUsers($name){
        $query = $this->con->prepare("SELECT * FROM users WHERE name LIKE :name");
        $name = "%" . $name . "%";
		$query->bindParam(':name', $name);
		$query->execute();
		return $query;
    }
    // New Conversation Search
    function newConvSerachUsers($name, $userid){
        $query = $this->con->prepare("SELECT * FROM users WHERE name LIKE :name AND userid != :userid");
        $name = "%" . $name . "%";
		$query->bindParam(':name', $name);
        $query->bindParam(':userid', $userid);
		$query->execute();
		return $query;
    }
    // Get First 8 Users
	function getAllUsers($userid, $offset, $limit){
		$query = $this->con->prepare("SELECT userid, name FROM users WHERE userid != :userid ORDER BY name ASC LIMIT :offset, :limit");
        $query->bindParam(':userid', $userid);
		$query->bindParam(':limit', $limit, PDO::PARAM_INT);
        $query->bindParam(':offset', $offset, PDO::PARAM_INT);
		$query->execute();
		return $query;
	}

}