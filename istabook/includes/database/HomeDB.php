<?php
class HomeDB extends Dbconnect {
	private $con;
	public function __construct(){
		$this->con = $this->connect();
	}

	/*************** Get Data ***************/
	/****************************************/

	// Get All Posts
	function getAllPosts($offset, $limit){
		$query = $this->con->prepare("SELECT * FROM post ORDER BY date DESC LIMIT :offset, :limit");
		$query->bindParam(':offset', $offset, PDO::PARAM_INT);
		$query->bindParam(':limit', $limit, PDO::PARAM_INT);
		$query->execute();
		return $query;
	}
	// Get Posts Count
	function getPostsCount(){
		$query = $this->con->query("SELECT COUNT(*) as total FROM post");
		return $query->fetch(PDO::FETCH_ASSOC)['total'];
	}
	function getCustomPost($postid){
		$query = $this->con->prepare("SELECT * FROM post WHERE postid = :postid");
		$query->bindParam(':postid', $postid);
		$query->execute();
		return $query;
	}
	// Check Post File Id In DB
	function checkFileIdExists($fileid){
		$query = $this->con->prepare("SELECT * FROM post_file WHERE fileid = :fileid");
		$query->bindParam(':fileid', $fileid);
		$query->execute();
		return $query->rowCount() == 0;
	}
	// Check Post Id In DB
	function checkPostIdExists($postid){
		$query = $this->con->prepare("SELECT * FROM post WHERE postid = :postid");
		$query->bindParam(':postid', $postid);
		$query->execute();
		return $query->rowCount() == 0;
	}
	// Get User Info
	function getPostOwnerInfo($userid){
		$query = $this->con->prepare("SELECT * FROM userinfo WHERE userid = :userid");
		$query->bindParam(':userid', $userid);
		$query->execute();
		return $query;
	}
	// Get Post Owner Id
	function getPostOwnerId($postid){
		$query = $this->con->prepare("SELECT * FROM post WHERE postid = :postid");
		$query->bindParam(':postid', $postid);
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC);
	}
	// Get Comment Post Id
	function getCommentPostOwnerId($commentid){
		$query = $this->con->prepare("SELECT * FROM post_comment WHERE commentid = :commentid");
		$query->bindParam(':commentid', $commentid);
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC);
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
	// Check Post Owner
	function checkPostOwner($userid, $postid){
		$query = $this->con->prepare("SELECT * FROM post WHERE userid = :userid AND postid = :postid");
		$query->bindParam(':userid', $userid);
		$query->bindParam(':postid', $postid);
		$query->execute();
		return $query->rowCount() > 0;
	}
	// Delete Post From Db
	function deletePost($postid){
		$query = $this->con->prepare("DELETE FROM post WHERE postid = :postid");
		$query->bindParam(':postid', $postid);
		return $query->execute();
	}
	// Get All Post Comments
	function getPostComments($postid){
		$query = $this->con->prepare("SELECT * FROM post_comment WHERE postid = :postid ORDER BY date DESC");
		$query->bindParam(':postid', $postid);
		$query->execute();
		return $query;
	}
	// Get Comment Owner Info
	function getCommentOwnerInfo($userid){
		$query = $this->con->prepare("SELECT * FROM userinfo WHERE userid = :userid");
		$query->bindParam(':userid', $userid);
		$query->execute();
		return $query;
	}
	// Get Comment Owner Info
	function getLikeOwnerInfo($userid){
		$query = $this->con->prepare("SELECT * FROM userinfo WHERE userid = :userid");
		$query->bindParam(':userid', $userid);
		$query->execute();
		return $query;
	}
	// Check Comment Liked
	function checkCommentLikedBy($userid, $commentid){
		$query = $this->con->prepare("SELECT * FROM comment_like WHERE userid = :userid AND commentid = :commentid");
		$query->bindParam(':userid', $userid);
		$query->bindParam(':commentid', $commentid);
		$query->execute();
		return $query->rowCount();
	}
	// Delete Comment From Db
	function deleteComment($commentid){
		$query = $this->con->prepare("DELETE FROM post_comment WHERE commentid = :commentid");
		$query->bindParam(':commentid', $commentid);
		return $query->execute();
	}
	// Get Comment Number Of Likes
	function getCommentLikesNumber($commentid){
		$query = $this->con->prepare("SELECT * FROM comment_like WHERE commentid = :commentid");
		$query->bindParam(':commentid', $commentid);
		$query->execute();
		return $query->rowCount();
	}
	// Check Comment Id In DB
	function checkCommentIdExists($commentid){
		$query = $this->con->prepare("SELECT * FROM post_comment WHERE commentid = :commentid");
		$query->bindParam(':commentid', $commentid);
		$query->execute();
		return $query->rowCount() == 0;
	}
	// Check Like Id In DB
	function checkCommentLikeIdExists($likeid){
		$query = $this->con->prepare("SELECT * FROM comment_like WHERE likeid = :likeid");
		$query->bindParam(':likeid', $likeid);
		$query->execute();
		return $query->rowCount() == 0;
	}
	// Check Like Id In DB
	function checkLikeIdExists($likeid){
		$query = $this->con->prepare("SELECT * FROM post_like WHERE likeid = :likeid");
		$query->bindParam(':likeid', $likeid);
		$query->execute();
		return $query->rowCount() == 0;
	}
	// Get Post Likes Infos
	function getPostLikes($postid){
		$query = $this->con->prepare("SELECT * FROM post_like WHERE postid = :postid ORDER BY date DESC");
		$query->bindParam(':postid', $postid);
		$query->execute();
		return $query;
	}
	// Get Post Likes Infos
	function getCommentLikes($commentid){
		$query = $this->con->prepare("SELECT * FROM comment_like WHERE commentid = :commentid ORDER BY date DESC");
		$query->bindParam(':commentid', $commentid);
		$query->execute();
		return $query;
	}
	/*************** Set Data ***************/
	/****************************************/

	// Insert Post Info And Content
	function insertPost($postid, $userid, $content, $date) {
		$query = $this->con->prepare("INSERT INTO post(postid,  userid, content, date) VALUES(:postid, :userid, :content, :date)");
		$query->bindParam(":postid", $postid);
		$query->bindParam(":userid", $userid);
		$query->bindParam(":content", $content);
		$query->bindParam(":date", $date);
		return $query->execute();
	}
	// Insert Post Video/Image
	function insertPostFile($fileid, $name, $type, $postid) {
		$query = $this->con->prepare("INSERT INTO post_file(fileid, name, type, postid) VALUES(:fileid, :name, :type, :postid)");
		$query->bindParam(":fileid", $fileid);
		$query->bindParam(":name", $name);
		$query->bindParam(":type", $type);
		$query->bindParam(":postid", $postid);
		return $query->execute();
	}
	// Insert Post Like
	function insertPostLike($likeid, $userid, $postid, $date, $type) {
		$query = $this->con->prepare("INSERT INTO post_like(likeid, userid, postid, date, type) VALUES(:likeid, :userid, :postid, :date, :type)");
		$query->bindParam(":likeid", $likeid);
		$query->bindParam(":userid", $userid);
		$query->bindParam(":postid", $postid);
		$query->bindParam(":date", $date);
		$query->bindParam(":type", $type);
		return $query->execute();
	}
	// Insert Comment Like
	function insertCommentLike($likeid, $userid, $commentid, $date, $type) {
		$query = $this->con->prepare("INSERT INTO comment_like(likeid, userid, commentid, date, type) VALUES(:likeid, :userid, :commentid, :date, :type)");
		$query->bindParam(":likeid", $likeid);
		$query->bindParam(":userid", $userid);
		$query->bindParam(":commentid", $commentid);
		$query->bindParam(":date", $date);
		$query->bindParam(":type", $type);
		return $query->execute();
	}
	// Remove Post Like
	function removePostLike($userid, $postid){
		$query = $this->con->prepare("DELETE FROM post_like WHERE userid = :userid AND postid = :postid");
		$query->bindParam(":userid", $userid);
		$query->bindParam(":postid", $postid);
		return $query->execute();
	}
	// Remove Comment Like
	function removeCommentLike($userid, $commentid){
		$query = $this->con->prepare("DELETE FROM comment_like WHERE userid = :userid AND commentid = :commentid");
		$query->bindParam(":userid", $userid);
		$query->bindParam(":commentid", $commentid);
		return $query->execute();
	}
	// Insert Comment
	function insertComment($commentid, $userid, $postid, $content, $date) {
		$query = $this->con->prepare("INSERT INTO post_comment(commentid, userid, postid, content, date) VALUES(:commentid, :userid, :postid, :content, :date)");
		$query->bindParam(":commentid", $commentid);
		$query->bindParam(":userid", $userid);
		$query->bindParam(":postid", $postid);
		$query->bindParam(":content", $content);
		$query->bindParam(":date", $date);
		return $query->execute();
	}

	// Close Db Connection
	function close(){
		$this->con = null;
	}

}