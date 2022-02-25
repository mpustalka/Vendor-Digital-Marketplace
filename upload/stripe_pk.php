<?php
ob_start();
session_start();
include("_adminarea_/db/config.php");
include("_adminarea_/db/function_xss.php");
// Checking User is logged in or not
if(!isset($_SESSION['user'])) {
	header("location: ".BASE_URL."login.php");
	exit;
} 
$data = STRIPE_PUBLISHABLE_KEY ;
echo $data ;
?>