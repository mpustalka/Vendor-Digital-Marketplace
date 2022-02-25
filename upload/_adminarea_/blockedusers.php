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
								<div class="page-heading d-inline"><h5 class="text-left">View Blocked Users
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
												<table class="table table-bordered table-hover" id="manageBlockedUserTable">
													<thead>
														<tr>
															<th>S.no.</th>	
															<th>UserID</th>
															<th>Username</th>				
															<th>Email</th>
															<th>Blocked</th>
															<th>Unblock & Send Email</th>
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

<?php require_once('footer.php'); ?>


