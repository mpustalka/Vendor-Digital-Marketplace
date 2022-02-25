<?php
ob_start();
session_start();
include("_adminarea_/db/config.php");
include("_adminarea_/db/function_xss.php");
// Checking User is logged in or not
if(!isset($_SESSION['user'])) {
	header('location: '.BASE_URL.'logout.php');
	exit;
}
if($_POST['verify_otp']){
	if($_POST['verify_otp'] == 'Submit') {
		$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) ;
		$otp = filter_var($_POST['otp'], FILTER_SANITIZE_NUMBER_INT) ;
		$statement = $pdo->prepare("select * from ot_user where user_email = '".$email."'");
		$statement->execute() ;
		$chance_ok = $statement->rowCount();
		$userData = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach ($userData as $data) {
			$chance = _e($data['u_chance']) ;
		}
		if($chance > '0') {
			$statementNew = $pdo->prepare("select * from ot_user where user_otp = '".$otp."' and user_email = '".$email."'");
			$statementNew->execute() ;
			$verify_ok = $statementNew->rowCount();
			if($verify_ok > 0) {
				$updUserStatus = $pdo->prepare("update ot_user set user_status='1' where user_email = '".$email."'");
				$updUserStatus->execute();
				$output = array( 
								'err' => '0'
							) ;
				echo json_encode($output);
			} else {
				$chance = $chance - 1 ;
				if($chance == '0') {
					$block = $pdo->prepare("update ot_user set u_chance = '".$chance."' , user_blocked ='1' where  user_email = '".$email."'");
					$block->execute() ;
					$output = array( 
									'err' => '1'
								) ;
					echo json_encode($output);
				} else {
					$upd = $pdo->prepare("update ot_user set u_chance = '".$chance."' where user_email = '".$email."'");
					$upd->execute();
					$form_message = "You have only ".$chance." chance left. After that you'll be Permanently Blocked.";
					$output = array( 
									'form_message' => $form_message,
									'err' => '2',
									'chance' => $chance
								) ;
					echo json_encode($output);
				}
			}
		} else {
			$block = $pdo->prepare("update ot_user set user_blocked ='1' where  user_email = '".$email."'");
			$block->execute() ;
			$output = array( 
							'err' => '1'
						) ;
			echo json_encode($output);
		}
		
	}
} 
?>

