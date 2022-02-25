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
$Statement = $pdo->prepare("SELECT * FROM ot_payments WHERE payment_status = 'Completed' and complete_status = '1' and p_user_id = '".$_SESSION['user']['user_id']."' order by payment_id desc ");
$Statement->execute(); 
$total = $Statement->rowCount();    
$result = $Statement->fetchAll(PDO::FETCH_ASSOC); 
$sum = 0 ;
$output = array('data' => array());
if($total > 0) {
	$active = "";
	foreach($result as $row) {
		$sum = $sum + 1 ;
		$itemId = _e($row['p_item_id']) ;
		$txn_id = _e($row['txn_id']) ;
		$pDate = _e($row['payment_date']);
		$pDate =  date('d F, Y',strtotime($pDate));
		$amt = _e("$ ".$row['p_total_amt']) ;
		$itemName = get_item_title($pdo,$itemId);
		$viewItem = '<a href="'.BASE_URL.'item/'.$itemId.'" target="_blank" class="btn btn-sm btn-light" ><i class="fa fa-eye"></i></a>';
		$itemThumbnail = get_item_small_thumbnail($pdo,$itemId) ;
		
		$output['data'][] = array( 		
		$sum,
		$itemThumbnail,
		$itemName,
		$pDate,
		$txn_id,
		$amt,
		$viewItem
		); 	
	}
}
echo json_encode($output);
?>