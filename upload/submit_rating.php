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
$admin = $pdo->prepare("SELECT * FROM ot_admin WHERE id = '1'");
$admin->execute();   
$admin_result = $admin->fetchAll(PDO::FETCH_ASSOC);
$total = $admin->rowCount();
foreach($admin_result as $adm) {
//escape all  data
	$rating_email = _e($adm['rating_email']);
	$rec_email = _e($adm['rec_email']);
}
$headers = "";
if(isset($_POST['btn_action_sb']))
{
	if($_POST['btn_action_sb'] == 'Submit')
	{
		if( isset($_POST['subRate']) && isset($_POST['userid']) && isset($_POST['itemId']) ){
			$itemId = filter_var($_POST['itemId'], FILTER_SANITIZE_NUMBER_INT) ;
			$userid = filter_var($_POST['userid'], FILTER_SANITIZE_NUMBER_INT) ;
			$subRate = filter_var($_POST['subRate'], FILTER_SANITIZE_NUMBER_INT) ;
			$itemReview = filter_var($_POST['itemReview'], FILTER_SANITIZE_STRING) ;
			$date = date("Y-m-d") ;
			//Save User ID into Database
			$ins = $pdo->prepare("insert into item_rating (item_rating_itemid, item_u_id, item_star, item_rating_date, item_rating_description) values('".$itemId."', '".$userid."', '".$subRate."', '".$date."', '".$itemReview."')");
			$ins->execute() ;
			
			$fetch_image = $pdo->prepare("select * from item_db where item_Id = ?");
			$fetch_image->execute(array($itemId));
			$imageData = $fetch_image->fetchAll(PDO::FETCH_ASSOC);
			foreach($imageData as $row) {
				$people = _e($row['item_rated_by']) ;
				$rate = _e($row['item_rating']);
				$item_star_count = _e($row['item_star_count']);
			}
			$people = $people + 1 ;
			$rate = $rate + $subRate ;
			$item_star_count = $item_star_count + $subRate ;
			$rating = _e(number_format($rate/$people,2)) ; 
			
			//Save New Rating into Database
			$statement = $pdo->prepare("update item_db set item_rated_by = '".$people."' , item_rating = '".$rating."', item_star_count = '".$item_star_count."' where item_Id = '".$itemId."'") ;
			$statement->execute();
			$output = '';
			$form_message = "Your Rating has been live. Thanks for your valuable time.";
			$output = array( 
							'form_message' => $form_message,
							'itemId' => $itemId,
							'rating' => $rating,
							'people' => $people
							) ;
			echo json_encode($output);
			
			if($rating_email == '1') {
				$userName = get_userfullname_byid($pdo,$userid) ;
				$userEmail = get_useremail_byid($pdo,$userid) ;
				$itemName = get_item_title($pdo,$itemId) ;
				$webUrl = BASE_URL.'item/'.$itemId ;
				$to = $rec_email ;
				$subject = "New Rating on Item" ;
				$from = "User Email: ".$userEmail ;
				$headers .= 'MIME-Version: 1.0' . "\r\n" ;
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n" ; 
				$headers .= "X-Priority: 1 (Highest)\n";
				$headers .= "X-MSMail-Priority: High\n";
				$headers .= "Importance: High\n";
				include("email_for_rating.php");
				$mail_result = mail($to, $subject, $body, $headers);
			}
		}
	} else {
		echo "Error in Submit. Try Again." ;
	}
	
	
}
if(isset($_POST['btn_action_sb_edit']))
{
	if($_POST['btn_action_sb_edit'] == 'EditSubmit')
	{
		if( isset($_POST['subRate']) && isset($_POST['userid']) && isset($_POST['itemId']) ){
			$itemId = filter_var($_POST['itemId'], FILTER_SANITIZE_NUMBER_INT) ;
			$userid = filter_var($_POST['userid'], FILTER_SANITIZE_NUMBER_INT) ;
			$subRate = filter_var($_POST['subRate'], FILTER_SANITIZE_STRING) ;
			$itemReview = filter_var($_POST['itemReview'], FILTER_SANITIZE_STRING) ;
			$oldRating = filter_var($_POST['oldRating'], FILTER_SANITIZE_STRING);
			$date = date("Y-m-d") ;
			//Update Rating into Database
			$ins = $pdo->prepare("update item_rating set item_star = '".$subRate."' , item_rating_description = '".$itemReview."' where item_rating_itemid = '".$itemId."' and item_u_id = '".$userid."'");
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
			$form_message = "Your Rating has been edited. Thanks for your valuable time.";
			$output = array( 
							'form_message' => $form_message
							) ;
			echo json_encode($output);
			if($rating_email == '1') {
				$userName = get_userfullname_byid($pdo,$userid) ;
				$userEmail = get_useremail_byid($pdo,$userid) ;
				$itemName = get_item_title($pdo,$itemId) ;
				$webUrl = BASE_URL.'item/'.$itemId ;
				$to = $rec_email ;
				$subject = "User Edit Rating of an Item" ;
				$from = "User Email: ".$userEmail ;
				$headers .= 'MIME-Version: 1.0' . "\r\n" ;
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n" ; 
				$headers .= "X-Priority: 1 (Highest)\n";
				$headers .= "X-MSMail-Priority: High\n";
				$headers .= "Importance: High\n";
				include("email_for_rating.php");
				$mail_result = mail($to, $subject, $body, $headers);
			}
		}
	} else {
		echo "Error in Edit Rating. Try Again." ;
	}
}
?>