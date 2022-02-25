<?php include("header.php") ; ?>
<div class="container mar-top">
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<div class="row">
				<div class="col-lg-3 col-md-3"></div>
				<div class="col-lg-6 col-md-6">
					<div class="card">
                		<div class="card-header bg-secondary text-white text-center"><h4> Settings</h4><small>Please Make Sure Mail Function has been enabled on your Server.</small></div>
                		<div class="card-body">
							<form method="post" id="admin_settings" class="admin_settings">
								<div class="form-group">
									<label><i class="fa fa-envelope"></i> Admin Email* (Where Admin receives new Emails)</label>
									<input type="email" class="form-control" name="adminEmail" id="adminEmail" maxlength="50"  value="<?php echo $rec_email ; ?>"required>
								</div>
								
										
										<div class="form-group">
											<label>Send Email to User whenever Admin Reply on their Comment* </label>
											<select name="email_comment" class="form-control" required>
												<option value="1" <?php if($email_comment == '1'){ echo $com = 'selected = "selected" ' ; } else { echo $com = '' ; } ?>>Yes</option>
												<option value="0"<?php if($email_comment == '0'){ echo $sub = 'selected = "selected" ' ; } else { echo $com = '' ; } ?>>No</option>
											</select>
										</div>
										<div class="form-group">
											<label>Receive Email to Admin whenever New Comment on Any Item* </label>
											<select name="rec_email_comment" class="form-control" required>
												<option value="1" <?php if($rec_email_comment == '1'){ echo $reccom = 'selected = "selected" ' ; } else { echo $reccom = '' ; }  ?>>Yes</option>
												<option value="0" <?php if($rec_email_comment == '0'){  echo $reccom = 'selected = "selected" ' ; } else { echo $reccom = '' ; }  ?>>No</option>
											</select>
										</div>
										<div class="form-group">
											<label>Receive Email to Admin whenever New Sale* </label>
											<select name="pay_email" class="form-control" required>
												<option value="1" <?php if($pay_email == '1'){ echo $reccom = 'selected = "selected" ' ; } else { echo $reccom = '' ; }  ?>>Yes</option>
												<option value="0" <?php if($pay_email == '0'){  echo $reccom = 'selected = "selected" ' ; } else { echo $reccom = '' ; }  ?>>No</option>
											</select>
										</div>
										<div class="form-group">
											<label>Send Email to Purchased Item by User whenever Admin Update Main File* </label>
											<select name="mainfile_email" class="form-control" required>
												<option value="1" <?php if($mainfile_email == '1'){ echo $com = 'selected = "selected" ' ; } else { echo $com = '' ; } ?>>Yes</option>
												<option value="0"<?php if($mainfile_email == '0'){ echo $sub = 'selected = "selected" ' ; } else { echo $com = '' ; } ?>>No</option>
											</select>
										</div>
										<div class="form-group">
											<label>Receive Email to Admin whenever New Rating by User* </label>
											<select name="rating_email" class="form-control" required>
												<option value="1" <?php if($rating_email == '1'){ echo $com = 'selected = "selected" ' ; } else { echo $com = '' ; } ?>>Yes</option>
												<option value="0"<?php if($rating_email == '0'){ echo $sub = 'selected = "selected" ' ; } else { echo $com = '' ; } ?>>No</option>
											</select>
										</div>
										<div class="form-group">
											<label>How many Chance you give to User to Verify their Email* </label>
											<input type="number" min="1" max="9" name="chance" class="form-control" value="<?php echo $chance ; ?>" required>
										</div>
										<div class="form-group">
											<label>Unblock Message* <small>(No. of Chances automatically added in Email Body)</small> </label>
											<input type="text" maxlength="100" name="msg" class="form-control" value="<?php echo $unblock_msg ; ?>" required>
										</div>
								<div class="col-md-12 text-center">
									<div class="remove-messages"></div>
								<input type="hidden" name="uid" value="<?php echo $id ; ?>">
								<input type="hidden" name="sub_submit_pr" value="Submit" />
								<input type="submit" id="sub_submit" name="sub_submit" class="btn btn-primary text-center form_submit" value="Update Settings" />
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