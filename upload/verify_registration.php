<?php
ob_start();
session_start();
require_once('_adminarea_/db/config.php');
require_once("_adminarea_/db/function_xss.php");
$admin = $pdo->prepare("SELECT * FROM ot_admin WHERE id = ?");
$admin->execute(array("1"));   
$admin_result = $admin->fetchAll(PDO::FETCH_ASSOC);
$total = $admin->rowCount();
foreach($admin_result as $adm) {
//escape all  data
	$user_chance = _e($adm['user_chance']) ;
}
$headers = "";
$err = '0' ;
	//check username, email, password & confirm password should not be empty
	if( !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['repassword']) ){
		$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING) ;
		$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) ;
		$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING) ;
		$repassword = filter_var($_POST['repassword'], FILTER_SANITIZE_STRING) ;
		$uppercase = preg_match('@[A-Z]@', $password);
		$lowercase = preg_match('@[a-z]@', $password);
		$number    = preg_match('@[0-9]@', $password);
		//validate password
		if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
		  $_SESSION['error_message'] = 'Password must contain 8 characters, an uppercase character, a lowercase character & atleast 1 number. Try Again';
		  $err = 1 ;
		  echo $err ;
		} else {
			//check password and confirm password are same
			if($password == $repassword) {
				//checking database for already registered email
				$checkUser =  $pdo->prepare("SELECT * FROM ot_user WHERE user_email=?");
		 		$checkUser->execute(array($email));
		 		$user_ok = $checkUser->rowCount();
				if($user_ok > 0) {
					$err = 3 ;
		 		    echo $err ;
				} else {
					
					$date = date('Y-m-d') ;
					$otp = filter_var(code(4), FILTER_SANITIZE_NUMBER_INT) ;
					$to = $email ;
					$headers .= 'MIME-Version: 1.0' . "\r\n" ;
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n" ; 
					$headers .= $from . "\r\n" ; 
					$subject = "SignUp OTP" ;
					$body = "<br>Sign Up OTP is <br><h3>".$otp."</h3><br>Verify your account now & Please Do not share with anyone at any cost.";
					if (mail($to, $subject, $body, $headers))
					{
						//first user status is unverified until they verify OTP
						$ins_in = $pdo->prepare("INSERT INTO ot_user (user_name, user_email, user_pass, user_otp, register_date, u_chance, user_status) VALUES (?,?,?,?,?,?,?)");
						$ins_in->execute(array($username,$email,password_hash($password, PASSWORD_DEFAULT),$otp,$date,$user_chance,'0'));
						//create user session
					if($ins_in) {
						$statement_active = $pdo->prepare("SELECT * FROM ot_user WHERE user_email=?");
						$statement_active->execute(array($email));   
						$result_active = $statement_active->fetchAll(PDO::FETCH_ASSOC);
						foreach($result_active as $row)
							{
								$_SESSION['user'] = $row;
							}
					}
						$output = array( 
									'error'       => 0
								) ;
						echo json_encode($output);
					}
				
				}
			} else {
				$err = 2 ;
				echo $err ;
			}
		}
	
	} else {
		header("location: index.php");
	}

?>