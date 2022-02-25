<?php include("header.php") ; ?>
<div class="app-title">
        <div>
          <h1><i class="fa fa-align-left"></i> Category</h1>
		  <p class="text-success">It will useful for Item belongs to which Category.</p>
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
								<div class="page-heading"> 
								<button class="btn btn-info  m-1 bg-success border-success" id="add_catgory"><i class="fa fa-align-left"></i> Add Category</button>
								</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="row">
									<div class="col-md-12">
									  <div class="tile">
										<div class="tile-body">
											<div class="table-responsive">
												<table class="table table-bordered table-hover" id="manageCategoryTable">
													<thead>
														<tr>
															<th>S.No.</th>
															<th>Category ID</th>
															<th>Category Name</th>							
															<th>Date</th>
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
	<!-- Add Category Modal -->
	<div id="catModal" class="modal fade" data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog">
    		<form method="post" id="cat_form" class="cat_form">
    			<div class="modal-content">
    				<div class="modal-header">
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add Category</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
    				</div>
    				<div class="modal-body">
						
						<div class="form-group">
							<label>Category Name* (Max 25 Characters)</label>
							<input type="text" class="form-control" id="cat" name="cat" placeholder="e.g. Themes" autocomplete="off" required maxlength="25">
						</div>
    				</div> 
    				<div class="modal-footer"> 
						<input type="hidden" name="catId" class="catId" >
						<input type="hidden" name="btn_action_cat" id="btn_action_cat" />
    					<input type="submit" name="action_cat" id="action_cat" class="btn btn-info" value="Save Category" />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
<?php include("footer.php") ; ?>