<?php
ob_start();
session_start();
include("db/config.php");
include("db/function_xss.php");
// Checking Admin is logged in or not
if(!isset($_SESSION['admin'])) {
	header("location: login.php"); 
	exit;
} 
if($_POST['email_submit_pr']){
	if($_POST['email_submit_pr'] == 'Submit') {
		$oldpass = filter_var($_POST['passw'], FILTER_SANITIZE_STRING) ;
		$newemail = filter_var($_POST['newemail'], FILTER_SANITIZE_EMAIL) ;
		$id = filter_var($_POST['uid'], FILTER_SANITIZE_NUMBER_INT) ;
		$statement = $pdo->prepare("select * from ot_admin where id = ?");
		$statement->execute(array($id)) ;
		$result = $statement->fetchAll(PDO::FETCH_ASSOC); 
		$user_ok = $statement->rowCount();
		if($user_ok > 0) {
			foreach($result as $row){
				$auth_pass = _e($row['adm_password']) ;
			}
			//validate password
			if(password_verify($oldpass, $auth_pass)) {
					$update_password = $pdo->prepare("update ot_admin set adm_email = ? where id = ?");
					$update_password->execute(array($newemail,$id));
					$form_message = "Email Updated Successfully.";
					$output = array( 
							'form_message' => $form_message
							) ;
					echo json_encode($output);
				
			} else {
				$form_message = "Password is wrong. Try Again.";
				$output = array( 
						'form_message' => $form_message
						) ;
				echo json_encode($output);
			}
		} else {
			$form_message = "This is not authorized admin.";
			$output = array( 
					'form_message' => $form_message
					) ;
			echo json_encode($output);
		}
	}
} 
?>