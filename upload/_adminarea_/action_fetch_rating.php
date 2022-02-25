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

if(isset($_POST['btn_action_view']))
{
	if($_POST['btn_action_view'] === 'fetch_rating')
	{
		if( isset($_POST['itempId'])){
			$itempId = filter_var($_POST['itempId'], FILTER_SANITIZE_NUMBER_INT) ;
			$fetch_item = $pdo->prepare("select * from item_rating where item_rating_id = ?");
			$fetch_item->execute(array($itempId));
			$itemData = $fetch_item->fetchAll(PDO::FETCH_ASSOC);
			foreach($itemData as $row) {
				$comment = strip_tags($row['item_rating_description']) ;
				$rating = _e($row['item_star']);
				$output['itempId'] = _e($row['item_rating_id']) ;
				$output['itemId'] = _e($row['item_rating_itemid']) ;
				$output['comment'] = $comment ;
				$output['rating'] = $rating ;
				$output['userid'] = _e($row['item_u_id']) ;
			}
			
			echo json_encode($output);
		}
	}
}
?>