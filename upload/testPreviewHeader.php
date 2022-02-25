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
$itemId = filter_var($_GET['item_id'], FILTER_SANITIZE_NUMBER_INT) ;
if(empty($itemId)){
	header("location:".BASE_URL."") ;
}
$checking = check_item_foruser($pdo,$itemId) ;
if($checking == '0'){
	header("location:".BASE_URL."") ;
}
$demoLink = item_demo_link($pdo,$itemId) ;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Item Preview</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="<?php echo ADMIN_URL ; ?>css/main.css">
	<link rel="stylesheet" href="<?php echo ADMIN_URL ; ?>css/all.min.css">
	<link rel="stylesheet" href="<?php echo ADMIN_URL ; ?>css/Latofont.css">
	<link rel="stylesheet" href="<?php echo ADMIN_URL ; ?>css/Niconnefont.css">
	<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL ; ?>css/iframe.css" />
	<link rel="icon" href="<?php echo ADMIN_URL; ?>images/favicon.png" type="image/png">
</head>
<body>
    <!-- Navbar-->
    <header class="app-header border-bottom bg-light"><a class="app-header__logo text-left bg-light" href="<?php echo BASE_URL ; ?>"><img src="<?php echo ADMIN_URL ; ?>images/siteLogo.png" class="img-fluid" alt="Logo"></a>
      
      <!-- Navbar Right Menu-->
	  <ul class="app-nav">
	  	<li><a href="<?php echo $demoLink ; ?>" class="btn btn-md btn-secondary mt-2">Remove Frame</a></li>
		&ensp;
		<li><a href="<?php echo BASE_URL.'item/'.$itemId ; ?>" class="btn btn-md btn-info mt-2">Buy Now - $ <?php echo get_item_price($pdo,$itemId) ; ?></a></li>
	  </ul>
      
    </header>
	