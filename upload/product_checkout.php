<?php include("header.php") ; ?>
<?php
if(isset($_POST['submit'])){
$itemId = filter_var($_POST['itemId'], FILTER_SANITIZE_NUMBER_INT) ;
$itemAmt = filter_var($_POST['item_amount'], FILTER_SANITIZE_NUMBER_INT) ;
$itemName = filter_var($_POST['item_name'], FILTER_SANITIZE_STRING) ;
$license = filter_var($_POST['lic'], FILTER_SANITIZE_NUMBER_INT) ;
?>
<div class="app-title p-3">
<h1 class="text-muted"><?php echo get_item_title($pdo,$itemId) ; ?></h1>
<ul class="app-breadcrumb breadcrumb">
	<li class="breadcrumb-item"><?php echo  get_item_small_thumbnail($pdo,$itemId) ; ?></li>
</ul>
</div>
<div class="container mar-top">
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<div class="row">
				<div class="col-lg-3 col-md-3"></div>
				<div class="col-lg-6 col-md-6">
					<div class="card">
                		<div class="card-header bg-secondary text-white text-center"><h4> Pay via Stripe</h4></div>
                		<div class="card-body">
						<form action="<?php echo BASE_URL; ?>payment.php" id="payment_form" method="post" >
							<div class="row">
								<div class="col-lg-6 col-md-6">
									<div class="form-group">
										<label>Name</label>
										<input type="text" name="cname" id="cname" class="form-control" value="<?php echo get_userfullname($pdo) ; ?>" readonly="readonly"/>
									</div>
								</div>
								<div class="col-lg-6 col-md-6">
									<div class="form-group">
										<label>Email</label>
										<input type="email" name="cemail" id="cemail" class="form-control"  value="<?php echo get_useremail($pdo) ; ?>" readonly="readonly"  />
									</div>
								</div>
								<div class="col-lg-6">
						<div class="form-group">
							<label class="text-muted">Card Number</label>
							<div class="input-group">
								<div id="card_number" class="field form-control"></div>
							</div>
						</div>
						</div>
								<div class="col-lg-3">
								<div class="form-group">
									<label class="text-muted">Expiry MM/YY</label>
									<div class="input-group">
										<div id="card_expiry" class="field form-control"></div>
									</div>
								</div>
								</div>
								<div class="col-lg-3">
								<div class="form-group">
									<label  class="text-muted">CVC</label>
									<div id="card_cvc" class="field form-control"></div>
								</div>
								</div>
								<div class="col-lg-12 p-2"><div id="paymentResponse"></div> </div>
								<div class="col-lg-12 text-center mt-1">
									<input type="hidden" name="uid" value="<?php echo $_SESSION['user']['user_id'] ; ?>" >
									<input type='hidden' name='item_amount' value='<?php echo $itemAmt ; ?>'>
									<input type='hidden' name='item_number' value='<?php echo $itemId ; ?>'> 
									<input type='hidden' name='item_name' value='<?php echo $itemName ; ?>'> 
									<input type='hidden' name='item_license' value='<?php echo $license ; ?>'> 
									<input type='hidden' name='currency_code' value='USD'> 
									<button type="submit" class="btn btn-md btn-success" id="submitBtn">Pay Now <?php echo "&ensp;$ ".$itemAmt ; ?></button>
								</div>
							</div>
						</form>
						</div>
           			 </div>
				</div>
				<div class="col-lg-3 col-md-3"></div>
			</div>
		</div>
	</div>
</div>
<?php include("stripefooter.php") ; ?>						
<?php
} else {
	header("location: ".BASE_URL.""); 
}
?>

