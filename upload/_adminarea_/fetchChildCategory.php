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
$Statement = $pdo->prepare("SELECT * FROM item_childcategory WHERE 1 order by ch_id desc");
$Statement->execute(); 
$total = $Statement->rowCount();    
$result = $Statement->fetchAll(PDO::FETCH_ASSOC); 
$output = array('data' => array());
$sum = 0 ;
if($total > 0) {
	$statuss = "";
	foreach($result as $row) {
		$sum = $sum + 1 ;
		$ch_s_id = _e($row['ch_s_id']);
		$ch_c_id = _e($row['ch_c_id']);
		$c_name = strip_tags($row['ch_c_name']);
		$s_name = strip_tags($row['ch_s_name']);
		$ch_id = _e($row['ch_id']);
		$ch_name = strip_tags($row['ch_name']);
		$ch_date = _e($row['ch_date']);
		$statuss = _e($row['ch_status']);
		$ch_date =  date('d F, Y',strtotime($ch_date));
		if($statuss == 1) {
			// Deactivate Category
			$statuss = "<b>Active</b>";
			$activate_deactivate = '<button type="button" name="changeChildCatStatusToDeactive" id="'.$ch_id.'" class="btn btn-danger btn-sm changeChildCatStatusToDeactive" data-status="0"><i class="fa fa-ban"></i></button>';
		} else {
			// Activate Category
			$statuss = "Not Active";
			$activate_deactivate = '<button type="button" name="changeChildCatStatusToActive" id="'.$ch_id.'" class="btn btn-success btn-sm changeChildCatStatusToActive" data-status="1"><i class="fa fa-check"></i></button>';
		}
		$editChildCategory = '<button type="button" name="editChildCategory" id="'.$ch_id.'" class="btn btn-light btn-sm editChildCategory"><i class="fa fa-pencil-alt text-muted"></i></button>';
		$output['data'][] = array( 	
		$sum,	
		$ch_c_id,
		$c_name,
		$ch_s_id,
		$s_name,
		$ch_id,
		$ch_name,
		$ch_date,
		$statuss,
		$editChildCategory,
		$activate_deactivate
		); 	
	}
}
echo json_encode($output);
?>