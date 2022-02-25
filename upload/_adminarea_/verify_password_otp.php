<?php
ob_start();
session_start();
require_once('db/config.php');
$err = 0 ;
	if( !empty($_POST['email']) && !empty($_POST['otp']) ){
		$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) ;
		$otp = filter_var($_POST['otp'], FILTER_SANITIZE_NUMBER_INT) ;
		$otpAuthentication =  $pdo->prepare("SELECT * FROM ot_admin WHERE adm_email=? and otp=?");
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
		header("location: ".ADMIN_URL."login.php");
	}

?>