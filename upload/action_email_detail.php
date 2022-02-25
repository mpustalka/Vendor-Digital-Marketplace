<?php
ob_start();
session_start();
include("_adminarea_/db/config.php");
include("_adminarea_/db/function_xss.php");
// Checking Admin is logged in or not
if(!isset($_SESSION['user'])) {
	unset($_SESSION['user']);
	header("location: ".BASE_URL."");
	exit;
}
if($_POST['email_submit_pr']){
	if($_POST['email_submit_pr'] == 'Submit') {
		$oldpass = filter_var($_POST['passw'], FILTER_SANITIZE_STRING) ;
		$newemail = filter_var($_POST['newemail'], FILTER_SANITIZE_EMAIL) ;
		$id = filter_var($_POST['uid'], FILTER_SANITIZE_NUMBER_INT) ;
		$statement = $pdo->prepare("select * from ot_user where user_id = ?");
		$statement->execute(array($id)) ;
		$result = $statement->fetchAll(PDO::FETCH_ASSOC); 
		$user_ok = $statement->rowCount();
		if($user_ok > 0) {
			foreach($result as $row){
				$auth_pass = _e($row['user_pass']) ;
			}
			//validate password
			if(password_verify($oldpass, $auth_pass)) {
				$chk_email = $pdo->prepare("select * from ot_user where user_email = ?");
				$chk_email->execute(array($newemail)) ;
				$email_ok = $chk_email->rowCount();
				if($email_ok > 0) {
					$form_message = "This Email is already exist. Try another.";
					$output = array( 
							'form_message' => $form_message
							) ;
					echo json_encode($output);
				} else {
					$update_password = $pdo->prepare("update ot_user set user_email = ? where user_id = ?");
					$update_password->execute(array($newemail,$id));
					$form_message = "Email Updated Successfully.";
					$output = array( 
							'form_message' => $form_message
							) ;
					echo json_encode($output);
				}
				
			} else {
				$form_message = "Password is wrong. Try Again.";
				$output = array( 
						'form_message' => $form_message
						) ;
				echo json_encode($output);
			}
		} else {
			$form_message = "This is not authorized user.";
			$output = array( 
					'form_message' => $form_message
					) ;
			echo json_encode($output);
		}
	}
} 
?>
