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
$Statement = $pdo->prepare("SELECT * FROM item_db WHERE item_status='1' order by item_id desc");
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
		$c_id = _e($row['main_category']);
		$s_id = _e($row['sub_category']);
		$ch_id = _e($row['child_category']);
		$c_name = fetchcategory_name($pdo,$c_id) ;
		$s_name = fetchsubcategory_name($pdo,$s_id) ;
		$ch_name = fetchchildcategory_name($pdo,$ch_id) ;
		$created_date = _e($row['created_date']);
		$created_date =  date('d F, Y',strtotime($created_date));
		$updated_date = _e($row['updated_date']);
		$updated_date =  date('d F, Y',strtotime($updated_date));
		$item_name = strip_tags($row['item_name']);
		$regular_price = _e("$".$row['regular_price']) ;
		$extended_price = _e("$".$row['extended_price']) ;
		$item_tags = strip_tags($row['item_tags']) ;
		$statuss = _e($row['item_status']);
		$thumbnail = _e($row['item_thumbnail']);
		$preview = _e($row['item_preview']);
		$mainfile = _e($row['item_mainfile']);
		$screenshot = _e($row['item_docufile']);
		$sale = _e($row['item_sale']) ;
		$rating = _e($row['item_rating']) ;
		$rated_by = _e($row['item_rated_by']) ;
		$is_featured = _e($row['item_featured']) ;
		$was_featured = _e($row['was_featured']) ;
		if($is_featured == '1') {
			$featured = '<button class="btn btn-sm btn-success text-white" disabled="disabled"><i class="fas fa-star text-warning"></i> </button>';
			$makeFeatured = '<button type="button" name="changeItemFeatureStatus" id="'.$item_id.'" class="btn btn-danger btn-sm changeItemFeatureStatus" data-status="0">Make Unfeatured</button>';
		} else {
			$featured = '';
			$makeFeatured = '<button type="button" name="changeItemFeatureStatus" id="'.$item_id.'" class="btn btn-success btn-sm changeItemFeatureStatus" data-status="1">Make Featured</button>';
		}
		if($was_featured == '1') {
			$wasfeatured = '<button class="btn btn-sm btn-info text-white" disabled="disabled"><i class="fas fa-certificate text-warning"></i> </button>';
			
		} else {
			$wasfeatured = '';
			
		}
		if(empty($screenshot)){
			$screenshot = "";
		} else {
			$screenshot = '<form method="POST" action="'.ADMIN_URL.'download.php" enctype="multipart/form-data">
							<input type="hidden" name="item_id" value="'.$item_id.'" >
							<input type="hidden" name="screenshot_file" value="'.$screenshot.'" >
							<input type="submit" name="SaveScreenshot" value="Download Screenshot" class="btn btn-sm btn-success" >';
		}
		if(empty($mainfile)){
			$mainfile = "";
		} else {
			$mainfile = '<form method="POST" action="'.ADMIN_URL.'download.php" enctype="multipart/form-data">
							<input type="hidden" name="item_id" value="'.$item_id.'" >
							<input type="hidden" name="main_file" value="'.$mainfile.'" >
							<input type="submit" name="SaveMainfile" value="Download Main File" class="btn btn-sm btn-success" >';
		}
		if(empty($preview)){
			$preview = "";
		} else {
			$preview = '<form method="POST" action="'.ADMIN_URL.'download.php" enctype="multipart/form-data">
							<input type="hidden" name="item_id" value="'.$item_id.'" >
							<input type="hidden" name="preview_file" value="'.$preview.'" >
							<input type="submit" name="SavePreviewfile" value="Download Preview" class="btn btn-sm btn-success" >';
		}
		if(empty($thumbnail)){
			$thumbnail = "";
		} else {
			$thumbnail = '<form method="POST" action="'.ADMIN_URL.'download.php" enctype="multipart/form-data">
							<input type="hidden" name="item_id" value="'.$item_id.'" >
							<input type="hidden" name="thumbnail_file" value="'.$thumbnail.'" >
							<input type="submit" name="SaveThumbnailfile" value="Download Thumbnail" class="btn btn-sm btn-success" >';
		}
		
		if($statuss == 1) {
			// Deactivate Item
			$statuss = "<b class='text-success'>Active</b>";
			$activate_deactivate = '<button type="button" name="changeItemStatus" id="'.$item_id.'" class="btn btn-danger btn-sm changeItemStatus" data-status="0"><i class="fa fa-ban"></i></button>';
		} else {
			// Activate Item
			$statuss = "<b class='text-danger'>Deactive</b>";
			$activate_deactivate = '<button type="button" name="changeItemStatus" id="'.$item_id.'" class="btn btn-success btn-sm changeItemStatus" data-status="1"><i class="fa fa-check"></i></button>';
		}
		$editItem = '<a href="'.ADMIN_URL.'upload.php?item_id='.$item_id.'" class="btn btn-sm btn-info">Edit</a>';
		$output['data'][] = array( 	
		$sum,	
		$c_id,
		$c_name,
		$s_id,
		$s_name,
		$ch_id,
		$ch_name,
		$item_id,
		$item_name,
		$sale,
		$rating,
		$rated_by,
		$item_tags,
		$regular_price,
		$extended_price,
		$created_date,
		$updated_date,
		$statuss,
		$featured,
		$wasfeatured,
		$makeFeatured,
		$editItem,
		$activate_deactivate,
		$thumbnail,
		$preview,
		$mainfile,
		$screenshot
		); 	
	}
}
echo json_encode($output);
?>