<?php
ob_start();
session_start();
include("_adminarea_/db/config.php");
include("_adminarea_/db/function_xss.php");
$err = 0 ;
$headers = "";
	if( !empty($_POST['email']) ) {
		$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) ;
		//first we check  email is correct or not
		$checkUser =  $pdo->prepare("SELECT * FROM ot_user WHERE user_email = ? and user_blocked = '0'");
		$checkUser->execute(array($email));
		$user_ok = $checkUser->rowCount();
		$user_data = $checkUser->fetchAll(PDO::FETCH_ASSOC);
		if($user_ok > 0) {
			$otp = filter_var(code(4), FILTER_SANITIZE_NUMBER_INT);
			$msg = "".$otp." is your OTP for Verification.";
			$update_user_otp = $pdo->prepare("UPDATE ot_user SET user_otp=? WHERE user_email=?");
			$update_user_otp->execute(array($otp,$email));
			//send OTP on  Email
			$to = $email ;
			$subject = "Forgot Password OTP" ;
			$headers .= 'MIME-Version: 1.0' . "\r\n" ;
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n" ; 
			$headers .= "X-Priority: 1 (Highest)\n";
			$headers .= "X-MSMail-Priority: High\n";
			$headers .= "Importance: High\n";
			$body = "<html><body><h3>OTP : ".$otp."</h3><br><b>Never share your OTP with Anyone.</b><br></body></html>";
			$mail_result = mail($to, $subject, $body, $headers);
			$err = $email ;
			echo $err ;
		} else {
			echo $err ;
		}
	
	} else {
		header('location: '.BASE_URL.'logout.php');
	}


?>