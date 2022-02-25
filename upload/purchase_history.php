<?php include("header.php") ;
//if user is not logged in 
if(!isset($_SESSION['user']['user_id'])){
	header("location: ".BASE_URL.""); 
}
?>
<div class="app-title">
<h1 class="text-muted"><i class="fa fa-shopping-cart text-success"></i> Purchases</h1>
<ul class="app-breadcrumb breadcrumb">
	<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
	<li class="breadcrumb-item"><a href="<?php echo  BASE_URL ; ?>" >Home</a></li>
</ul>
</div>
<div class="container-fluid">
      	<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="row">
		   			<div class="col-md-12 col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<span class="text-muted">Purchase History</span>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="row">
									<div class="col-md-12">
									  <div class="tile">
										<div class="tile-body">
											<div class="table-responsive">
												<table class="table table-bordered table-hover" id="managePurchaseTable">
													<thead>
														<tr>
															<th>S.No.</th>
															<th>Item Thumbnail</th>	
															<th>Item Name</th>
															<th>Date</th>
															<th>Transaction ID</th>
															<th>Amount</th>
															<th><i class="fa fa-eye"></i></th>
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