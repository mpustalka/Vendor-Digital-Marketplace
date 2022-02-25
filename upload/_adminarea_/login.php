<?php
include("db/config.php") ; 
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Admin Login</title>

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<link rel="stylesheet" href="<?php echo ADMIN_URL ; ?>css/main.css">
	<link rel="stylesheet" href="<?php echo ADMIN_URL ; ?>css/all.min.css">
	<link rel="stylesheet" href="<?php echo ADMIN_URL ; ?>css/custom.css" />
	<link rel="stylesheet" href="<?php echo ADMIN_URL ; ?>css/Latofont.css">
	<link rel="stylesheet" href="<?php echo ADMIN_URL ; ?>css/Niconnefont.css">
	
</head>

<body>
	<div id="logreg-forms" class="shadow-lg">
	<div class="modal-header justify-content-center bg-secondary">
		<img src="<?php echo ADMIN_URL ; ?>images/siteLogo.png" class="img-fluid"  alt="Logo">
	</div>
	<div class="remove-messages"></div>
	<form  id="adminlogin_form" class="form-signin" method="post">
		<h4 class="d-flex justify-content-center"> Admin Login</h4>
		<input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email Address" maxlength="50" required autofocus>
		<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
		<button class="btn btn-success btn-block" type="submit" name="action_log" id="action_log"><i class="fas fa-sign-in"></i> Sign in</button>
		<hr>
		<a href="#" id="forgot_pswd">Forgot password?</a>
				
	</form>
	<form class="form-reset forgot_form" method="post">
				<h4 class="d-flex justify-content-center"> Forgot Password ?</h4>
                <input type="email" name="email" id="resetEmail" class="form-control" placeholder="Email address" maxlength="50" required autofocus>
                <button class="btn btn-primary btn-block" type="submit">Reset Password</button>
                <a href="#" id="cancel_reset"><i class="fas fa-angle-left"></i> Back</a>
            </form>
</div>
<div id="forgotModal" class="modal fade " data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog">
    		<form method="post" id="forgot_otpform">
    			<div class="modal-content">
    				<div class="modal-header">
						<h4 class="modal-title"><i class='fa fa-eye'></i> Verify Forgot Password OTP</h4>
    				</div>
    				<div class="modal-body">
						<div class="row">
							<div class="col-lg-12 col-md-12">
								<div class="form-group">
									<label>Email*</label>
									<input type="text" name="email" id="forgotemail" class="form-control" readonly="readonly" required />
								</div>
								<div class="form-group">
									<label>OTP*</label>
									<input type="password" name="otp" id="otp" class="form-control" required />
								</div>
							</div>
						</div>						
					</div>
					
					
    				<div class="modal-footer">
    					<input type="submit" name="action_fp" id="action_fp" class="btn btn-info" value="Verify OTP"  />
    					
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
<div id="forgotpasswordModal" class="modal fade " data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog">
    		<form method="post" id="forgotpassword_otpform">
    			<div class="modal-content">
    				<div class="modal-header">
						<h4 class="modal-title"><i class='fa fa-key'></i> Change Password</h4>
    				</div>
    				<div class="modal-body">
						<div class="row">
							<div class="col-lg-12 col-md-12">
								<div class="form-group">
									<label>Email*</label>
									<input type="text" name="email" id="forgotpasswordemail" class="form-control" readonly="readonly" required />
								</div>
								<div class="form-group">
								 <small>Password must contain minimum 8 characters, 1 Uppercase character, 1 Lowercase character & 1 number.</small>
								 <br>
									<label for="newpassword" class="control-label">New Password*</label>
									<input type="password" class="form-control" name="newpassword" maxlength="50" required>
								</div>
								<div class="form-group">
									<label for="confirmnewpassword" class="control-label">Confirm New Password*</label>
									<input type="text" class="form-control" name="confirmnewpassword" maxlength="50" autocomplete="off" required>
								</div>
							</div>
						</div>						
					</div>
					
					
    				<div class="modal-footer">
    					<input type="submit" name="action_cp" id="action_cp" class="btn btn-info" value="Change Password"  />
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
<script type="text/javascript" src="<?php echo ADMIN_URL ; ?>js/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_URL ; ?>js/popper.min.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_URL ; ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_URL ; ?>js/custom.js"></script>

</body>
</html>
