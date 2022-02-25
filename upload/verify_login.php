<?php
ob_start();
session_start();
include("_adminarea_/db/config.php");
include("_adminarea_/db/function_xss.php");
$err = 0;
if( !empty($_POST['email']) && !empty($_POST['password']) ){
		 $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) ;
		 $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
		 $checkUser =  $pdo->prepare("SELECT * FROM ot_user WHERE user_email=? and user_blocked=?");
		 $checkUser->execute(array($email,filter_var("0", FILTER_SANITIZE_NUMBER_INT)));
		 $user_ok = $checkUser->rowCount();
		 $user_data = $checkUser->fetchAll(PDO::FETCH_ASSOC);
		 //check mobile & password is correct and user is active
		 if($user_ok > 0){
			foreach($user_data as $row){
				$auth_pass = _e($row['user_pass']);
			}
			if(password_verify($password, $auth_pass)) {
				$err = 1 ;
				echo $err ;
				$_SESSION['user'] = $row;
			} else {
				echo $err ; 
			}
		} else {
			echo $err ; 
		}
}

?>