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
$Statement = $pdo->prepare("SELECT * FROM ot_user WHERE 1 order by user_id desc ");
$Statement->execute(); 
$total = $Statement->rowCount();    
$result = $Statement->fetchAll(PDO::FETCH_ASSOC); 
$output = array('data' => array());
$sum = 0 ;
if($total > 0) {
	$active = "";
	foreach($result as $row) {
		$sum = $sum + 1 ;
		$uid = _e($row['user_id']);
		$email = _e($row['user_email']) ;
		$date = _e($row['register_date']);
		$date =  date('d F, Y',strtotime($date));
		$purchases = getuser_purchases_by_id($pdo,$uid) ;
		$purchases = "$".$purchases ;
		$status = _e($row['user_status']) ;
		if($status == '1') {
			$status = "<b>Active</b>" ;
		} else {
			$status = "Not Active";
		}
		$blocked = _e($row['user_blocked']) ;
		if($blocked == '1') {
			$blocked = "<b>Yes</b>" ;
			$blockBtn = '';
		} else {
			$blocked = "No";
			$blockBtn = '<button type="button" name="changeUserStatus" id="'.$uid.'" class="btn btn-danger btn-sm changeUserStatus" data-status="1"><i class="fa fa-ban"></i></button>';
		}
		$username = _e($row['user_name']);
		
		$output['data'][] = array( 		
		$sum,
		$date,
		$uid,
		$username,
		$email,
		$purchases,
		$status,
		$blocked,
		$blockBtn
		); 	
	}
}
echo json_encode($output);
?>