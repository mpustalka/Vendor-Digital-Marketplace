<?php include("header.php") ; ?>
<div class="container mar-top">
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<div class="row">
				<div class="col-lg-3 col-md-3"></div>
				<div class="col-lg-6 col-md-6">
					<div class="card">
                		<div class="card-header bg-secondary text-white text-center"><h4> Change Email</h4></div>
                		<div class="card-body">
							<form method="post" id="email_validation" class="email_validation">
								<div class="form-group">
									<label for="email"><i class="fa fa-envelope"></i> New Email*</label>
									<input type="email" class="form-control" name="newemail" id="newemail" placeholder="New Email" maxlength="50" required>
								</div>
								<div class="form-group">
									<label for="oldpass"><i class="fa fa-key"></i> Password*</label>
									<input type="password" class="form-control" name="passw" id="passw" placeholder="Password" maxlength="50" required>
								</div>
								<div class="col-md-12 text-center">
								<div class="remove-messages"></div>
								<input type="hidden" name="uid" value="<?php echo $id ; ?>">
								<input type="hidden" name="email_submit_pr" value="Submit" />
								<input type="submit" id="email_submit" name="email_submit" class="btn btn-primary text-center form_submit" value="Update Email" />
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
<?php include("footer.php") ; ?>