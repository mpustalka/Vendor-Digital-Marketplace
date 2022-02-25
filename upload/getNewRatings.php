<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0"); 
ob_start();
session_start();
include("_adminarea_/db/config.php");
include("_adminarea_/db/function_xss.php");
if(!empty($_GET["ID"]) && !empty($_GET['ratingId'])){
	$itemId = filter_var($_GET["ID"], FILTER_SANITIZE_NUMBER_INT) ;
	$ratingId = filter_var($_GET["ratingId"], FILTER_SANITIZE_NUMBER_INT) ;
	echo get_item_rating_data_byuser_onload($pdo,$itemId,$ratingId) ;
}
?>