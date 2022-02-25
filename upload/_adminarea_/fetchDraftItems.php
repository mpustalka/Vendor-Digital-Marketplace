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
$Statement = $pdo->prepare("SELECT * FROM item_db WHERE item_status='0' order by item_id desc");
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
		} else {
			// Activate Item
			$statuss = "<b class='text-danger'>Deactive</b>";
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
		$item_tags,
		$regular_price,
		$extended_price,
		$created_date,
		$updated_date,
		$statuss,
		$editItem,
		$thumbnail,
		$preview,
		$mainfile,
		$screenshot
		); 	
	}
}
echo json_encode($output);
?>