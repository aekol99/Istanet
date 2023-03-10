<?php
class ProfileDB extends Dbconnect {
	private $con;
	public function __construct(){
		$this->con = $this->connect();
	}
    // Get All Posts
	function getAllPosts($userid, $offset, $limit){
		$query = $this->con->prepare("SELECT * FROM post WHERE userid = :userid ORDER BY date DESC LIMIT :offset, :limit");
        $query->bindParam(':userid', $userid);
		$query->bindParam(':offset', $offset, PDO::PARAM_INT);
		$query->bindParam(':limit', $limit, PDO::PARAM_INT);
		$query->execute();
		return $query;
	}
	// Get Posts Count
	function getPostsCount($userid){
		$query = $this->con->prepare("SELECT COUNT(*) as total FROM post WHERE userid = :userid");
        $query->bindParam(':userid', $userid);
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC)['total'];
	}
    // Get User Info
	function getUserInfo($userid){
		$query = $this->con->prepare("SELECT * FROM userinfo WHERE userid = :userid");
		$query->bindParam(':userid', $userid);
		$query->execute();
		return $query;
	}
    // Get Post Number Of Likes
	function getPostLikesNumber($postid){
		$query = $this->con->prepare("SELECT * FROM post_like WHERE postid = :postid");
		$query->bindParam(':postid', $postid);
		$query->execute();
		return $query->rowCount();
	}
	// Get Post Number Of Comments
	function getPostCommentsNumber($postid){
		$query = $this->con->prepare("SELECT * FROM post_comment WHERE postid = :postid");
		$query->bindParam(':postid', $postid);
		$query->execute();
		return $query->rowCount();
	}
    // Check If A User Is Already Liked A Post
	function checkPostLikedBy($userid, $postid){
		$query = $this->con->prepare("SELECT * FROM post_like WHERE userid = :userid AND postid = :postid");
		$query->bindParam(':userid', $userid);
		$query->bindParam(':postid', $postid);
		$query->execute();
		return $query->rowCount();
	}
    // Get Post Image / Video
	function getPostFile($postid){
		$query = $this->con->prepare("SELECT * FROM post_file WHERE postid = :postid");
		$query->bindParam(':postid', $postid);
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC);
	}
    // Get Forum Posts
    function getForumPosts($userid, $offset, $limit){
        $query = $this->con->prepare("SELECT * FROM forum_post WHERE userid = :userid ORDER BY date DESC LIMIT :offset, :limit");
        $query->bindParam(':userid', $userid);
		$query->bindParam(':offset', $offset, PDO::PARAM_INT);
		$query->bindParam(':limit', $limit, PDO::PARAM_INT);
		$query->execute();
        return $query;
    }
	// Get Forum Posts
    function getForumPostsCount($userid){
        $query = $this->con->prepare("SELECT COUNT(*) as total FROM forum_post WHERE userid = :userid");
        $query->bindParam(':userid', $userid);
		$query->execute();
        return $query->fetch(PDO::FETCH_ASSOC)['total'];
    }
    // Get Comments Count
    function getCommentsCount($postid){
        $query = $this->con->prepare("SELECT * FROM forum_comment WHERE postid = :postid");
        $query->bindParam(':postid', $postid);
        $query->execute();
        return $query->rowCount();
    }
    // Check Post/Comment Owner Imagr
    function getOwnerImage($userid){
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
}