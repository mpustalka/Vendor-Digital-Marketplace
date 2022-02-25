<?php include("header.php") ; ?>
<div class="app-title">
        <div>
          <h1><i class="fa fa-list-ol"></i> Top Selling Items</h1>
		  <p class="text-success">It will show Only Active Items which have at least 1 Sale.</p>
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
								<a href="<?php echo ADMIN_URL."upload.php" ; ?>" class="btn btn-success  m-1 bg-success border-success">+ Add New Item</a> 
								</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="row">
									<div class="col-md-12">
									  <div class="tile">
										<div class="tile-body">
											<div class="table-responsive">
												<table class="table table-bordered table-hover" id="manageTopItemsTable">
													<thead>
														<tr>
															<th>S.No.</th>
															<th>Item ID</th>
															<th>Thumbnail</th>
															<th>Item Name</th>
															<th>Sale</th>
															<th><i class="fa fa-star text-warning"></i> Rating</th>
															<th>Rated By</th>
															<th>Regular Price</th>
															<th>Extended Price</th>					
															<th>Created Date</th>
															<th>Updated Date</th>
															<th>Status</th>
															<th><i class="fa fa-pencil-alt"></i></th>
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
<?php include("footer.php") ; ?>