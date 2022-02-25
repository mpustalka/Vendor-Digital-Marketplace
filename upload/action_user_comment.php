<?php
ob_start();
session_start();
include("_adminarea_/db/config.php");
include("_adminarea_/db/function_xss.php");
// Checking User is logged in or not
if(!isset($_SESSION['user'])) {
	header("location: ".BASE_URL.""); 
	exit;
}
$admin = $pdo->prepare("SELECT * FROM ot_admin WHERE id = '1'");
$admin->execute();   
$admin_result = $admin->fetchAll(PDO::FETCH_ASSOC);
$total = $admin->rowCount();
foreach($admin_result as $adm) {
//escape all  data
	$email_comment = _e($adm['rec_email_comment']);
	$rec_email = _e($adm['rec_email']);
}
$headers = "";
if(isset($_POST['btn_submit_comment']))
{
	if($_POST['btn_submit_comment'] === 'SubmitComment')
	{
		if(isset($_POST['userId']) && isset($_POST['itemId']) && isset($_POST['comment'])){
			$userId = filter_var($_POST['userId'], FILTER_SANITIZE_NUMBER_INT);
			$itemId = filter_var($_POST['itemId'], FILTER_SANITIZE_NUMBER_INT);
			$comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
			$date = date("Y-m-d") ;
			$output = "";
			$userName = get_userfullname_byid($pdo,$userId) ;
			$userEmail = get_useremail_byid($pdo,$userId) ;
			$itemName = get_item_title($pdo,$itemId) ;
			$ins = $pdo->prepare("insert into ot_user_comment (comment_user_id, comment_item_id, user_comment, comment_date) values (?,?,?,?)");
			$ins->execute(array($userId, $itemId, $comment, $date));
			if($ins) {
				$output.= '<div class="row p-3">
						   	<div class="col-lg-12">
								<i class="fa fa-user"></i> &ensp;'.$userName.' &ensp; '.user_purchased_tag($pdo,$userId,$itemId).'
							</div>	
							<div class="col-lg-12 text-muted border-bottom p-2">
								'.$comment.'
							</div>
						   </div>';
			}
			echo $output; 
			if($email_comment == '1') {
				$webUrl = BASE_URL.'item/'.$itemId ;
				$to = $rec_email ;
				$subject = "New User Comment on Item" ;
				$from = "User Email: ".$userEmail ;
				$headers .= 'MIME-Version: 1.0' . "\r\n" ;
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n" ; 
				$headers .= "X-Priority: 1 (Highest)\n";
				$headers .= "X-MSMail-Priority: High\n";
				$headers .= "Importance: High\n";
				include("email_for_comment.php");
				$mail_result = mail($to, $subject, $body, $headers);
			}
		} else {
			echo "Comment is mandatory. Try Again.";
		}
	}
}
?>