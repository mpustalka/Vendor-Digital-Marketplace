<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0"); 
ob_start();
session_start();
include("_adminarea_/db/config.php");
include("_adminarea_/db/function_xss.php");
if(!empty($_GET['subcatId'])){
	$subcategory_id = filter_var($_GET['subcatId'], FILTER_SANITIZE_NUMBER_INT) ;
	$item_id = filter_var($_GET['ID'], FILTER_SANITIZE_NUMBER_INT) ;
	echo fetch_product_by_subcategory_onload_foruser($pdo,$item_id,$subcategory_id) ;
}
?>