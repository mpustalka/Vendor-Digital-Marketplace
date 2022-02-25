<?php
ob_start();
session_start();
include("db/config.php");
// Checking Admin is logged in or not
if(!isset($_SESSION['admin'])) {
	header('location: login.php');
	exit;
}
if($_POST['btn_action'] == 'changeUserStatus')
	{
		$customerId = filter_var($_POST['customerId'], FILTER_SANITIZE_NUMBER_INT);
		$status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
		if($customerId) {
			$update = $pdo->prepare("UPDATE customer_active SET active_status=?   WHERE user_id=?");
			$result_new = $update->execute(array($status,$customerId));
		}
		if($result_new) {
			echo 'User status changed .' ;		
		}
}
?>