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
$sql = $pdo->prepare("SELECT sum(regular_price * item_sale) as salesAmt, item_name FROM item_db WHERE item_status = '1' and item_sale > 0 group by item_Id order by salesAmt DESC LIMIT 5");
$sql->execute();
$result = $sql->fetchAll(PDO::FETCH_ASSOC);
$data = array();
foreach ($result as $row) {
	$data[] = $row ;	
}
echo json_encode($data);
?>