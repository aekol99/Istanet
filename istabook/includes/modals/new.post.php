<div class="new-post-modal">
    <!-- Start Modal -->
    <div class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
        <div class="modal-content rounded">
            <div class="modal-header">
            <h5 class="modal-title">New Post</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <form action="actions/post.php" method="post" class="new-post-form" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">What's in your mind?</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="content"></textarea>
                </div>
                <div class="form-group">
                    <input type="file" class="form-control-file" id="exampleFormControlFile1" name="file">
                </div>
                <input type="hidden" name="opType" value="insert">
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn publish submit-new-post">Publish</button>
            </div>
        </div>
        </div>
    </div>
    <!-- End Modal -->
</div>