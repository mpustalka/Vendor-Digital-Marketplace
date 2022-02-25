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
								<div class="page-heading d-inline"><h5 class="text-left">View Payment History
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
												<table class="table table-bordered table-hover" id="managePaymentTable">
													<thead>
														<tr>
															<th>S.no.</th>	
															<th>Date</th>	
															<th>UserID</th>
															<th>User Name</th>
															<th>User Email</th>				
															<th>Item Name</th>
															<th>License</th>
															<th>Amount ($)</th>
															<th>Transaction ID</th>
															<th>Status</th>
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

