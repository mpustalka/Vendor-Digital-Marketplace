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
$Statement = $pdo->prepare("SELECT * FROM ot_payments WHERE payment_status = 'Completed' order by payment_id desc ");
$Statement->execute(); 
$total = $Statement->rowCount();    
$result = $Statement->fetchAll(PDO::FETCH_ASSOC); 
$output = array('data' => array());
$sum = 0 ;
if($total > 0) {
	$active = "";
	foreach($result as $row) {
		$sum = $sum + 1 ;
		$itemId = _e($row['p_item_id']) ;
		$item_name = get_item_title($pdo,$itemId) ; ;
		$date = _e($row['payment_date']);
		$date =  date('d F, Y',strtotime($date));
		$amount = _e($row['p_total_amt']) ;
		$amount = "$".$amount ;
		$txn_id = _e($row['txn_id']) ;
		$status = _e($row['payment_status']);
		$uid = _e($row['p_user_id']);
		$username = get_userfullname_byid($pdo,$uid) ;
		$useremail = get_useremail_byid($pdo,$uid);
		$license = _e($row['p_license']);
		$output['data'][] = array( 		
		$sum,
		$date,
		$uid,
		$username,
		$useremail,
		$item_name,
		$license,
		$amount,
		$txn_id,
		$status
		); 	
	}
}
echo json_encode($output);
?>