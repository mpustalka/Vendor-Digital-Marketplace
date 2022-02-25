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
$Statement = $pdo->prepare("SELECT * FROM ot_user WHERE user_blocked = '1' order by user_id desc ");
$Statement->execute(); 
$total = $Statement->rowCount();    
$result = $Statement->fetchAll(PDO::FETCH_ASSOC); 
$output = array('data' => array());
$sum = 0 ;
if($total > 0) {
	$active = "";
	foreach($result as $row) {
		$sum = $sum + 1 ;
		$email = _e($row['user_email']) ;
		$username = _e($row['user_name']);
		$uid = _e($row['user_id']);
		$blocked = _e($row['user_blocked']) ;
		if($blocked == '1') {
			$blocked = "<b class='text-danger'>Yes</b>" ;
			$unblock = '<button type="button" name="changeBlockedStatus" id="'.$email.'" class="btn btn-success btn-sm changeBlockedStatus" data-status="0">Unblock&SendEmail</button>';
		} 
		
		$output['data'][] = array( 		
		$sum,
		$uid,
		$username,
		$email,
		$blocked,
		$unblock
		); 	
	}
}
echo json_encode($output);
?>
