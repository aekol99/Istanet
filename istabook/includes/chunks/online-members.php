<!-- Start People Online -->
<div class="mt-3 fixed-bar ml-auto" style="width:fit-content">
    <b class="d-block mb-2">Online Members :</b>
    <?php 
        $onlineMembers = new OnlineMembers();
        $istanetModelTwo = new IstanetDB();
        $membersCount = $istanetModelTwo->getAllUsers($userid, 0, 25);
        $onlineMembers->desktopOnlineMembers('first8');

        if ($membersCount->rowCount() > 8) {
            echo '<span class="d-block text-right other-online-members-btn">See 6 others</span>';
        }

        if ($membersCount->rowCount() == 0) {
            echo 'No members found';
        }
    ?>
</div>
<!-- End People Online -->