<div class="other-online-members-modal">
    <!-- Start Modal -->
    <div class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document" style="width: 23%;">
            <div class="modal-content rounded">
                <div class="modal-body">
                    <?php 
                    $onlineMembers = new OnlineMembers();
                    $istanetModelTwo = new IstanetDB();
                    $membersCount = $istanetModelTwo->getAllUsers($userid, 0, 25);
                    $onlineMembers->desktopOnlineMembers('others');
                    ?>  
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->
</div>