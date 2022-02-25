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
if($_POST['sub_submit_pr']){
	if($_POST['sub_submit_pr'] == 'Submit') {
		$adminEmail = filter_var($_POST['adminEmail'], FILTER_SANITIZE_EMAIL) ;
		$email_comment = filter_var($_POST['email_comment'], FILTER_SANITIZE_NUMBER_INT) ;
		$rec_email_comment = filter_var($_POST['rec_email_comment'], FILTER_SANITIZE_NUMBER_INT) ;
		$pay_email = filter_var($_POST['pay_email'], FILTER_SANITIZE_NUMBER_INT) ;
		$mainfile_email = filter_var($_POST['mainfile_email'], FILTER_SANITIZE_NUMBER_INT) ;
		$rating_email = filter_var($_POST['rating_email'], FILTER_SANITIZE_NUMBER_INT) ;
		$chance = filter_var($_POST['chance'], FILTER_SANITIZE_NUMBER_INT) ;
		$msg = filter_var($_POST['msg'], FILTER_SANITIZE_STRING) ;
		$statement = $pdo->prepare("update ot_admin set rec_email = '".$adminEmail."' , email_comment = '".$email_comment."'  , rec_email_comment = '".$rec_email_comment."' , pay_email = '".$pay_email."' , mainfile_email = '".$mainfile_email."' , user_chance = '".$chance."' , unblock_msg = '".$msg."' , rating_email = '".$rating_email."'  where id = '1'");
		$statement->execute() ;
		$form_message = "Settings Updated Successfully.";
		$output = array( 
						'form_message' => $form_message
					) ;
		echo json_encode($output);
		
	}
} 
?>
