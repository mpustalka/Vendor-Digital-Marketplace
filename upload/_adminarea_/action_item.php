<?php
ob_start();
session_start();
include("db/config.php");
include("db/function_xss.php") ;
// Checking Admin is logged in or not
if(!isset($_SESSION['admin'])) {
	header("location: ".ADMIN_URL."login.php");
	exit;
}
$error = 0 ;
if(isset($_POST['btn-action']))
{
	if($_POST['btn-action'] == 'save_step_1')
	{
		if(!empty($_POST['item_name']) && !empty($_POST['regular_amount']) && !empty($_POST['extended_amount']) &&  !empty($_POST['cat']) && !empty($_POST['item_message']) && !empty($_POST['item_tag']) ){
			$itemName = filter_var($_POST['item_name'], FILTER_SANITIZE_STRING) ;
			$itemTags = filter_var($_POST['item_tag'], FILTER_SANITIZE_STRING) ;
			$regularAmount = filter_var($_POST['regular_amount'], FILTER_SANITIZE_NUMBER_INT) ;
			$extendedAmount = filter_var($_POST['extended_amount'], FILTER_SANITIZE_NUMBER_INT) ;
			$categoryID = filter_var($_POST['cat'], FILTER_SANITIZE_NUMBER_INT) ;
			$subcategoryID = filter_var($_POST['subcat'], FILTER_SANITIZE_NUMBER_INT) ;
			if(empty($subcategoryID)){
				$subcategoryID = "";
			}
			$childcategoryID = filter_var($_POST['childcat'], FILTER_SANITIZE_NUMBER_INT) ;
			if(empty($childcategoryID)){
				$childcategoryID = "";
			}
			$demoLink = filter_var($_POST['demo_link'], FILTER_SANITIZE_URL);
			$you_vid = filter_var($_POST['youtube_link'], FILTER_SANITIZE_URL);
			$youtubeId = "";
			$itemDetails = base64_encode($_POST['item_message']) ;
			$itemDate = date("Y-m-d") ;
			$y_err = 0 ;
			if(!empty($you_vid)){
				if (preg_match("/(?:https?:\/\/)?(?:youtu\.be\/|(?:www\.|m\.)?youtube\.com\/(?:watch|v|embed)(?:\.php)?(?:\?.*v=|\/))([a-zA-Z0-9\-_]+)/", $you_vid) == 1){
			    	$y_err = 0 ;
			   } else {
			   		$y_err = 1;
			   }
				if($y_err == '0'){
					preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $you_vid, $matches);
					$youtubeId = $matches[1] ;
				}
			}
			if(($y_err == 0)) {
				$ins = $pdo->prepare("insert into item_db (item_name, regular_price, extended_price, main_category, sub_category, child_category, item_description, item_demo_link, item_youtube_link, item_youtube_id,item_tags,created_date, updated_date) values ('".$itemName."', '".$regularAmount."', '".$extendedAmount."', '".$categoryID."', '".$subcategoryID."', '".$childcategoryID."', '".$itemDetails."', '".$demoLink."', '".$you_vid."', '".$youtubeId."', '".$itemTags."', '".$itemDate."', '".$itemDate."')") ;
				$ins->execute();
				$statement = $pdo->query("SELECT LAST_INSERT_ID()");
				$item_id = $statement->fetchColumn();
				if(isset($itemTags)){
					$tags = explode(",", $itemTags);
					for ($x = 0; $x < count($tags); $x++){
						$insTag = $pdo->prepare("insert into ot_tags (tag_item_id, tag_name) values (?,?)");
						$insTag->execute(array($item_id,$tags[$x]));
					}
				}
				$output = array( 
							'error' => '0',
							'item_id' => $item_id
							) ;
				echo json_encode($output);
				$targetDir = "_item_secure_/".$item_id."/";  
				$targetMainDir = "_item_main_/".$item_id."/"; 
				if( is_dir($targetDir) === false )
				{
					mkdir($targetDir);
				}
				if( is_dir($targetMainDir) === false )
				{
					mkdir($targetMainDir);
				}
			} else {
				$error = 1 ;
				echo $error ;
			}
		} else {
			$error = 2 ;
			echo $error ;
		}
	}
	
	if($_POST['btn-action'] == 'edit_step_1')
	{
		if( !empty($_POST['item_id']) && !empty($_POST['item_name']) && !empty($_POST['regular_amount']) && !empty($_POST['extended_amount']) &&  !empty($_POST['cat']) && !empty($_POST['item_message']) && !empty($_POST['item_tag']) ){
			$item_id = filter_var($_POST['item_id'], FILTER_SANITIZE_NUMBER_INT) ;
			$itemName = filter_var($_POST['item_name'], FILTER_SANITIZE_STRING) ;
			$itemTags = filter_var($_POST['item_tag'], FILTER_SANITIZE_STRING) ;
			$regularAmount = filter_var($_POST['regular_amount'], FILTER_SANITIZE_NUMBER_INT) ;
			$extendedAmount = filter_var($_POST['extended_amount'], FILTER_SANITIZE_NUMBER_INT) ;
			$categoryID = filter_var($_POST['cat'], FILTER_SANITIZE_NUMBER_INT) ;
			$subcategoryID = filter_var($_POST['subcat'], FILTER_SANITIZE_NUMBER_INT) ;
			if(empty($subcategoryID)){
				$subcategoryID = "";
			}
			$childcategoryID = filter_var($_POST['childcat'], FILTER_SANITIZE_NUMBER_INT) ;
			if(empty($childcategoryID)){
				$childcategoryID = "";
			}
			$demoLink = filter_var($_POST['demo_link'], FILTER_SANITIZE_URL);
			$you_vid = filter_var($_POST['youtube_link'], FILTER_SANITIZE_URL);
			$youtubeId = "";
			$itemDetails = base64_encode($_POST['item_message']) ;
			$itemDate = date("Y-m-d") ;
			$y_err = 0 ;
			if(!empty($you_vid)){
				if (preg_match("/(?:https?:\/\/)?(?:youtu\.be\/|(?:www\.|m\.)?youtube\.com\/(?:watch|v|embed)(?:\.php)?(?:\?.*v=|\/))([a-zA-Z0-9\-_]+)/", $you_vid) == 1){
			    	$y_err = 0 ;
			   } else {
			   		$y_err = 1;
			   }
				if($y_err == '0'){
					preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $you_vid, $matches);
					$youtubeId = $matches[1] ;
				}
			}
			if(($y_err == 0)) {
				$ins = $pdo->prepare("update item_db set item_name = '".$itemName."' , regular_price = '".$regularAmount."', extended_price = '".$extendedAmount."' , main_category = '".$categoryID."' , sub_category = '".$subcategoryID."' , child_category = '".$childcategoryID."', item_description = '".$itemDetails."' , item_demo_link = '".$demoLink."' , item_youtube_link = '".$you_vid."' , item_youtube_id = '".$youtubeId."' ,item_tags = '".$itemTags."' , updated_date = '".$itemDate."' where item_id = '".$item_id."'") ;
				$ins->execute();
				
				$output = array( 
							'error' => '0',
							'item_id' => $item_id
							) ;
				echo json_encode($output);
				if(!empty($itemTags)){
					$delTag = $pdo->prepare("delete from ot_tags where tag_item_id = '".$item_id."'");
					$delTag->execute();
					$tags = explode(",", $itemTags);
					for ($x = 0; $x < count($tags); $x++){
						$insTag = $pdo->prepare("insert into ot_tags (tag_item_id, tag_name) values (?,?)");
						$insTag->execute(array($item_id,$tags[$x]));
					}
				}
				$targetDir = "_item_secure_/".$item_id."/";  
				$targetMainDir = "_item_main_/".$item_id."/"; 
				if( is_dir($targetDir) === false )
				{
					mkdir($targetDir);
				}
				if( is_dir($targetMainDir) === false )
				{
					mkdir($targetMainDir);
				}
			} else {
				$error = 1 ;
				echo $error ;
			}
		} else {
			$error = 2 ;
			echo $error ;
		}
	}
	
}
if(isset($_POST['btn-action-3']))
{
	if($_POST['btn-action-3'] == 'save_step_3')
	{
		if(!empty($_POST['item_id'])){
			$item_id= filter_var($_POST['item_id'], FILTER_SANITIZE_NUMBER_INT) ;
			$upd = $pdo->prepare("update item_db set item_status='1' where item_id = '".$item_id."'");
			$upd->execute();
		} 
	}
}
if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'load_subcategory')
		{
			echo fill_subcategory_list($pdo, filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT));
		}
	if($_POST['btn_action'] == 'load_childcategory')
		{
			echo fill_childcategory_list($pdo, filter_var($_POST['subcategory_id'], FILTER_SANITIZE_NUMBER_INT));
		}
	if($_POST['btn_action'] == 'changeItemStatus')
	{
		if(!empty($_POST['item_id'])){
			$item_id= filter_var($_POST['item_id'], FILTER_SANITIZE_NUMBER_INT) ;
			$upd = $pdo->prepare("update item_db set item_status='0' where item_id = '".$item_id."'");
			$upd->execute();
			echo "Item is inactive Now & Saved into Drafts.";
		}
	}
	if($_POST['btn_action'] == 'changeItemFeatureStatus')
	{
		if(!empty($_POST['item_id'])){
			$item_id= filter_var($_POST['item_id'], FILTER_SANITIZE_NUMBER_INT) ;
			$status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT) ;
			$upd = $pdo->prepare("update item_db set item_featured='".$status."', was_featured = '1' where item_id = '".$item_id."'");
			$upd->execute();
			echo "Item Featured Status changed Successfully.";
		}
	}
}
?>