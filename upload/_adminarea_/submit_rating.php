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

if(isset($_POST['btn_action_sb_edit']))
{
	if($_POST['btn_action_sb_edit'] == 'EditSubmit')
	{
		if( isset($_POST['subRate']) && isset($_POST['userid']) && isset($_POST['itemId']) && isset($_POST['itempId']) ){
			$itempId = filter_var($_POST['itempId'], FILTER_SANITIZE_NUMBER_INT) ;
			$itemId = filter_var($_POST['itemId'], FILTER_SANITIZE_NUMBER_INT) ;
			$userid = filter_var($_POST['userid'], FILTER_SANITIZE_NUMBER_INT) ;
			$subRate = filter_var($_POST['subRate'], FILTER_SANITIZE_STRING) ;
			$itemReview = filter_var($_POST['itemReview'], FILTER_SANITIZE_STRING) ;
			$oldRating = filter_var($_POST['oldRating'], FILTER_SANITIZE_STRING);
			$date = date("Y-m-d") ;
			//Update Rating into Database
			$ins = $pdo->prepare("update item_rating set item_star = '".$subRate."' , item_rating_description = '".$itemReview."' where item_rating_id = '".$itempId."'");
			$ins->execute() ;
			
			$fetch_image = $pdo->prepare("select * from item_db where item_Id = ?");
			$fetch_image->execute(array($itemId));
			$imageData = $fetch_image->fetchAll(PDO::FETCH_ASSOC);
			foreach($imageData as $row) {
				$rate = _e($row['item_rating']);
				$people = _e($row['item_rated_by']) ;
				$item_star_count = _e($row['item_star_count']);
			}
			$rate = $rate + $subRate ;
			$rate = _e(number_format($rate,2)) ;
			$item_star_count = ($item_star_count + $subRate) - $oldRating ;
			$rating = _e(number_format($item_star_count/$people,2)) ; 
			
			//Save New Rating into Database
			$statement = $pdo->prepare("update item_db set item_star_count = '".$item_star_count."' , item_rating = '".$rating."' where item_Id = '".$itemId."'") ;
			$statement->execute();
			$output = '';
			$form_message = "Rating has been edited.";
			$output = array( 
							'form_message' => $form_message
							) ;
			echo json_encode($output);
		}
	} else {
		echo "Error in Edit Rating. Try Again." ;
	}
	if($_POST['btn_action_sb_edit'] == 'revokeRight')
	{
		$itempId = filter_var($_POST['itempId'], FILTER_SANITIZE_NUMBER_INT);
		$status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
		if($itempId) { 
			$update = $pdo->prepare("UPDATE item_rating SET rating_rights_revoke=?   WHERE item_rating_id=?");
			$result_new = $update->execute(array($status,$itempId));
			if($result_new) {
				echo 'Rating Revoke Rights status has been changed .' ;		
			}
		}
	}
}
?>