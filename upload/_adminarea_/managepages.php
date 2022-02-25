<?php include("header.php") ; ?>
<div class="app-title">
        <div>
          <h1><i class="fa fa-pencil-alt text-success"></i> Manage Pages</h1>
		  <p class="text-success">Note : If you Deactivate all Pages then Pages Option is automatically hide from User Panel</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?php echo ADMIN_URL ; ?>dashboard.php">Dashboard</a></li>
        </ul>
</div>
<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="row">
		   			<div class="col-md-12 col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="page-heading d-inline"><h5 class="text-left">View Users
									</h5>
								</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="row">
									<div class="col-md-12">
									  <div class="tile">
										<div class="tile-body">
											<div class="table-responsive">
												<table class="table table-bordered table-hover" id="managePagesTable">
													<thead>
														<tr>
															<th>S.No.</th>	
															<th>Page Name</th>	
															<th>Page Slug</th>
															<th>Status</th>
															<th><i class="fa fa-eye"></i></th>
															<th><i class="fa fa-pencil-alt"></i></th>
															<th><i class="fa fa-ban text-danger"></i></th>
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
<?php include("footer.php") ; ?>