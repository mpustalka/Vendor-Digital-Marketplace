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
$headers = "";
if($_POST['resend_email']){
	if($_POST['resend_email'] == 'Submit') {
		$resendEmail = filter_var($_POST['resendEmail'], FILTER_SANITIZE_EMAIL) ;
		$otp = filter_var(code(4), FILTER_SANITIZE_NUMBER_INT) ;
		$to = $resendEmail ;
		$headers .= 'MIME-Version: 1.0' . "\r\n" ;
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n" ; 
		$headers .= "\r\n" ; 
		$subject = "SignUp OTP" ;
		$body = "<br>Sign Up OTP is <br><h3>".$otp."</h3><br>Verify your account now & Please Do not share with anyone at any cost.";
		if (mail($to, $subject, $body, $headers))
		{
			$statement = $pdo->prepare("update ot_user set user_otp = '".$otp."' where user_email = '".$resendEmail."'");
			$statement->execute() ;
			$form_message = "OTP has been resend successfully.";
			$output = array( 
							'form_message' => $form_message
						) ;
			echo json_encode($output);
		}
		
	}
} 
?>
