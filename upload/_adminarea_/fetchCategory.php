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
$Statement = $pdo->prepare("SELECT * FROM item_category WHERE 1 order by c_id desc");
$Statement->execute(); 
$total = $Statement->rowCount();    
$result = $Statement->fetchAll(PDO::FETCH_ASSOC); 
$output = array('data' => array());
$sum = 0 ;
if($total > 0) {
	$statuss = "";
	foreach($result as $row) {
		$sum = $sum + 1 ;
		$c_id = _e($row['c_id']);
		$c_name = strip_tags($row['c_name']);
		$c_date = _e($row['c_date']);
		$statuss = _e($row['c_status']);
		$c_date =  date('d F, Y',strtotime($c_date));
		if($statuss == 1) {
			// Deactivate Category
			$statuss = "<b>Active</b>";
			$activate_deactivate = '<button type="button" name="changeCatStatusToDeactive" id="'.$c_id.'" class="btn btn-danger btn-sm changeCatStatusToDeactive" data-status="0"><i class="fa fa-ban"></i></button>';
		} else {
			// Activate Category
			$statuss = "Not Active";
			$activate_deactivate = '<button type="button" name="changeCatStatusToActive" id="'.$c_id.'" class="btn btn-success btn-sm changeCatStatusToActive" data-status="1"><i class="fa fa-check"></i></button>';
		}
		$editCategory = '<button type="button" name="editCategory" id="'.$c_id.'" class="btn btn-light btn-sm editCategory"><i class="fa fa-pencil-alt text-muted"></i></button>';
		$output['data'][] = array( 	
		$sum,	
		$c_id,
		$c_name,
		$c_date,
		$statuss,
		$editCategory,
		$activate_deactivate
		); 	
	}
}
echo json_encode($output);
?>