<!-- Start Forum Comment Modal -->
<div class="forum-post-comment">
	<!-- Start Modal -->
	<div class="modal fade" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
	  <div class="modal-dialog modal-xl" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Forum Post Comment</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form class="modal-body" action="actions/forum.php" method="POST" enctype="multipart/form-data">

		  <div class="objects">

          </div>

	        <div class="text-code-actions text-center mb-4">
				<i class="appElm text-paragraph fa fa-paragraph p-2 btn btn-secondary" title="Paragraph"></i>
				<i class="appElm text-header fa fa-header p-2 code-btn btn btn-secondary" title="Heading"></i>
	        	<i class="appElm text-quote fa fa-quote-right p-2 code-btn btn btn-secondary" title="Quote"></i>
				<ul class="code-lang mt-2 mb-0 list-unstyled d-flex justify-content-center">
					<li class="appElm code-html btn btn-outline-secondary px-1 py-0 mr-1"><b>Html</b></li>
					<li class="appElm code-css btn btn-outline-secondary px-1 py-0 mr-1"><b>Css</b></li>
					<li class="appElm code-javascript btn btn-outline-secondary px-1 py-0 mr-1"><b>Javascript</b></li>
					<li class="appElm code-python btn btn-outline-secondary px-1 py-0 mr-1"><b>Python</b></li>
					<li class="appElm code-sql btn btn-outline-secondary px-1 py-0 mr-1"><b>Sql</b></li>
					<li class="appElm code-php btn btn-outline-secondary px-1 py-0 mr-1"><b>Php</b></li>
					
				</ul>	
	        </div>
			<input type="file" name="attachements[]" multiple>            
			<input type="hidden" name="opType" value="forum-comment-insert"> 
			<input type="hidden" name="postid" value="<?php echo $_GET['fpostid']; ?>"> 
          </form>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="button" class="btn publish forum-comment-submit-btn">Publish</button>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- End Modal -->
</div>
<!-- End Forum Comment Modal -->