<?php
ob_start();
session_start();
include("_adminarea_/db/config.php");
include("_adminarea_/db/function_xss.php");
$err = 0 ;
	if( !empty($_POST['email']) && !empty($_POST['otp']) ){
		$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) ;
		$otp = filter_var($_POST['otp'], FILTER_SANITIZE_NUMBER_INT) ;
		$otpAuthentication =  $pdo->prepare("SELECT * FROM ot_user WHERE user_email=? and user_otp=?");
		$otpAuthentication->execute(array($email,$otp));
		$otp_ok = $otpAuthentication->rowCount();
		$userData = $otpAuthentication->fetchAll(PDO::FETCH_ASSOC);
		if($otp_ok > 0) {
			$err = $email ;
			echo $err ;
		}
		else {
			echo $err ;
		}
	
	} else {
		header('location: '.BASE_URL.'logout.php');
	}

?>