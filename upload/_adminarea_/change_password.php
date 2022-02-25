<?php include("header.php") ; ?>
<div class="container mar-top">
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<div class="row">
				<div class="col-lg-3 col-md-3"></div>
				<div class="col-lg-6 col-md-6">
					<div class="card">
                		<div class="card-header bg-secondary text-white text-center"><h4> Change Password</h4></div>
                		<div class="card-body">
							<form method="post" id="password_validation" class="password_validation">
								<div class="form-group">
									<label for="oldpass"><i class="fa fa-key"></i> Old Password*</label>
									<input type="password" class="form-control" name="oldpass" id="oldpass" placeholder="Old Password" maxlength="50" required>
								</div>
								
										<div class="form-group">
											<label for="newpass"> New Password* </label><br><small>Password must contain minimum 8 characters, 1 Uppercase character, 1 Lowercase character & 1 number.</small>
											<input type="password" class="form-control" name="newpass" id="newpass" placeholder="New Password" maxlength="50" required>
										</div>
										<div class="form-group">
											<label for="phone"> Confirm Password*</label>
											<input type="text" class="form-control" name="repass" id="repass"  placeholder="Confirm New Password" maxlength="50" required>
										</div>
									
								<div class="col-md-12 text-center">
								<div class="remove-messages"></div>
								<input type="hidden" name="uid" value="<?php echo $id ; ?>">
								<input type="hidden" name="pass_submit_pr" value="Submit" />
								<input type="submit" id="pass_submit" name="pass_submit" class="btn btn-primary text-center form_submit" value="Update Password" />
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