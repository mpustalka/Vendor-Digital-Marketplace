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
if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'save_page')
	{
		if(!empty($_POST['page_name']) && !empty($_POST['page_slug']) && !empty($_POST['page_content']) ) {
			$pageName = filter_var($_POST['page_name'] , FILTER_SANITIZE_STRING) ;
			$pageSlug = filter_var(strtolower($_POST['page_slug']) , FILTER_SANITIZE_STRING) ;
			$pageContent = base64_encode($_POST['page_content']) ;
			$pageContent = filter_var($pageContent , FILTER_SANITIZE_STRING) ;
			$checkSlug = check_page_slug($pdo,$pageSlug) ;
			if($checkSlug == '1') {
				$error = 2 ;
				echo $error ;
			} else {
				$ins = $pdo->prepare("insert into ot_admin_pages (page_name, page_slug, page_text) values (?,?,?)") ;
				$ins->execute(array($pageName, $pageSlug, $pageContent));
				if($ins) {
					$error = 0 ;
					echo $error ;
				}
			}
		} else {
			$error = 1 ;
			echo $error ;
		}
	}
	if($_POST['btn_action'] == 'edit_page')
	{
		if(!empty($_POST['page_name']) && !empty($_POST['page_slug']) && !empty($_POST['page_content']) && !empty($_POST['pageId']) ) {
			$pageId = filter_var($_POST['pageId'], FILTER_SANITIZE_NUMBER_INT) ;
			$pageName = filter_var($_POST['page_name'] , FILTER_SANITIZE_STRING) ;
			$pageSlug = filter_var(strtolower($_POST['page_slug']) , FILTER_SANITIZE_STRING) ;
			$pageContent = base64_encode($_POST['page_content']) ;
			$pageContent = filter_var($pageContent , FILTER_SANITIZE_STRING) ;
			$checkSlug = check_page_slug_byId($pdo,$pageSlug,$pageId) ;
			if($checkSlug == '1') {
				$error = 2 ;
				echo $error ;
			} else {
				$ins = $pdo->prepare("update ot_admin_pages set page_name = ? , page_slug = ?, page_text = ? where page_id = '".$pageId."'") ;
				$ins->execute(array($pageName, $pageSlug, $pageContent));
				if($ins) {
					$error = 0 ;
					echo $error ;
				}
			}
		} else {
			$error = 1 ;
			echo $error ;
		}
	}
	
	if($_POST['btn_action'] == 'changePageStatus')
	{
		if(!empty($_POST['id']) ){
			$pageId = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT) ;
			$status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT) ;
			$upd = $pdo->prepare("update ot_admin_pages set page_status = '".$status."' where page_id = '".$pageId."'") ;
			$upd->execute();
			if($upd) {
				echo "Page Status has been changed successfully.";
			}
		} else {
			echo "Page ID is mandatory to Change Status of Page. Try Again.";
		}
	}
	
	if($_POST['btn_action'] == 'changeUserStatus')
	{
		if(!empty($_POST['id']) ){
			$userId = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT) ;
			$status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT) ;
			$upd = $pdo->prepare("update ot_user set user_blocked = '".$status."' , user_status ='0' where user_id = '".$userId."'") ;
			$upd->execute();
			if($upd) {
				echo "User Block Status has been changed successfully.";
			} else {
				echo "Some Problem";
			}
		} else {
			echo "User ID is mandatory to Change Block Status of PaUserge. Try Again.";
		}
	}
}
?>