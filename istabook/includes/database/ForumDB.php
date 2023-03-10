<?php
class ForumDB extends Dbconnect {
	private $con;
	public function __construct(){
		$this->con = $this->connect();
	}
    // Get Forum Posts
    function getForumPosts($offset, $limit){
        $query = $this->con->prepare("SELECT * FROM forum_post ORDER BY date DESC LIMIT :offset, :limit");
        $query->bindParam(':offset', $offset, PDO::PARAM_INT);
        $query->bindParam(':limit', $limit, PDO::PARAM_INT);
        $query->execute();
        return $query;
    }
    // Get Forum Posts Count
    function getForumPostsCount(){
        $query = $this->con->query("SELECT COUNT(*) as total FROM forum_post");
        return $query->fetch(PDO::FETCH_ASSOC)['total'];
    }
    //Insert Forum Post To Db
    function insertForumPost($postid, $title, $date, $userid){
        $query = $this->con->prepare("INSERT INTO forum_post(postid, title, date, userid) VALUES(:postid, :title, :date, :userid)");
        $query->bindParam(':postid', $postid);
        $query->bindParam(':title', $title);
        $query->bindParam(':date', $date);
        $query->bindParam(':userid', $userid);
        return $query->execute();
    }
    // Check Post Id Exists
    function checkPostIdExists($postid){
        $query = $this->con->prepare("SELECT * FROM forum_post WHERE postid = :postid");
        $query->bindParam(':postid', $postid);
        $query->execute();
        return $query->rowCount() == 0;
    }
    // Insert Forum Post Content
    function insertForumPostContent($type, $content_type, $content_order, $postid, $content){
        $query = $this->con->prepare("INSERT INTO forum_post_content(type, content_type, content_order, postid, content) VALUES(:type, :content_type, :content_order, :postid, :content)");
        $query->bindParam(':type', $type);
        $query->bindParam(':content_type', $content_type);
        $query->bindParam(':content_order', $content_order);
        $query->bindParam(':postid', $postid);
        $query->bindParam(':content', $content);
        return $query->execute();
    }
    // Insert Forum Post Attachement
    function insertForumPostAttachement($name, $src, $postid){
        $query = $this->con->prepare("INSERT INTO forum_post_attachement(name, src, postid) VALUES(:name, :src, :postid)");
        $query->bindParam(':name', $name);
        $query->bindParam(':src', $src);
        $query->bindParam(':postid', $postid);
        return $query->execute();
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
    // Delete Forum Post
    function deleteForumPost($postid){
        $query = $this->con->prepare("DELETE FROM forum_post WHERE postid = :postid");
        $query->bindParam(':postid', $postid);
        return $query->execute();
    }
    // Get Forum Post Content
    function getForumPostContent($postid){
        $query = $this->con->prepare("SELECT * FROM forum_post_content WHERE postid = :postid AND type = 'file'");
        $query->bindParam(':postid', $postid);
        $query->execute();
        return $query;
    }
    // Get Forum Post Content
    function getForumPostAttachement($postid){
        $query = $this->con->prepare("SELECT * FROM forum_post_Attachement WHERE postid = :postid");
        $query->bindParam(':postid', $postid);
        $query->execute();
        return $query;
    }
    // Check Content Id Exists
    function checkCommentIdExists($commentid){
        $query = $this->con->prepare("SELECT * FROM forum_comment WHERE commentid = :commentid");
        $query->bindParam(':commentid', $commentid);
        $query->execute();
        return $query->rowCount() == 0;
    }
    //Insert Forum Commment To Db
    function insertForumComment($commentid, $date, $userid, $postid){
        $query = $this->con->prepare("INSERT INTO forum_comment(commentid, date, userid, postid) VALUES(:commentid, :date, :userid, :postid)");
        $query->bindParam(':commentid', $commentid);
        $query->bindParam(':date', $date);
        $query->bindParam(':userid', $userid);
        $query->bindParam(':postid', $postid);
        return $query->execute();
    }
    // Insert Forum Comment Content
    function insertForumCommentContent($type, $content_type, $content_order, $commentid, $content){
        $query = $this->con->prepare("INSERT INTO forum_comment_content(type, content_type, content_order, commentid, content) VALUES(:type, :content_type, :content_order, :commentid, :content)");
        $query->bindParam(':type', $type);
        $query->bindParam(':content_type', $content_type);
        $query->bindParam(':content_order', $content_order);
        $query->bindParam(':commentid', $commentid);
        $query->bindParam(':content', $content);
        return $query->execute();
    }
    // Insert Forum Comment Attachement
    function insertForumCommentAttachement($name, $src, $commentid){
        $query = $this->con->prepare("INSERT INTO forum_comment_attachement(name, src, commentid) VALUES(:name, :src, :commentid)");
        $query->bindParam(':name', $name);
        $query->bindParam(':src', $src);
        $query->bindParam(':commentid', $commentid);
        return $query->execute();
    }
    // Get Forum Post Content
    function getForumPostContents($postid){
        $query = $this->con->prepare("SELECT type, content_type, content FROM forum_post_content WHERE postid = :postid ORDER BY content_order");
        $query->bindParam(':postid', $postid);
        $query->execute();
        return $query;
    }
    // Get Forum Post Infos
    function getForumPostInfos($postid){
        $query = $this->con->prepare("SELECT * FROM forum_post WHERE postid = :postid");
        $query->bindParam(':postid', $postid);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    // Get user Image
	function getUserImage($userid){
		$query = $this->con->prepare("SELECT * FROM userinfo WHERE userid = :userid");
        $query->bindParam(':userid', $userid);
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC)['image'];
	}
    // Get Forum Post Attachements
    function getForumPostAttachements($postid){
        $query = $this->con->prepare("SELECT name, src FROM forum_post_attachement WHERE postid = :postid");
        $query->bindParam(':postid', $postid);
        $query->execute();
        return $query;
    }
    // Get Forum Post COmments
    function getForumComments($postid){
        $query = $this->con->prepare("SELECT * FROM forum_comment WHERE postid = :postid ORDER BY date DESC");
        $query->bindParam(':postid', $postid);
        $query->execute();
        return $query;
    }
    // Get Forum Comment Content
    function getForumCommentContents($commentid){
        $query = $this->con->prepare("SELECT type, content_type, content FROM forum_comment_content WHERE commentid = :commentid ORDER BY content_order");
        $query->bindParam(':commentid', $commentid);
        $query->execute();
        return $query;
    }
    // Get Forum Comment Attachements
    function getForumCommentAttachements($commentid){
        $query = $this->con->prepare("SELECT name, src FROM forum_comment_attachement WHERE commentid = :commentid");
        $query->bindParam(':commentid', $commentid);
        $query->execute();
        return $query;
    }
    // Delete Forum Comment
    function deleteForumComment($commentid){
        $query = $this->con->prepare("DELETE FROM forum_comment WHERE commentid = :commentid");
        $query->bindParam(':commentid', $commentid);
        return $query->execute();
    }
}