<div class="online-members-firstMessage">
    <!-- Start Modal -->
    <div class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
        <form class="modal-content" action="actions/message.php" method="POST">
            <div class="modal-body">
                <p style="font-size:15px;">Send a message to <strong id="target-name">Alaaeddine</strong>.</p>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="message"></textarea>
                <input class="msgwithid" type="hidden" name="withid" value="">
                <input type="hidden" name="opType" value="new-conv">
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="submit" class="btn publish">
                <i class="fa fa-send"></i>	  
            Send</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </form>
        </div>
    </div>
    <!-- End Modal -->
</div>