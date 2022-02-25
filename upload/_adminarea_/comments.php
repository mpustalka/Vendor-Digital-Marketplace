<?php 
require_once('header.php');
?>
<main class="page-content">
	<div class="container-fluid">
      	<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="row">
		   			<div class="col-md-12 col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="page-heading d-inline"><h5 class="text-left">Manage Comments
									</h5><small class="text-success">(Click on Pencil Icon to add reply to comments.)</small>
								</div>
								<hr>
								
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="row">
									<div class="col-md-12">
									  <div class="tile">
										<div class="tile-body">
											<div class="table-responsive">
												<table class="table table-bordered table-hover" id="manageCommentTable">
													<thead>
														<tr>
															<th>S.No.</th>
															<th>Comment ID</th>	
															<th>Date</th>
															<th>User ID</th>
															<th>User Name</th>
															<th>User Email</th>
															<th>Item ID</th>
															<th>Item Name</th>
															<th>View Item</th>					
															<th>Comment</th>
															<th>Purchased Status</th>
															<th>Admin Reply</th>
															<th>Status</th>
															<th><i class="fa fa-pencil-alt"></i></th>
															<th><i class="fa fa-ban"></i></th>
														</tr>
													</thead>
												</table><!-- /table -->
											</div>
										</div>
									</div>
								</div>
							</div>
							</div> <!-- /panel-body -->
					</div> <!-- /panel -->	
					</div>
				</div>
			</div>
		</div>
	</div>
</main><!-- page-content" -->
<!-- Add Comment Modal -->
	<div id="commentModal" class="modal fade" data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog modal-xl">
    		<form method="post" id="comment_form">
    			<div class="modal-content">
    				<div class="modal-header">
						<h4 class="modal-title"><i class="fa fa-comment"></i> Edit Comment</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
    				</div>
    				<div class="modal-body">
						<div class="row">
						<div class="form-group col-md-4 my-1">
							<label>Comment Date*</label>
							<input type="text" class="form-control comment_date" id="comment_date" name="comment_date" placeholder="Comment Date*" autocomplete="off" required>
						</div>
						<div class="form-group col-md-4 my-1">
							<label>User Fullname*</label>
							<input type="text" class="form-control comment_name" id="comment_name" name="comment_name" placeholder="User Fullname*" autocomplete="off" readonly="readonly">
						</div>
						<div class="form-group col-md-4 my-1">
							<label>User Email*</label>
							<input type="email" class="form-control comment_email" id="comment_email" name="comment_email" placeholder="User Email*" autocomplete="off" readonly="readonly">
						</div>
						
						<div class="form-group col-md-12">
							<label>Comment*</label>
							<textarea placeholder="Comment*" rows="4" class="form-control" id="commentText" name="commentText" required ></textarea>
						</div>
						<div class="form-group col-md-12">
							<label>Admin Reply (Optional)</label>
							<textarea placeholder="Admin Reply" rows="4" class="new_txtarea form-control" id="replyText" name="replyText" ></textarea>
						</div>  
						</div>
    				</div> 
    				<div class="modal-footer">
						<input type="hidden" name="itemId" class="itemId" > 
						<input type="hidden" name="comment_id" id="comment_id"/>
						<input type="hidden" name="btn_action" id="btn_action" />
    					<input type="submit" name="action" id="action" class="btn btn-info" value="Edit Comment" />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
<?php require_once('footer.php'); ?>
