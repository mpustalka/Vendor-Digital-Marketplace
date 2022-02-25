<?php
ob_start();
session_start();
include("db/config.php");
include("db/function_xss.php") ;
// Checking Admin is logged in or not
if(!isset($_SESSION['admin'])) {
	header("location: login.php"); 
	exit;
}
$headers = "";
if(isset($_POST['btn_action_sms']))
{
	if($_POST['btn_action_sms'] == 'fetchUserdetail')
	{
		if(!empty($_POST['userId'])){
			$userId = filter_var($_POST['userId'], FILTER_SANITIZE_NUMBER_INT) ;
			$statement = $pdo->prepare("select user_id, user_fullname, user_email from customer_active where user_id = '".$userId."'");
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			foreach($result as $row) {
				$output['userId'] = _e($row['user_id']) ;
				$output['username'] = _e($row['user_fullname']) ;
				$output['useremail'] = _e($row['user_email']) ;
			}
			echo json_encode($output) ;
		}
	}
	if($_POST['btn_action_sms'] == 'SendEmail')
	{
		if(!empty($_POST['userId']) && !empty($_POST['username']) && !empty($_POST['useremail']) && !empty($_POST['emailtext']) && !empty($_POST['subject'])){
			
			$userId = filter_var($_POST['userId'], FILTER_SANITIZE_NUMBER_INT) ;
			$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING) ;
			$email = filter_var($_POST['useremail'], FILTER_SANITIZE_EMAIL) ;
			$subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING) ;
			$body = filter_var($_POST['emailtext'], FILTER_SANITIZE_STRING) ;
			$date = filter_var(date("Y-m-d"), FILTER_SANITIZE_STRING) ;
			$statement = $pdo->prepare("insert into send_user_email (user_id, user_name, subject, user_email, email_text, email_date) values(?,?,?,?,?,?)") ;
			$statement->execute(array($userId,$username,$subject,$email,$body,$date));
			if($statement){
				$to = $email ;
				$headers .= 'MIME-Version: 1.0' . "\r\n" ;
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n" ; 
				$headers .= $from . "\r\n" ; 
				if (mail($to, $subject, $body, $headers)) {
					echo "Email sent successfully. Please check Sent Email Option.";
				} else {
					echo "Error in Sending Email. Try Again.";
				}
			}
		} else {
			echo "All Fields are mandatory to Send Email." ;
		}
	}
	
}
?>