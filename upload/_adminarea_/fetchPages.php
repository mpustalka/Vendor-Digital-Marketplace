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
$Statement = $pdo->prepare("SELECT * FROM ot_admin_pages WHERE 1 order by page_name asc ");
$Statement->execute(); 
$total = $Statement->rowCount();    
$result = $Statement->fetchAll(PDO::FETCH_ASSOC); 
$output = array('data' => array());
$sum = 0 ;
if($total > 0) {
	$active = "";
	foreach($result as $row) {
		$sum = $sum + 1 ;
		$id = _e($row['page_id']) ;
		$pageName = strip_tags($row['page_name']);
		$pageSlug = _e($row['page_slug']) ;
		$status = _e($row['page_status']) ;
		if($status == '1') {
			$status = "<b class='text-success'>Active</b>" ;
			$activate_deactivate = '<button type="button" name="changePageStatus" id="'.$id.'" class="btn btn-danger btn-sm changePageStatus" data-status="0"><i class="fa fa-ban"></i></button>';
			$view = '<a href="'.BASE_URL.'page/'.$pageSlug.'" target="_blank" class="btn btn-sm btn-light"><i class="fa fa-eye"></i></a>';
		} else {
			$status = "<b class='text-danger'>Deactivated</b>";
			$activate_deactivate = '<button type="button" name="changePageStatus" id="'.$id.'" class="btn btn-success btn-sm changePageStatus" data-status="1"><i class="fa fa-check"></i></button>';
			$view = "";
		}
		
		$edit = '<a href="'.ADMIN_URL.'pages.php?id='.$id.'" class="btn btn-sm btn-light"><i class="fa fa-pencil-alt"></i></a>';
		
		$output['data'][] = array( 		
		$sum,
		$pageName,
		$pageSlug,
		$status,
		$view,
		$edit,
		$activate_deactivate
		); 	
	}
}
echo json_encode($output);
?>