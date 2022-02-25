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
		$fileName = get_item_mainfile_name($pdo,$itemId) ; 
		if(empty($fileName)){
			$fileName = "<b class='text-danger'>Item has been removed or deactivated.</b>";
			$viewItem = "";
			$myRating = "";
			$giverating = "";
			$myComment = "";
		} else {
			$fileName = '<form method="POST" action="'.BASE_URL.'downloadItem.php" enctype="multipart/form-data">
							<input type="hidden" name="item_id" value="'.$itemId.'" >
							<input type="hidden" name="main_file" value="'.$fileName.'" >
							<input type="submit" name="SaveMainfile" value="Download" class="btn btn-sm btn-success" >';
			$viewItem = '<a href="'.BASE_URL.'item/'.$itemId.'" target="_blank" class="btn btn-sm btn-light" ><i class="fa fa-eye"></i></a>';
			$myRating = get_item_rating_byuser($pdo,$itemId,$_SESSION['user']['user_id']) ;
			$myComment = get_item_ratingcomment_byuser($pdo,$itemId,$_SESSION['user']['user_id']) ;
			if(check_item_rating_byuser($pdo,$itemId,$_SESSION['user']['user_id']) > 0) {
			$revokeRight = check_revoke_right_of_user($pdo,$itemId) ;
				if($revokeRight == '0'){
					$giverating = '<button class="btn btn-sm btn-success editRating" id="'.$itemId.'" name="editRating">EditRating</button>';
				} else {
					$giverating = "";
				}
			} else {
				$giverating = '<button class="btn btn-sm btn-success openRating" id="'.$itemId.'" name="openRating">RateNow</button>';
			}
		}
		$itemName = get_item_title($pdo,$itemId);
		
		$itemThumbnail = get_item_small_thumbnail($pdo,$itemId) ;
		$itemRating = get_item_rating($pdo,$itemId) ;
		
		
		
		if(empty($myRating)){
			$myRating = "" ;
		}
		
		$output['data'][] = array( 		
		$sum,
		$itemThumbnail,
		$itemName,
		$itemRating,
		$viewItem,
		$fileName,
		$myRating,
		$myComment,
		$giverating
		); 	
	}
}
echo json_encode($output);
?>