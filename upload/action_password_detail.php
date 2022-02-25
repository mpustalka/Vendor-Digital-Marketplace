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
if($_POST['pass_submit_pr']){
	if($_POST['pass_submit_pr'] == 'Submit') {
		$oldpass = filter_var($_POST['oldpass'], FILTER_SANITIZE_STRING) ;
		$newpass = filter_var($_POST['newpass'], FILTER_SANITIZE_STRING) ;
		$repass = filter_var($_POST['repass'], FILTER_SANITIZE_STRING) ;
		$id = filter_var($_POST['uid'], FILTER_SANITIZE_NUMBER_INT) ;
		$uppercase = preg_match('@[A-Z]@', $newpass);
		$lowercase = preg_match('@[a-z]@', $newpass);
		$number    = preg_match('@[0-9]@', $newpass);
		$statement = $pdo->prepare("select * from ot_user where user_id = ?");
		$statement->execute(array($id)) ;
		$result = $statement->fetchAll(PDO::FETCH_ASSOC); 
		$user_ok = $statement->rowCount();
		if($user_ok > 0) {
			foreach($result as $row){
				$auth_pass = _e($row['user_pass']) ;
			}
			if(password_verify($oldpass, $auth_pass)) {
				if($newpass == $repass) {
					//validate password
					if(!$uppercase || !$lowercase || !$number || strlen($newpass) < 8) {
						$form_message = "Password must contain 8 characters, an uppercase character, a lowercase character & atleast 1 number. Try Again.";
						$output = array( 
								'form_message' => $form_message
								) ;
						echo json_encode($output);
					} else {
						$update_password = $pdo->prepare("update ot_user set user_pass = ? where user_id = ?");
						$update_password->execute(array(password_hash($newpass, PASSWORD_DEFAULT),$id));
						$form_message = "Password Updated Successfully.";
						$output = array( 
								'form_message' => $form_message
								) ;
						echo json_encode($output);
					}
				} else {
					$form_message = "Password & Confirm Password is not Match. Try Again.";
					$output = array( 
							'form_message' => $form_message
							) ;
					echo json_encode($output);
				}
			} else {
				$form_message = "Old Password is wrong. Try Again.";
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