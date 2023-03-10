<ul class="nav flex-lg-column my-3 justify-content-center">
    <li class="nav-item">
        <a class="nav-link <?php echo isActive($profileTab, "posts"); ?>" href="profile.php?<?php echo isset($_GET['uid']) ? 'uid=' . $_GET['uid'] . '&' : '' ?>ptab=posts">
        <i class="fa fa-image mr-1"></i>
        Posts</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo isActive($profileTab, "forum-posts"); ?>" href="profile.php?<?php echo isset($_GET['uid']) ? 'uid=' . $_GET['uid'] . '&' : '' ?>ptab=forum-posts">
            <i class="fa fa-archive mr-1"></i>
        Forum Posts</a>
    </li>
    <?php if($profileid != $userid){ 
        $profileModel = new ProfileDB();
        $convCheck = $profileModel->checkConversationWith($userid,$profileid);
        if ($convCheck->rowCount() > 0 ) {
            $convFetch = $convCheck->fetch(PDO::FETCH_ASSOC);
        }
    ?>
    <li class="nav-item">
        <a class="nav-link not-active<?php echo ($convCheck->rowCount() > 0) ? '' : ' message-btn'; ?>" href="<?php echo ($convCheck->rowCount() > 0) ? 'messages.php?roomid=' . $convFetch['conv_key'] : '#'; ?>">
        <i class="fa fa-send mr-1"></i>
        Message</a>
    </li>
    <?php } ?>
</ul>