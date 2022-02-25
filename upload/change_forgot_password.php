<?php
ob_start();
session_start();
include("_adminarea_/db/config.php");
$err = 0;
if( !empty($_POST['email']) && !empty($_POST['newpassword']) && !empty($_POST['confirmnewpassword'])){
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) ;
	$newpassword = filter_var($_POST['newpassword'], FILTER_SANITIZE_STRING);
	$confirmnewpassword = filter_var($_POST['confirmnewpassword'], FILTER_SANITIZE_STRING) ;
	$uppercase = preg_match('@[A-Z]@', $newpassword);
	$lowercase = preg_match('@[a-z]@', $newpassword);
	$number    = preg_match('@[0-9]@', $newpassword);
	//validate password
	if(!$uppercase || !$lowercase || !$number || strlen($newpassword) < 8) {
		echo $err ;
	} else {
		//check password and confirm password are same
		if($newpassword == $confirmnewpassword) {
			$update_user_otp = $pdo->prepare("UPDATE ot_user SET user_pass=? , user_otp = ? WHERE user_email=?");
			$update_user_otp->execute(array(password_hash($newpassword, PASSWORD_DEFAULT),NULL,$email));
			$err = 2 ;
			echo $err ;
		
		} else {
			$err = 1 ;
			echo $err ;
		}
	
	}

} else {
	header('location: '.BASE_URL.'logout.php');
}
?>