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
$Statement = $pdo->prepare("SELECT * FROM item_subcategory WHERE 1 order by s_id desc");
$Statement->execute(); 
$total = $Statement->rowCount();    
$result = $Statement->fetchAll(PDO::FETCH_ASSOC); 
$output = array('data' => array());
$sum = 0 ;
if($total > 0) {
	$statuss = "";
	foreach($result as $row) {
		$sum = $sum + 1 ;
		$s_id = _e($row['s_id']);
		$s_c_id = _e($row['s_c_id']);
		$c_name = strip_tags($row['s_c_name']);
		$s_name = strip_tags($row['s_name']);
		$s_date = _e($row['s_date']);
		$statuss = _e($row['s_status']);
		$s_date =  date('d F, Y',strtotime($s_date));
		if($statuss == 1) {
			// Deactivate Category
			$statuss = "<b>Active</b>";
			$activate_deactivate = '<button type="button" name="changeSubCatStatusToDeactive" id="'.$s_id.'" class="btn btn-danger btn-sm changeSubCatStatusToDeactive" data-status="0"><i class="fa fa-ban"></i></button>';
		} else {
			// Activate Category
			$statuss = "Not Active";
			$activate_deactivate = '<button type="button" name="changeSubCatStatusToActive" id="'.$s_id.'" class="btn btn-success btn-sm changeSubCatStatusToActive" data-status="1"><i class="fa fa-check"></i></button>';
		}
		$editSubCategory = '<button type="button" name="editSubCategory" id="'.$s_id.'" class="btn btn-light btn-sm editSubCategory"><i class="fa fa-pencil-alt text-muted"></i></button>';
		$output['data'][] = array( 	
		$sum,	
		$s_c_id,
		$c_name,
		$s_id,
		$s_name,
		$s_date,
		$statuss,
		$editSubCategory,
		$activate_deactivate
		); 	
	}
}
echo json_encode($output);
?>