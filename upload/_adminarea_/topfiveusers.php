<?php
header('Content-Type: application/json');
ob_start();
session_start();

include("db/config.php");
include("db/function_xss.php");
// Checking Admin is logged in or not
if(!isset($_SESSION['admin'])) {
	header("location: ".ADMIN_URL."login.php");
	exit;
}
$sql = $pdo->prepare("SELECT sum(p_total_amt) as purchaseAmt, ot_user.user_name as uName FROM ot_payments LEFT JOIN ot_user on (ot_payments.p_user_id = ot_user.user_id) WHERE payment_status = 'Completed' group by p_user_id order by purchaseAmt DESC LIMIT 5");
$sql->execute();
$result = $sql->fetchAll(PDO::FETCH_ASSOC);
$data = array();
foreach ($result as $row) {
	$data[] = $row ;	
}
echo json_encode($data);
?>