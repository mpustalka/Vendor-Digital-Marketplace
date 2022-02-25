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
$Statement = $pdo->prepare("SELECT count(item_sale) as c, item_Id, item_name, item_rating, item_preview,item_thumbnail, regular_price, extended_price, created_date, updated_date, item_sale, item_rated_by, item_featured, was_featured, item_status FROM item_db WHERE item_status = '1' and item_sale > 0 group by item_Id order by c ASC");
$Statement->execute(); 
$total = $Statement->rowCount();    
$result = $Statement->fetchAll(PDO::FETCH_ASSOC); 
$output = array('data' => array());
$sum = 0 ;
if($total > 0) {
	$statuss = "";
	foreach($result as $row) {
		$sum = $sum + 1 ;
		$item_id = _e($row['item_Id']);
		$created_date = _e($row['created_date']);
		$created_date =  date('d F, Y',strtotime($created_date));
		$updated_date = _e($row['updated_date']);
		$updated_date =  date('d F, Y',strtotime($updated_date));
		$item_name = strip_tags($row['item_name']);
		$regular_price = _e("$".$row['regular_price']) ;
		$extended_price = _e("$".$row['extended_price']) ;
		$statuss = _e($row['item_status']);
		$sale = _e($row['item_sale']) ;
		$rating = _e($row['item_rating']) ;
		$rated_by = _e($row['item_rated_by']) ;
		$is_featured = _e($row['item_featured']) ;
		$was_featured = _e($row['was_featured']) ;
		$itemThumbnail = get_item_small_thumbnail($pdo,$item_id) ;
		
		
		if($statuss == 1) {
			// Deactivate Item
			$statuss = "<b class='text-success'>Active</b>";
		} else {
			// Activate Item
			$statuss = "<b class='text-danger'>Deactive</b>";
		}
		$editItem = '<a href="'.ADMIN_URL.'upload.php?item_id='.$item_id.'" class="btn btn-sm btn-info">Edit</a>';
		$output['data'][] = array( 	
		$sum,
		$item_id,
		$itemThumbnail,
		$item_name,
		$sale,
		$rating,
		$rated_by,
		$regular_price,
		$extended_price,
		$created_date,
		$updated_date,
		$statuss,
		$editItem
		); 	
	}
}
echo json_encode($output);
?>