<?php include("header.php"); ?>
<div class="app-title">
        <div>
          <h1><i class="fa fa-star-half-alt text-warning"></i> Rating & Reviews</h1>
		  <p class="text-success">Revoke Right means User cannot Edit Rating for Particular Single Item.</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?php echo ADMIN_URL ; ?>dashboard.php">Dashboard</a></li>
        </ul>
 </div>
 <div class="container-fluid">
      	<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="row">
		   			<div class="col-md-12 col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<span class="text-muted">Manage Ratings & Reviews</span>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="row">
									<div class="col-md-12">
									  <div class="tile">
										<div class="tile-body">
											<div class="table-responsive">
												<table class="table table-bordered table-hover" id="manageRatingTable">
													<thead>
														<tr>
															<th>S.No.</th>
															<th>Item Thumbnail</th>
															<th>Item Id</th>	
															<th>Item Name</th>
															<th>Total Rating</th>
															<th>Total Rated By</th>
															<th><i class="fa fa-eye"></i></th>
															<th>User Name</th>
															<th>User Email</th>
															<th>User Rating</th>
															<th>Rating Comment</th>
															<th><i class="fa fa-star text-warning"></i>EditRating</th>
															<th>Revoke Right</th>
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
	<!-- Edit Rating Modal -->
<div id="editratingModal" class="modal fade ratingModal">
	<div class="modal-dialog">
		<form method="post" class="editrating_form">
			<div class="modal-content">
				<div class="modal-header ">
					<h4 class="modal-title text-muted"><i class="fa fa-star text-warning"></i> Rate Now !</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group mb-3">
						<div class="form-check form-check-inline">
						
						  <input class="form-check-input" type="radio" name="subRate"  value="1.00" required >
						  <label class="form-check-label">1 <img src="<?php echo ADMIN_URL ; ?>images/1star.png" class="img-fluid"></label>
						</div>
						<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="subRate"  value="2.00" required>
						  <label class="form-check-label">2 <img src="<?php echo ADMIN_URL ; ?>images/2star.png" class="img-fluid"></label>
						</div>
						<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="subRate"  value="3.00" required>
						  <label class="form-check-label">3 <img src="<?php echo ADMIN_URL ; ?>images/3star.png" class="img-fluid"></label>
						</div>
						<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="subRate"  value="4.00" required>
						  <label class="form-check-label">4 <img src="<?php echo ADMIN_URL ; ?>images/4star.png" class="img-fluid"></label>
						</div>
						<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="subRate" value="5.00" required >
						  <label class="form-check-label">5 <img src="<?php echo ADMIN_URL ; ?>images/5star.png" class="img-fluid"></label>
						</div>
					</div> 
					<div class="form-group mb-3">
						<label class="text-muted">Comment<small> (Optional)</label>
						<textarea name="itemReview" maxlength="250" class="itemReview form-control"></textarea>
					</div>
					<div class="remove-messages"></div>
				</div> 
				<div class="modal-footer"> 
					<input type="hidden" name="itempId" id="itempId" >
					<input type="hidden" name="userid" id="userid" />
					<input type="hidden" name="itemId" id="edititemId" />
					<input type="hidden" name="oldRating" id="oldRating" />
					<input type="hidden" name="btn_action_sb_edit" id="btn_action_sb_edit" value="EditSubmit" />
					<span class="oldRating text-muted"></span>
					<input type="submit" name="action_sb_edit" id="action_sb_edit" class="btn btn-success" value="Edit Rating" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>
<?php include("footer.php"); ?>