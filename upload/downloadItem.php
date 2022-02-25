<?php
ob_start();
session_start();
include("_adminarea_/db/config.php");
include("_adminarea_/db/function_xss.php");
// Checking User is logged in or not
if(!isset($_SESSION['user'])) {
	header("location: ".BASE_URL.""); 
	exit;
}
if(isset($_POST['SaveMainfile'])){
	
		$name = filter_var($_POST['main_file'], FILTER_SANITIZE_STRING) ;
		$item_id = filter_var($_POST['item_id'], FILTER_SANITIZE_NUMBER_INT) ;
		$filname = '_adminarea_/_item_main_/'.$item_id.'/'.$name ;
		if (headers_sent()) {
			echo 'HTTP header already sent';
		} else {
			if (!is_file($filname)) {
				header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
				echo 'File not found';
			} else if (!is_readable($filname)) {
				header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
				echo 'File not readable';
			} else {
				header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
				header("Content-Type: application/zip");
				header("Content-Transfer-Encoding: Binary");
				header("Content-Length: ".filesize($filname));
				header("Content-Disposition: attachment; filename=\"".basename($filname)."\"");
				readfile($filname);
				exit;
			}
		}		
} else{
	echo "You are not authorize to Direct Access.";
}
?>