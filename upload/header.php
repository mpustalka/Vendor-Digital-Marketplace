<?php
ob_start();
session_start();
include("_adminarea_/db/config.php");
include("_adminarea_/db/function_xss.php");
if(isset($_SESSION['user']['user_id'])){
	 $checkStatus =  check_user_status($pdo) ;
	 //if user deactivate by admin then it's automatically logout
	 if($checkStatus == 0) {
		unset($_SESSION['user']);
		header("location: ".BASE_URL.""); 
	}
	
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Buy Script & Codes</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="<?php echo ADMIN_URL ; ?>css/main.css">
	<link rel="stylesheet" href="<?php echo ADMIN_URL ; ?>css/all.min.css">
	<link rel="stylesheet" href="<?php echo ADMIN_URL ; ?>css/Latofont.css">
	<link rel="stylesheet" href="<?php echo ADMIN_URL ; ?>css/Niconnefont.css">
	<link rel="icon" href="<?php echo ADMIN_URL; ?>images/favicon.png" type="image/png">
</head>
<body class="app sidebar-mini">

    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo text-left" href="<?php echo BASE_URL ; ?>"><img src="<?php echo ADMIN_URL ; ?>images/siteLogo.png" class="img-fluid" alt="Logo"></a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"><i class="fa fa-bars fa-2x"></i></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
        <!-- User Menu-->
		<li><button class="btn btn-sm openBtn mt-2"><i class="fa fa-search-plus text-warning"></i></button></li>
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
		  <?php if(isset($_SESSION['user']['user_id'])){ ?>
		  	<li><a class="dropdown-item" href="<?php echo BASE_URL ; ?>email/"><i class="fa fa-envelope"></i> Email</a></li>
            <li><a class="dropdown-item"  href="<?php echo BASE_URL ; ?>password/"><i class="fa fa-key"></i> Password</a></li>
            <li><a class="dropdown-item" href="<?php echo BASE_URL ; ?>logout.php"><i class="fa fa-sign-out-alt fa-lg"></i> Logout</a></li>
		  <?php } else { ?>
		  	<li><a class="dropdown-item" href="<?php echo BASE_URL ; ?>login.php"><i class="fa fa-envelope"></i> Login / SIgnUp</a></li>
		  <?php } ?>
          </ul>
        </li>
      </ul>
    </header>
	
	<!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
	<?php if(isset($_SESSION['user']['user_id'])){ ?>
      <div class="app-sidebar__user"><i class="fa fa-user fa-2x text-warning"></i>
        <div>
          <p class="app-sidebar__user-name"><small><?php echo get_userfullname($pdo) ;  ?></small></p>
          <p class="app-sidebar__user-designation"><small><?php echo get_useremail($pdo) ; ?></small></p>
        </div>
      </div>
	  <?php } ?>
      <ul class="app-menu">
        <li><a class="app-menu__item" href="<?php echo BASE_URL ; ?>"><i class="app-menu__icon fa fa-home"></i><span class="app-menu__label">Home</span></a></li>
		<li><a class="app-menu__item" href="<?php echo BASE_URL."new/" ; ?>"><i class="app-menu__icon fa fa-certificate"></i><span class="app-menu__label">New Items</span></a></li>
		<li><a class="app-menu__item" href="<?php echo BASE_URL."featured/" ; ?>"><i class="app-menu__icon fa fa-star text-warning"></i><span class="app-menu__label text-warning">Featured Items</span></a></li>
		<li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-align-left"></i><span class="app-menu__label">Category</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <?php echo fetch_active_category_foruser($pdo) ; ?>
          </ul>
        </li>
		<?php
			$subcat = $pdo->prepare("select s_c_id from item_subcategory where s_status ='1' group by s_c_id");
			$subcat->execute();
			$subcatcheck = $subcat->rowCount();
			$resultsubcat = $subcat->fetchAll();
			if($subcatcheck > 0) {
		?>
		<li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-align-center"></i><span class="app-menu__label">Sub Category</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
		  	<?php
				foreach($resultsubcat as $rowsubcat){
					$catId = _e($rowsubcat['s_c_id']);
					?>
					<p class="text-warning ml-3"><?php echo get_category_name($pdo,$catId) ; ?></p>
					<ul class="treeview-menu mt-n3">
					<?php echo fetch_active_subcategory_foruser($pdo,$catId) ; ?>
					</ul>
					<?php
				}
			?>
		   </ul>
		</li>
		<?php 
			}
		?>
		<?php if(isset($_SESSION['user']['user_id'])){ ?>
		<li><a class="app-menu__item" href="<?php echo BASE_URL."downloads/" ; ?>"><i class="app-menu__icon fa fa-download"></i><span class="app-menu__label">Downloads</span></a></li>
		<li><a class="app-menu__item" href="<?php echo BASE_URL."purchases/" ; ?>"><i class="app-menu__icon fa fa-shopping-cart"></i><span class="app-menu__label">Purchases</span></a></li>
		<?php } ?>
		<?php 
			$checkSlug = check_slug_for_user($pdo) ;
			if($checkSlug > '0') {
		?>
		<li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-hand-point-right"></i><span class="app-menu__label">Pages</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <?php echo fetch_active_pages_foruser($pdo) ; ?>
          </ul>
        </li>
		<?php } ?>
	  </ul>
    </aside>
	
	<main class="app-content">
	<div class="row">
		<div id="myOverlay" class="overlay">
		  <span class="closebtn" title="Close">×</span>
		  <div class="overlay-content">
			<form action="<?php echo BASE_URL.'usersearch.php' ; ?>" method="post">
			  <input type="text" placeholder="For Example : Wordpress Theme or PHP Script Or A Letter Logo" name="search_keyword">
			  <button type="submit"><i class="fa fa-search"></i></button>
			</form>
		  </div>
		</div>
	</div>
	<?php
	if(isset($_SESSION['user']['user_id'])){
	$u_chance = check_user_chance($pdo);
	$registrationStatus = check_user_registration_status($pdo) ;
	if($registrationStatus == 0) {
	?>
	<div id="signupModal" class="modal fade " data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog">
    		<form method="post" class="signup_otpform">
    			<div class="modal-content">
    				<div class="modal-header">
						<div class="row">
						<div class="col-lg-12">
						<h4 class="modal-title"><i class='fa fa-eye'></i> Verify Sign Up OTP</h4>
						</div>
						<div class="col-lg-12">
						<small>You've <?php echo $u_chance ; ?> Chance to verify your account. After that You'll be Permanently Blocked.</small>
						</div>
						</div>
    				</div>
    				<div class="modal-body">
						<div class="row">
							<div class="col-lg-12 col-md-12">
								<div class="form-group">
									<label>Email*</label>
									<input type="text" name="email" id="email" class="form-control" readonly="readonly" required value="<?php echo get_useremail($pdo) ; ?>" />
								</div>
								<div class="form-group">
									<label>OTP*</label>
									<input type="password" name="otp" id="otp" class="form-control" required />
								</div>
							</div>
							<div class="col-lg-12 text-center">
							<div class="remove-messages"></div>
							</div>
						</div>						
					</div>
					
					
    				<div class="modal-footer">
						<input type="hidden" name="verify_otp" value="Submit" />
    					<input type="submit" name="action_sign" id="action_sign" class="btn btn-info" value="Verify OTP"  />
    				</form>
					<form method="post" class="resend_otpform">
						<input type="hidden" name="resend_email" value="Submit" />
						<input type="hidden" name="resendEmail" id="resendemail" value="<?php echo get_useremail($pdo) ; ?>" >
						<input type="submit" name="action_resend" id="action_resend" class="btn btn-success" value="Resend OTP"  />
					</form>
    				</div>
    			</div>
    		
    	</div>
    </div>
	<?php
	}
	}
	?>
	