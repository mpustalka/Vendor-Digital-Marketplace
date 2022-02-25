<?php
ob_start();
session_start();
include("db/config.php");
include("db/function_xss.php");
// Checking Admin is logged in or not
if(!isset($_SESSION['admin'])) {
	header("location: ".ADMIN_URL."login.php");
	exit;
} 
$admin = $pdo->prepare("SELECT * FROM ot_admin WHERE id=?");
$admin->execute(array(filter_var("1", FILTER_SANITIZE_NUMBER_INT)));   
$admin_result = $admin->fetchAll(PDO::FETCH_ASSOC);
foreach($admin_result as $adm) {
//escape all admin data
	$id = _e($adm['id']);
	$email_old   = _e($adm['adm_email']);
	$old_password = _e($adm['adm_password']);
	$rec_email = _e($adm['rec_email']);
	$email_comment = _e($adm['email_comment']);
	$rec_email_comment = _e($adm['rec_email_comment']);
	$pay_email = _e($adm['pay_email']);
	$chance = _e($adm['user_chance']);
	$unblock_msg = strip_tags($adm['unblock_msg']);
	$mainfile_email = _e($adm['mainfile_email']);
	$rating_email = _e($adm['rating_email']);
}
?>
 <!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Home</title>

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/all.min.css">
	<link rel="stylesheet" href="css/Latofont.css">
	<link rel="stylesheet" href="css/Niconnefont.css">
	<link rel="icon" href="<?php echo ADMIN_URL; ?>images/favicon.png" type="image/png">	
</head>
<body class="app sidebar-mini">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo text-left" href="<?php echo ADMIN_URL ; ?>dashboard.php"><img src="<?php echo ADMIN_URL ; ?>images/siteLogo.png" class="img-fluid" alt="Logo"></a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"><i class="fa fa-bars fa-2x"></i></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
		  	<li>
			<a class="dropdown-item" href="<?php echo ADMIN_URL ; ?>index.php"><i class="fa fa-envelope"></i> Email</a> 
			</li>
            <li><a class="dropdown-item"  href="<?php echo ADMIN_URL ; ?>change_password.php"><i class="fa fa-key"></i> Password</a></li>
            <li><a class="dropdown-item" href="<?php echo ADMIN_URL ; ?>logout.php"><i class="fa fa-sign-out-alt fa-lg"></i> Logout</a></li>
          </ul>
        </li>
      </ul>
    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><i class="fa fa-user-secret fa-2x text-warning"></i>
        <div>
          <p class="app-sidebar__user-name">Admin</p>
          <p class="app-sidebar__user-designation"><?php echo $email_old ; ?></p>
        </div>
      </div>
      <ul class="app-menu">
        <li><a class="app-menu__item" href="<?php echo ADMIN_URL ; ?>dashboard.php"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Dashboard</span></a></li>
		<li><a class="app-menu__item" href="<?php echo ADMIN_URL ; ?>adminSetting.php"><i class="app-menu__icon fa fa-cog"></i><span class="app-menu__label"> Settings &ensp;<span class="badge badge-warning badge-pill">Imp</span></span></a></li>
		<li><a class="app-menu__item" href="<?php echo ADMIN_URL ; ?>payHistory.php"><i class="app-menu__icon fa fa-dollar-sign text-warning"></i><span class="app-menu__label text-warning"><b>Payments</b></span></a></li>
		<li><a class="app-menu__item" href="<?php echo ADMIN_URL ; ?>users.php"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Users</span></a></li>
		<li><a class="app-menu__item" href="<?php echo ADMIN_URL ; ?>blockedusers.php"><i class="app-menu__icon fa fa-ban text-danger"></i><span class="app-menu__label  text-danger"><b>Blocked Users</b></span></a></li>
		<li><a href="<?php echo ADMIN_URL ; ?>category.php" class="app-menu__item"><i class="app-menu__icon fa fa-align-left"></i><span class="app-menu__label"> Category</span></a></li>
		<li><a href="<?php echo ADMIN_URL ; ?>subcategory.php" class="app-menu__item"><i class="app-menu__icon fa fa-align-center"></i><span class="app-menu__label"> Sub Category</span></a></li>
		<li><a href="<?php echo ADMIN_URL ; ?>childcategory.php" class="app-menu__item"><i class="app-menu__icon fa fa-align-right"></i><span class="app-menu__label"> Child Category</span></a></li>
		<li><a href="<?php echo ADMIN_URL ; ?>upload.php" class="app-menu__item"><i class="app-menu__icon fa fa-upload"></i><span class="app-menu__label"> Upload</span></a></li>
		<li><a href="<?php echo ADMIN_URL ; ?>items.php" class="app-menu__item"><i class="app-menu__icon fa fa-list-ol"></i><span class="app-menu__label"> Items</span></a></li>
		<li><a href="<?php echo ADMIN_URL ; ?>topitems.php" class="app-menu__item"><i class="app-menu__icon fa fa-chart-bar text-warning"></i><span class="app-menu__label">Top Selling Items </span></a></li>
		<li><a href="<?php echo ADMIN_URL ; ?>featured.php" class="app-menu__item"><i class="app-menu__icon fa fa-star text-warning"></i><span class="app-menu__label">Featured Items </span></a></li>
		<li><a href="<?php echo ADMIN_URL ; ?>drafts.php" class="app-menu__item"><i class="app-menu__icon fa fa-clock"></i><span class="app-menu__label">Draft Items </span></a></li>
		<li><a href="<?php echo ADMIN_URL ; ?>comments.php" class="app-menu__item"><i class="app-menu__icon fa fa-comment"></i><span class="app-menu__label">Comments </span></a></li>
		<li><a href="<?php echo ADMIN_URL ; ?>ratings.php" class="app-menu__item"><i class="app-menu__icon fa fa-star-half-alt text-warning"></i><span class="app-menu__label">Ratings </span></a></li>
		<li><a href="<?php echo ADMIN_URL ; ?>pages.php" class="app-menu__item"><i class="app-menu__icon fa fa-file-alt"></i><span class="app-menu__label">Pages </span></a></li>
		<li><a href="<?php echo ADMIN_URL ; ?>managepages.php" class="app-menu__item"><i class="app-menu__icon fa fa-pencil-alt"></i><span class="app-menu__label">Manage Pages </span></a></li>
	  </ul>
    </aside>
    <main class="app-content">
 

