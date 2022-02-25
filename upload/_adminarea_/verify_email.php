<?php
ob_start();
session_start();
require_once('db/config.php');
require_once("db/function_xss.php");
$admin = $pdo->prepare("SELECT * FROM ot_admin WHERE id=?");
$admin->execute(array(filter_var("1", FILTER_SANITIZE_NUMBER_INT)));   
$admin_result = $admin->fetchAll(PDO::FETCH_ASSOC);
foreach($admin_result as $adm) {
//escape admin email
	$admin_email   = _e($adm['adm_email']);
}
$err = 0 ;
$headers = "";
	if( !empty($_POST['email']) ) {
		$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) ;
		//first we check email is registered and active
		$checkUser =  $pdo->prepare("SELECT * FROM ot_admin WHERE adm_email = ? ");
		$checkUser->execute(array($email));
		$user_ok = $checkUser->rowCount();
		$user_data = $checkUser->fetchAll(PDO::FETCH_ASSOC);
		if($user_ok > 0) {
			$otp = filter_var(code(4), FILTER_SANITIZE_NUMBER_INT);
			$to = $email ;
			$headers .= 'MIME-Version: 1.0' . "\r\n" ;
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n" ; 
			$headers .=  "\r\n" ; 
			$subject = "Forgot Password OTP" ;
			$body = "<br>Forgot Password OTP is <br><h3>".$otp."</h3><br>Please Do not share with anyone at any cost.";
			if (mail($to, $subject, $body, $headers)){
				$update_user_otp = $pdo->prepare("UPDATE ot_admin SET otp=? WHERE id='1'");
				$update_user_otp->execute(array($otp));
				$err = $email ;
				echo $err ;
			}
		} else {
			echo $err ;
		}
	
	} else {
		header("location: ".ADMIN_URL."login.php");
	}

?>
