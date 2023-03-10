<div class="online-members-modal">
    <!-- Start Modal -->
    <div class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
        <div class="modal-content rounded">
            <div class="modal-header">
            <h5 class="modal-title">People Online</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <?php 
                    $onlineMembers = new OnlineMembers();
                    $istanetModelTwo = new IstanetDB();
                    $membersCount = $istanetModelTwo->getAllUsers($userid, 0, 25);
                    $onlineMembers->desktopOnlineMembers('first8');
                    $onlineMembers->desktopOnlineMembers('others');
                ?>
                
            </div>
        </div>
        </div>
    </div>
    <!-- End Modal -->
</div>