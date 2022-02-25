<?php
ob_start();
session_start();
include("db/config.php");
include("db/function_xss.php");
// Checking Admin is logged in or not
if(!isset($_SESSION['admin'])) {
	header("location: login.php"); 
	exit;
}
$Statement = $pdo->prepare("SELECT * FROM send_user_email WHERE 1 order by id desc");
$Statement->execute(); 
$total = $Statement->rowCount();    
$result = $Statement->fetchAll(PDO::FETCH_ASSOC); 
$output = array('data' => array());
if($total > 0) {
	$statuss = "";
	foreach($result as $row) {
		$customerId = _e($row['user_id']);
		$fullname = _e($row['user_name']);
		$subject = strip_tags($row['subject']);
		$email = _e($row['user_email']);
		$smsText = nl2br($row['email_text']);
		$smsDate = _e($row['email_date']);
		$smsDate =  date('d F, Y',strtotime($smsDate));
		$output['data'][] = array( 		
		$customerId,
		$smsDate,
		$fullname,
		$email, 
		$subject,
		$smsText
		); 	
	}
}
echo json_encode($output);
?>
