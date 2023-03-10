$(document).ready(function(){
"use strict";

/* Start Actions Constants */
const ACTIONS = 'actions/';
const POST_ACTION = ACTIONS + 'post.php';
const FORUM_ACTION = ACTIONS + 'forum.php';
const MESSAGE_ACTION = ACTIONS + 'message.php';
const ONLINE_ACTION = ACTIONS + 'online.php';
const NUMBERS = ACTIONS + 'numbers.php';
const MORE_ACTION = ACTIONS + 'more.php';
/* End Actions Constants */

/* Start Min Posts Container Height */
var winHeight = $(window).height(),
headerHeight = $("header").height(),
footerHeight = $("footer").height(),
minHight = winHeight - (headerHeight + footerHeight);
$(".posts, .profile-content, .search, .chat-rooms, .inside-chat-room").css("min-height",minHight);
/* End Min Posts Container Height */

/* Start Fixed Bar On Scroll */
var	tabsOffset = $('.bar-tabs').offset().top;
var scrollTop = $(this).scrollTop();
$(".bar-tabs-scrollfix").height($('.bar-tabs').height());
$(window).on("scroll", function(){
	scrollTop = $(this).scrollTop();
	fixedBar(scrollTop,tabsOffset);
});

function fixedBar(_scrollTop,_tabsOffset){
	if (_scrollTop >= _tabsOffset) {
		$('.bar-tabs').addClass("out-scroll");
		$(".bar-tabs-scrollfix").removeClass("d-none");
		$(".bar-tabs-scrollfix").addClass("d-block")
	} else {
		$('.bar-tabs').removeClass("out-scroll");
		$(".bar-tabs-scrollfix").removeClass("d-block");
		$(".bar-tabs-scrollfix").addClass("d-none")
	}
}
fixedBar(scrollTop,tabsOffset);
/* End Fixed Bar On Scroll */

/* Start View More Images */
$(".messages-container").on("click", ".message-image",function(){
	var images = $(this).parent().find("img").clone();
	$(".view-images .modal-body").empty();
	for (var i = 0; i < images.length; i++) {
		let image = images[i];
		image.removeAttribute('width');
		$(".view-images .modal-body").append(image);
	}
	$(".view-images .modal-body img").addClass("my-1 w-100");
	$(".view-images .modal").modal("show");
});
/* End View More Images */

/* Start Comments Modal */
var commentsModalOpened = false;
$(".row").on("click", ".comments-btn", function(e){
	commentsModalOpened = true;
	let postid = this.dataset.postid;
	//console.log(postid1);
	$('.comments-modal .insert-comment').attr('data-postid', postid);

	$.ajax({
		url: `${POST_ACTION}?opType=getComments&postid=${postid}`,
		method : 'GET',
		cache : false,
		success : (data,status) => {
			$(".comments-modal .modal .modal-body").html(data);
		}
	});
	$(".comments-modal .modal").modal("show");
});
/* End Comments Modal */

/* Start New Post Modal */
$(".new-post-btn").on("click", function(){
	$(".new-post-modal .modal").modal("show");
});
/* End New Post Modal */

/* Start Create Conversation Group Modal */
$(".new-conversation-btn").on("click", function(){
	$(".create-conversation-modal .modal").modal("show");
});
/* End Create Conversation Group Modal */

/* Start First Message Modal */
$(".message-btn").on("click", function(event){
	event.preventDefault();
	$(".firstMessage .modal").modal("show");
});
/* End First Message Modal */

/* Start Online Members First Message Modal */
$(".send-message-btn").on("click", function(event){
	event.preventDefault();
	let name = $(this).find("span").text().trim();
	$("#target-name").text(name);
	$(".online-members-firstMessage .modal").modal("show");
	$(".other-online-members-modal .modal").css('z-index','1');
});
$(".online-members-firstMessage .modal").on("hidden.bs.modal", function () {
	if (otherOnlineMembersOpened) {
		$("body").addClass("modal-open");
	}
	$(".other-online-members-modal .modal").css('z-index','1050')
});
$(".other-online-members-modal .modal").on("hidden.bs.modal", function () {
	$("body").removeClass("modal-open");
	otherOnlineMembersOpened = false;
	console.log(otherOnlineMembersOpened);
});
/* End Online Members First Message Modal */

/* Start Mobile Online Members Modal */
$(".online-members-btn").on("click", function(){
	$(".online-members-modal .modal").modal("show");
});
/* End Mobile Online Members Modal */
var otherOnlineMembersOpened = false;
/* Start Other Online Members Modal */
$(".other-online-members-btn").on("click", function(){
	otherOnlineMembersOpened = true;
	$(".other-online-members-modal .modal").modal("show");
});
/* End Other Online Members Modal */

/* Start Post Liked By Modal */
var postLikedById;
$(".row").on("click", ".likedby", function(){
	postLikedById = this.dataset.id;
	$.ajax({
		method: 'GET',
		url: `${POST_ACTION}?opType=getPostLikedBy&postid=${postLikedById}`,
		cache: false,
		success: (data, status) => {
			$(".likedby-modal .modal .modal-body").html(data);
		}
	});
	$(".likedby-modal .modal").modal("show");
});
/* End Post Liked By Modal */

/* Start Comment Liked By Modal */
$(".comments-modal").on("click", ".comment-likedby", function(){
	var commentid = this.dataset.id;
	$.ajax({
		method: 'GET',
		url: `${POST_ACTION}?opType=getCommentsLikedBy&commentid=${commentid}`,
		cache: false,
		success: (data,status) => {
			$(".likedby-modal .modal .modal-body").html(data);
		}
	});
	$(".comments-modal .modal").css("z-index", '1');
	$(".likedby-modal .modal").modal("show");
});
$(".likedby-modal .modal").on("hidden.bs.modal", function () {
	if (commentsModalOpened) {
		$("body").addClass("modal-open");
	}
	$(".comments-modal .modal").css('z-index','1050')
});
$(".comments-modal .modal").on("hidden.bs.modal", function () {
	commentsModalOpened = false;
	$("body").removeClass("modal-open");
});
/* End Comment Liked By Modal */

/* Start New Forum Post Modal */
// Show The Modal On Click
$(".new-forum-post-btn").on("click", function(){
	$(".new-forum-post .modal").modal("show");
});
// Add/Append Code Text Textareas
$(".new-forum-post .text-code-actions .text").on("click", function(){
	$(".new-forum-post .modal .modal-body .objects").append(textObject);
});

$(".new-forum-post .text-code-actions .code").on("click", function(){
	$(".new-forum-post .modal .modal-body .objects").append(codeObject);
});
// Remove Textarea On Click X
$(".new-forum-post .modal .modal-body .objects").on("click", ".removeob", function(){
	$(this).parent().remove();
});
// Submit The Modal On Click
$(".new-forum-post .modal .modal-footer .publish").on("click", function(){
	$(".new-forum-post .modal .modal-body .objects").submit();
});
/* End New Forum Post Modal */

/* Start Forum Comment Modal */
// Show The Modal On Click
$(".forum-comment-btn").on("click", function(){
	$(".forum-post-comment .modal").modal("show");
});
// Remove Textarea On Click X
$(".forum-post-comment .modal .modal-body .objects").on("click", ".removeob", function(){
	$(this).parent().remove();
});
// Submit The Modal On Click
$(".forum-post-comment .modal .modal-footer .publish").on("click", function(){
	$(".forum-post-comment .modal .modal-body .objects").submit();
});


// Append Textareas Section 
$(".text-code-actions .appElm").on("click", function(){
	// Append Text Section
	if ($(this).hasClass('text-paragraph')) {
		var tAreaName = "text-paragraph",
		tAreaPlaceholder ="plain text ...",
		bagdeName = "Plain text";
	}
	if ($(this).hasClass('text-header')) {
		var tAreaName = "text-header",
		tAreaPlaceholder ="text header ...",
		bagdeName = "Header";
	}
	if ($(this).hasClass('text-quote')) {
		var tAreaName = "text-quote",
		tAreaPlaceholder ="text quote ...",
		bagdeName = "Quote";
	}
	// Append Code Section 
	if ($(this).hasClass('code-html')) {
		var tAreaName = "language-html",
		tAreaPlaceholder ="html code ...",
		bagdeName = "Html";
	}
	if($(this).hasClass('code-css')){
		var tAreaName = "language-css",
		tAreaPlaceholder ="css code ...",
		bagdeName = "Css";
	}
	if($(this).hasClass('code-javascript')){
		var tAreaName = "language-javascript",
		tAreaPlaceholder ="javascript code ...",
		bagdeName = "Javascript";
	}
	if($(this).hasClass('code-python')){
		var tAreaName = "language-python",
		tAreaPlaceholder ="python code ...",
		bagdeName = "Python";
	}
	if($(this).hasClass('code-sql')){
		var tAreaName = "language-sql",
		tAreaPlaceholder ="sql code ...",
		bagdeName = "Sql";
	}
	if($(this).hasClass('code-php')){
		var tAreaName = "language-php",
		tAreaPlaceholder ="php code ...",
		bagdeName = "Php";
	}
	// Building Final Object To Append
	let finalObject = "<div class='code-object d-flex mb-3'><span class='lang-badge'>"+bagdeName+"</span><i class='fa fa-remove mr-2 removeob'></i><textarea class='form-control' name='inputtextcode[]' placeholder='"+tAreaPlaceholder+"'"+"></textarea><input type='hidden' name='inputtype[]' value='"+tAreaName+"'></div>";
	// Append The Final Object
	$(".forum-post-comment .modal .modal-body .objects").append(finalObject);
	$(".new-forum-post .modal .modal-body .objects").append(finalObject);
});
/* End Forum Comment Modal */

/* Start Create Forum Post Submit */
$('.forum-post-submit-btn').on('click', function(){
	$('.new-forum-post form').submit();
});
/* End Create Forum Post Submit */

/* Start Create Forum Comment Submit */
$('.forum-comment-submit-btn').on('click', function(){
	$('.forum-post-comment form').submit();
});
/* End Create Forum Comment Submit */

/* Start See More Comment Text */
$("#see_more").on("click", function(e){
	e.preventDefault();
	console.log(this.dataset.commentid);
	// Ajax Code Here
});
/* End See More Comment Text */

/* Start Post Like Button Toggle */
$(".row").on("click", ".like-comment .like", function(){
	var likesCountHolder = $(this).children("span");
	var	icon = $(this).children("i");
	var	postLikesCount = Number(likesCountHolder.text());
	var likedByPersons = $(this).parent().siblings(".likedby");


	var postid = this.dataset.postid;

	if (postLikesCount == 0) {
			$(this).addClass("liked");
			icon.removeClass("fa-thumbs-o-up");
			icon.addClass("fa-thumbs-up");
			likesCountHolder.text(1);
			likedByPersons.html('<i class="fa fa-thumbs-o-up mr-1"></i>you <span class="d-none">1</span>');
			// Insert Like Into Database
			insertLikeAjax(postid);
	}else if(postLikesCount == 1){
		if($(this).hasClass("liked")){
			$(this).removeClass("liked");
			icon.removeClass("fa-thumbs-up");
			icon.addClass("fa-thumbs-o-up");
			likesCountHolder.text("");
			likedByPersons.empty();
			// Remove Like From Database
			removeLikeAjax(postid);
		}else{
			$(this).addClass("liked");
			icon.removeClass("fa-thumbs-o-up");
			icon.addClass("fa-thumbs-up");
			likesCountHolder.text(postLikesCount + 1);
			likedByPersons.html('<i class="fa fa-thumbs-o-up mr-1"></i>you and <span>1</span> other');
			// Insert Like Into Database
			insertLikeAjax(postid);
		}
	}else{
		if($(this).hasClass("liked")){
			$(this).removeClass("liked");
			icon.removeClass("fa-thumbs-up");
			icon.addClass("fa-thumbs-o-up");
			likesCountHolder.text(postLikesCount - 1);
			likedByPersons.html('<i class="fa fa-thumbs-o-up mr-1"></i><span>' + (postLikesCount - 1) +'</span>');
			// Remove Like From Database
			removeLikeAjax(postid);
		}else{
			$(this).addClass("liked");
			icon.removeClass("fa-thumbs-o-up");
			icon.addClass("fa-thumbs-up");
			likesCountHolder.text(postLikesCount + 1);
			likedByPersons.html('<i class="fa fa-thumbs-o-up mr-1"></i>you and <span> '+ postLikesCount +' </span> others');
			// Insert Like Into Database
			insertLikeAjax(postid);
		}
	}
});
// Insert Like Ajax
function insertLikeAjax(_postid) {
	$.ajax({
		method: 'POST',
		url: POST_ACTION,
		data: {opType: 'insertLike', postid: _postid},
		cache: false,
		success: (data, status) => {
			console.log(data);
			console.log(status);
		}
	});
}
// Remove Like Ajax
function removeLikeAjax(_postid) {
	$.ajax({
		method: 'POST',
		url: POST_ACTION,
		data: {opType: 'removeLike', postid: _postid},
		cache: false,
	});
}
/* End Post Like Button Toggle */ 

/* Start Comment Like Button Toggle */
$(".comments-modal").on("click", ".like-comment-btn", function(e){
	e.preventDefault();
	var cLikesContainer = $(this).siblings(".comment-likedby");
	var cLikesText = cLikesContainer.children("span");
	var	cLikesCount = parseInt(cLikesText.text());
	
	var commentid = this.dataset.id;

	if (cLikesText.length == 0) {
		$(this).addClass("liked");
		cLikesContainer.html("<i class='fa fa-thumbs-o-up'></i>" +  "<span class='ml-1'>1</span>");
		// Insert Like Into Database
		insertCommentLikeAjax(commentid);
	} else if (Number(cLikesText.text()) == 1){
		if($(this).hasClass("liked")){
			$(this).removeClass("liked");
			cLikesContainer.empty();
			// Remove Like From Database
			removeCommentLikeAjax(commentid);
		}else{
			$(this).addClass("liked");
			cLikesContainer.html("<i class='fa fa-thumbs-o-up'></i>" +  "<span class='ml-1'>2</span>");
			// Insert Like Into Database
			insertCommentLikeAjax(commentid);
		}
	} else {
		if($(this).hasClass("liked")){
			$(this).removeClass("liked");
			cLikesText.text(cLikesCount - 1);
			// Remove Like From Database
			removeCommentLikeAjax(commentid);
			
		}else{
			$(this).addClass("liked");
			cLikesText.text(cLikesCount + 1);
			// Insert Like Into Database
			insertCommentLikeAjax(commentid);
		}
	}
});
// Insert Comment Like Ajax
function insertCommentLikeAjax(_commentid) {
	$.ajax({
		method: 'POST',
		url: POST_ACTION,
		data: {opType: 'insertCommentLike', commentid: _commentid},
		cache: false,
		success: (data, status) => {
			console.log(data);
			console.log(status);
		}
	});
}
// Remove Comment Like Ajax
function removeCommentLikeAjax(_commentid) {
	$.ajax({
		method: 'POST',
		url: POST_ACTION,
		data: {opType: 'removeCommentLike', commentid: _commentid},
		cache: false
	});
}
/* End Comment Like Button Toggle */ 

/* Start Show New Post On Scroll */
var offset = 10;
$(".row").on('click', "#see-more", (e) => {
	let initialCount = e.target.dataset.initialcount;
	let loading_icon = $("#see-more i");
	loading_icon.removeClass("d-none").addClass("loading_posts");
	let seeMoreParent = $("#see-more").parent();
	// Getting posts from the database
	let already_seen = 0;
	let dataToSend = {dataTarget: PAGE, offset: offset};
	if (PROFILEID.length > 0) {
		dataToSend = {...dataToSend, profileid: PROFILEID};
	}
	if (PROFILE_TARGET.length > 0) {
		dataToSend = {...dataToSend, profiletarget: PROFILE_TARGET};
	}
	if (ROOMID.length > 0) {
		dataToSend = {...dataToSend, roomid: ROOMID};
	}
	if (SEARCH_KEYWORD.length > 0) {
		dataToSend = {...dataToSend, keyword: SEARCH_KEYWORD};
	}
	if (SEARCH_TARGET.length > 0) {
		dataToSend = {...dataToSend, starget: SEARCH_TARGET};
	}
	if (initialCount != 'undefined') {
		dataToSend = {...dataToSend, initialcount: initialCount};
	}
	$.ajax({
		url: MORE_ACTION,
		method: 'POST',
		data: dataToSend,
		cache: false,
		success: (data, status) => {
			
			if (PAGE == 'messages') {
				$("#see-more").after(data);
			}else{
				seeMoreParent.append(data);
				offset += 10;
			}
			$("#see-more").remove();
		}
	});
});
/* End Show New Post On Scroll */

/* Start Delete Posts/Commenst Modal */
//Delete Posts
var target, targetid, targetContainer;
$(".row").on("click", ".deletePostCommentBtn", function (e) {
	e.preventDefault()
	target = this.dataset.target;
	targetid = this.dataset.id;
	targetContainer = $(this).parents('.card');
	$(".deletePostComment .modal").modal("show");
});
//Delete Comments
$(".comments-modal").on("click", ".remove-comment", function (event) {
	event.preventDefault();
	target = this.dataset.target;
	targetid = this.dataset.id;
	targetContainer = $(this).parents('.media');
	$(".deletePostComment .modal").modal("show");
	$(".comments-modal .modal").css('z-index','1')
});

$(".deletePostComment .modal").on("hidden.bs.modal", function () {
	$(".comments-modal .modal").css('z-index','1050')
	if (commentsModalOpened) {
		$("body").addClass("modal-open");
	}
});

$(".comments-modal .modal").on("hidden.bs.modal", function () {
	$("body").removeClass("modal-open");
});
/* End Delete Posts/Commenst Modal */

/* Start Delete Target Button */
$(".delete-target-btn").click(function(e){
	e.preventDefault();
	if (target == 'post') {
		var dataToSend = {postid: targetid, opType: 'delete'};
		var targetUrl = POST_ACTION;
	}
	if (target == 'comment') {
		var dataToSend = {commentid: targetid, opType: 'deletecomment'};
		var targetUrl = POST_ACTION;
	}
	if (target == 'forum-post') {
		var dataToSend = {forumpostid: targetid, opType: 'deleteforumpost'};
		var targetUrl = FORUM_ACTION;
	}
	if (target == 'forum-comment') {
		var dataToSend = {forumcommentid: targetid, opType: 'deleteforumcomment'};
		var targetUrl = FORUM_ACTION;
	}

	$.ajax({
		method: 'POST',
		url: targetUrl,
		data : dataToSend,
		cache: false,
		success: (data, status) => {
			$(".deletePostComment .modal").modal("hide");
			targetContainer.remove();
			console.log(status);
			console.log(data);
		}
	});
});
/* End Delete Target Button */

/* Start Upload Images Button */
$(".upload-image-btn").click(function(){
	$("#images-input").click();
});
/* End Upload Images Button */


/* Start Submit New Post */
$(".submit-new-post").click(function(){
	$(".new-post-form").submit();
});
/* End Submit New Post */

/* Start Insert Commment */
$('.insert-comment').on('submit',function(e){
	e.preventDefault();
	let contentInput = $(this).find('.comment-content');
	let content = contentInput.val();
	var postId = this.dataset.postid;
	contentInput.val('');
	if(content.length > 0){
		$.ajax({
			method: 'POST',
			url: POST_ACTION,
			data: {postid: postId,content: content, opType: 'insertComment'},
			cache: false,
			success: (data, status) => {
				//console.log(data);
				///console.log(status);
				console.log($(this));
				console.log(postId);
				if($(this).next().find('.no-comment').length == 0){
					$(this).next().prepend(data);
				}else{
					$(this).next().html(data);
				}
			}
		});
	}
});
/* End Insert Commment */

/* Start Delete New Conversation Person */
$(".conversation-selected-persons").on('click', '.del-person', function(){
	let id = this.parentElement.dataset.id;
	selectedPersons.splice(selectedPersons.indexOf(id),1);
	$(this).parents('.conv-person-selected').remove();
	if (selectedPersons.length == 0) {
		$('.conversation-selected-persons').addClass('d-none');
	}
});
/* End Delete New Conversation Person */

/* Start Select Person From Search Results */
var selectedPersons = [];
$('.conv-person-search').on('click', '.conv-person', function(){
	let id = this.dataset.id;
	if (!selectedPersons.includes(id)) {
		let selectedPerson = $(this).clone();
		selectedPerson.removeClass('conv-person');
		selectedPerson.addClass('conv-person-selected')
		selectedPerson.append("<i class='fa fa-remove ml-auto del-person'></i>");
		$('.conversation-selected-persons').append(selectedPerson);

		if (selectedPersons.length == 0) {
			$('.conversation-selected-persons').removeClass('d-none');
		}

		selectedPersons.push(id);
	}
});
/* End Select Person From Search Results */

/* Start Search Persons */
$('.new-conv-search').on('input', function(){
	if ($(this).val().length != 0) {
		$.ajax({
			url: MESSAGE_ACTION + `?opType=new-conv-search&name=${$(this).val()}`,
			method: 'GET',
			cache: false,
			success: (data, status) => {
				$('.conv-person-search').html(data);
			}
		});
	}else{
		$('.conv-person-search').html("Please type something");
	}
})
/* End Search Persons */

/* Start Create New Conversatio */
$('.create-conv-btn').on('click', function(){
	let convTitle = $('.new-conv-title').val();
	if (selectedPersons.length > 0 && convTitle.length > 0) {
		$.ajax({
			url: MESSAGE_ACTION,
			method: 'POST',
			data: {opType: 'create-new-conv', title: convTitle, persons: selectedPersons.join('.')},
			cache: false,
			success: (data, status) => {
				window.location.replace(`messages.php?roomid=${data}`);
			}
		});
	}
});
/* End Create New Conversatio */

/* Start New Messgae Form Submit */
$('.send-conv-msg-btn').on('click', function(){
	$('.send-msg-form').submit();
});
/* End New Messgae Form Submit */

/* Start Send Message */
$('.send-msg-form').on('submit', function(e){
	e.preventDefault();
	$.ajax({
		url : MESSAGE_ACTION,
		data : new FormData(this),
		type : 'POST',
		cache: false,
		processData: false,
		contentType: false,
		success : (data, status) => {
			this.reset();
			if (data.length > 0) {
				getInsertedMessageInfos(data);
			}
		}
	});
});
/* End Send Message */

/* Start Get Inserted Message Infos */
function getInsertedMessageInfos(messageid){
	$.ajax({
		url : MESSAGE_ACTION + `?opType=inserted-message-infos&messageid=${messageid}`,
		method : 'GET',
		cache: false,
		success : (data, status) => {
			$('.send-msg-form').before(data);
			window.scrollTo(0, document.body.scrollHeight);
		}
	});
}
/* End Get Realtime Message Infos */

/* Start Instant Messages */
if (PAGE == 'messages' && ROOMID.length > 0) {
	var interval = setInterval(convRealtimeMessages, 2000);
}
function convRealtimeMessages(convid) {
	$.ajax({
		url : MESSAGE_ACTION + `?opType=realtime-messages&roomid=${ROOMID}`,
		type : 'GET',
		cache: false,
		success : (data, status) => {
			if (data.length != 0) {
				console.log(data);
				$('.send-msg-form').before(data);
				window.scrollTo(0, document.body.scrollHeight);
			}else{
				console.log('nothing found');
			}
		}
	});
}
/* End Realtime Messages */

/* Start Update Last Impression */
setInterval(updateLastImpression, 10000);
function updateLastImpression(){
	$.ajax({
		url: ONLINE_ACTION,
		method: 'POST',
		data: {opType: 'update-last-impression'},
		cache: false
	});
}
/* End Update Last Impression */

/* Start Update Online Members */
var onlineMembers = Array.from(document.getElementsByClassName('online-member'));
setInterval(updateOnlineMembers, 15000);
function updateOnlineMembers(){
	onlineMembers.forEach((member)=>{
		let onlineIcon = member.firstElementChild.lastElementChild;
		$.ajax({
			url: ONLINE_ACTION,
			method: 'POST',
			data: {opType: 'update-online-members', userid: member.dataset.id},
			cache: false,
			success: (data, status) => {
				if (Number(data) < 15) {
					onlineIcon.classList.remove('d-none');
				}else{
					onlineIcon.classList.add('d-none');
				}
			}
		});
	});
}
/* End Update Online Members */

/* Start Online Members First Message */
$(".online-member").on("click", function(){
	let memberId = this.dataset.id;
	$(".online-members-firstMessage .msgwithid").attr('value', memberId);
});
/* End Online Members First Message */

/* Start Get Header Alert Numbers */
setInterval(getAlertNumbers, 7000);
var alertContainers = Array.from(document.getElementsByClassName('notification-number'));
function getAlertNumbers(){
	$.ajax({
		url: NUMBERS,
		method: 'POST',
		cache: false,
		data: {opType: 'get-numbers'},
		success: (data, status) => {
			let numbersSplit = data.split('.');
			numbersSplit.forEach((val, index) => {
				if (val == 0) {
					alertContainers[index].classList.add('d-none');
				}else{
					alertContainers[index].classList.remove('d-none');
					alertContainers[index].innerText = numbersSplit[index];
				}
			});
		}
	});
}
/* End Get Header Alert Numbers */

/* Start Video Fullscreen */
	var expandBtn = document.getElementsByClassName('videoexpand')[0];
	expandBtn.addEventListener('click', function(){
		var video = this.previousElementSibling;
		if (video.requestFullscreen) {
			video.requestFullscreen();
		}else if (video.mozRequestFullscreen){
			video.mozRequestFullscreen();
		}else if (video.webkitRequestFullscreen){
			video.webkitRequestFullscreen();
		}else if (video.msRequestFullscreen){
			video.msRequestFullscreen();
		}
	});
/* End Video Fullscreen */

});