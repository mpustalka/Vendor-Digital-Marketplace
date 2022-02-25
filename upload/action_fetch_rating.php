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

if(isset($_POST['btn_action_view']))
{
	if($_POST['btn_action_view'] === 'fetch_data')
	{
		if( isset($_POST['itemId'])){
			$itemId = filter_var($_POST['itemId'], FILTER_SANITIZE_NUMBER_INT) ;
			$fetch_item = $pdo->prepare("select * from item_db where item_Id = ?");
			$fetch_item->execute(array($itemId));
			$itemData = $fetch_item->fetchAll(PDO::FETCH_ASSOC);
			
			$rating = 0 ;
			foreach($itemData as $row) {
				$people = _e($row['item_rated_by']) ;
				$rate = _e($row['item_rating']);
				if($rate != 0) {
					$rating = _e(number_format($rate/$people,2)) ;
				}
				$output['itemId'] = _e($row['item_Id']) ;
				$output['people'] = _e($people) ;
				$output['rate'] = _e($rate) ;
			}
			
			echo json_encode($output);
		}
	}
	if($_POST['btn_action_view'] === 'fetch_rating')
	{
		if( isset($_POST['itemId'])){
			$itemId = filter_var($_POST['itemId'], FILTER_SANITIZE_NUMBER_INT) ;
			$fetch_item = $pdo->prepare("select * from item_rating where item_rating_itemid = ? and item_u_id = '".$_SESSION['user']['user_id']."'");
			$fetch_item->execute(array($itemId));
			$itemData = $fetch_item->fetchAll(PDO::FETCH_ASSOC);
			foreach($itemData as $row) {
				$comment = strip_tags($row['item_rating_description']) ;
				$rating = _e($row['item_star']);
				
				$output['itemId'] = _e($row['item_rating_itemid']) ;
				$output['comment'] = $comment ;
				$output['rating'] = $rating ;
			}
			
			echo json_encode($output);
		}
	}
}
?>