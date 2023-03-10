<div class="create-conversation-modal">
    <!-- Start Modal -->
    <div class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
        <div class="modal-content rounded">
            <div class="modal-header">
            <h5 class="modal-title">New group chat</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <form>
            <div class="form-group">
                    <label for="exampleFormControlTextarea">Conversation name</label>
                    <input type="text" id="exampleFormControlTextarea" class="form-control new-conv-title">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Search</label>
                    <input type="text" id="exampleFormControlTextarea1" class="form-control new-conv-search">
                </div>
            </form>
            <div class="conv-person-search px-4 mb-2">
                Please type something
            </div>
            <div class="p-4 rounded conversation-selected-persons d-none">

            </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn publish create-conv-btn">Create</button>
            </div>
        </div>
        </div>
    </div>
    <!-- End Modal -->
</div>