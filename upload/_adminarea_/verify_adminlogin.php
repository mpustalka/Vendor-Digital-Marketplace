<?php
ob_start();
session_start();
require_once('db/config.php');
require_once("db/function_xss.php");
$err = 0;
if( !empty($_POST['email']) && !empty($_POST['password']) ){
		 $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) ;
		 $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
		 $checkUser =  $pdo->prepare("SELECT * FROM ot_admin WHERE adm_email=?");
		 $checkUser->execute(array($email));
		 $user_ok = $checkUser->rowCount();
		 $user_data = $checkUser->fetchAll(PDO::FETCH_ASSOC);
		 //check mobile & password is correct and user is active
		 if($user_ok > 0){
			foreach($user_data as $row){
				$auth_pass = _e($row['adm_password']);
			}
			if(password_verify($password, $auth_pass)) {
				$err = 1 ;
				echo $err ;
				$_SESSION['admin'] = $row;
			} else {
				echo $err ; 
			}
		}
} else {
header("location: ".ADMIN_URL."login.php");
}
?>