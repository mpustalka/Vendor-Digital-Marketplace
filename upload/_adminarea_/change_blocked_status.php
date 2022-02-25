<?php
ob_start();
session_start();
include("db/config.php");
include("db/function_xss.php");
// Checking Admin is logged in or not
if(!isset($_SESSION['admin'])) {
	header("location: ".ADMIN_URL."login.php");
	exit;
} 
$admin = $pdo->prepare("SELECT * FROM ot_admin WHERE id = '1'");
$admin->execute();   
$admin_result = $admin->fetchAll(PDO::FETCH_ASSOC);
$total = $admin->rowCount();
foreach($admin_result as $adm) {
//escape all  data
	$unblock_msg = strip_tags($adm['unblock_msg']);
	$chance = _e($adm['user_chance']);
}
$headers = "";
$otp = filter_var(code(4), FILTER_SANITIZE_NUMBER_INT) ;
$serverUrl = BASE_URL."login.php" ;
if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'changeBlockedStatus')
	{
		$email = filter_var($_POST['userId'], FILTER_SANITIZE_EMAIL);
		$status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
		if($email) { 
			
				$to = $email ;
				$subject = "Congratulations, You've Unblocked." ;
				$headers .= 'MIME-Version: 1.0' . "\r\n" ;
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n" ; 
				$headers .= "X-Priority: 1 (Highest)\n";
				$headers .= "X-MSMail-Priority: High\n";
				$headers .= "Importance: High\n";
				$body = "<html><body><h2>".$unblock_msg."</h2><br><h3>OTP : ".$otp."</h3><br><h3>You have only ".$chance." chance left to Verify your account again. Thanks.</h3><br><h3>Login Link : ".$serverUrl."</h3></body></html>";
				$mail_result = mail($to, $subject, $body, $headers);
				if($mail_result) {
					$update = $pdo->prepare("UPDATE ot_user SET user_otp = '".$otp."' , user_status= '0' , user_blocked = '0' , u_chance = '".$chance."'  WHERE user_email=?");
					$result_new = $update->execute(array($email));
					echo "User has been Unblocked & Email has been sent Successfully." ;
				} else {
					echo "Error : Email has not been enabled on your server. Try again.";
				}		
			
		} else {
			echo "Something went wrong try again.";
		}
	}
}
?>
