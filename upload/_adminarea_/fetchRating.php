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
$Statement = $pdo->prepare("SELECT * FROM item_rating WHERE 1 order by item_rating_id desc ");
$Statement->execute(); 
$total = $Statement->rowCount();    
$result = $Statement->fetchAll(PDO::FETCH_ASSOC); 
$sum = 0 ;
$output = array('data' => array());
if($total > 0) {
	$active = "";
	foreach($result as $row) {
		$sum = $sum + 1 ;
		$id = _e($row['item_rating_id']);
		$itemId = _e($row['item_rating_itemid']) ;
		$uid = _e($row['item_u_id']) ;
		$username = get_userfullname_byid($pdo,$uid) ;
		$useremail = get_useremail_byid($pdo,$uid);
		$viewItem = '<a href="'.BASE_URL.'item/'.$itemId.'" target="_blank" class="btn btn-sm btn-light" ><i class="fa fa-eye"></i></a>';
		$userRating = '<i class="fa fa-star text-warning"></i> '._e($row['item_star']) ; 
		$itemTotalRating = get_item_rating($pdo,$itemId) ;
		$userComment = strip_tags($row['item_rating_description']) ;
		$itemRatedBy = get_item_ratedby($pdo,$itemId) ;
		$revokeRight =  _e($row['rating_rights_revoke']) ;
		if($revokeRight == '0') {
			$revokeRight = '<button class="btn btn-sm btn-danger revokeRight" id="'.$id.'" name="revokeRight" data-status="1">RevokeRight</button>';
		} else {
			$revokeRight = '<button class="btn btn-sm btn-success revokeRight" id="'.$id.'" name="revokeRight" data-status="0">DeRevokeRight</button>';
		}
		$editrating = '<button class="btn btn-sm btn-success editRating" id="'.$id.'" name="editRating">EditRating</button>';
		$itemName = get_item_title($pdo,$itemId);
		$itemThumbnail = get_item_small_thumbnail($pdo,$itemId) ;
		$itemRating = get_item_rating($pdo,$itemId) ;
		$output['data'][] = array( 		
		$sum,
		$itemThumbnail,
		$itemId,
		$itemName,
		$itemTotalRating,
		$itemRatedBy,
		$viewItem,
		$username,
		$useremail,
		$userRating,
		$userComment,
		$editrating ,
		$revokeRight
		); 	
	}
}
echo json_encode($output);
?>