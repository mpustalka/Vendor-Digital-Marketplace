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
	$email_comment = _e($adm['email_comment']);
	$rec_email = _e($adm['rec_email']);
}
$headers = "";
if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'changeCommentStatus')
	{
		$commentId = filter_var($_POST['commentId'], FILTER_SANITIZE_NUMBER_INT);
		$status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
		if($commentId) { 
			$update = $pdo->prepare("UPDATE ot_user_comment SET comment_status=?   WHERE comment_id=?");
			$result_new = $update->execute(array($status,$commentId));
			if($result_new) {
				echo 'Comment status changed .' ;		
			}
		}
	}
	if($_POST['btn_action'] == 'fetch_comment')
	{	
		if(!empty($_POST['commentId'])){
			$commentId = filter_var($_POST['commentId'], FILTER_SANITIZE_NUMBER_INT);
			$announce = $pdo->prepare("select * from ot_user_comment where comment_id = ?");
			$announce->execute(array($commentId));
			$result = $announce->fetchAll(PDO::FETCH_ASSOC);
			foreach($result as $row) {
				$uid = _e($row['comment_user_id']) ;
				$username = get_userfullname_byid($pdo,$uid) ;
				$useremail = get_useremail_byid($pdo,$uid);
				$itemId = _e($row['comment_item_id']) ;
				$output['commentId'] = _e($row['comment_id']);
				$output['commentText'] = strip_tags($row['user_comment']);
				$output['commentDate'] = _e($row['comment_date']);
				$output['commentName'] = $username ;
				$output['commentEmail'] = $useremail ;
				$output['itemId'] = $itemId ;
				$output['replyText'] = base64_decode($row['admin_comment']);
			}
			echo json_encode($output) ;
		} else {
			echo "Error : Comment Id is mandatory." ;
		}
	}
	if($_POST['btn_action'] == 'EditComment') {
		if(!empty($_POST['comment_date']) && !empty($_POST['commentText']) && !empty($_POST['comment_id']) && !empty($_POST['comment_name']) && !empty($_POST['comment_email']) ) {
			$itemId = filter_var($_POST['itemId'], FILTER_SANITIZE_NUMBER_INT);
			$commentId = filter_var($_POST['comment_id'], FILTER_SANITIZE_NUMBER_INT);
			$comment_date = filter_var(date($_POST['comment_date']) , FILTER_SANITIZE_STRING);
			$commentText = filter_var($_POST['commentText'], FILTER_SANITIZE_STRING) ;
			$commentName = filter_var($_POST['comment_name'], FILTER_SANITIZE_STRING) ;
			$commentEmail = filter_var($_POST['comment_email'], FILTER_SANITIZE_EMAIL) ;
			$replyText = base64_encode($_POST['replyText']) ;
			$replyText = filter_var($replyText, FILTER_SANITIZE_STRING) ;
			$webUrl = BASE_URL.'item/'.$itemId ;
			$upd = $pdo->prepare("update ot_user_comment set user_comment=? , comment_date=?, admin_comment = ? where comment_id = ?");
			$upd->execute(array($commentText,$comment_date,$replyText,$commentId));
			$itemName = get_item_title($pdo,$itemId) ;
			if($upd) {
				if(!empty($replyText)){
					//auto approve comment because Admin Replied
					$approveComment = $pdo->prepare("update ot_user_comment set comment_status='1' where comment_id = '".$commentId."'");
					$approveComment->execute();
					if($email_comment == '0') {
						echo 'Admin Replied Successfully & No Email sent to this User.' ;
					} else {
						$to = $commentEmail ;
						$subject = "Admin Replied on Your Comment" ;
						$from = "Email: ".$rec_email ;
						$headers .= 'MIME-Version: 1.0' . "\r\n" ;
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n" ; 
						$headers .= "X-Priority: 1 (Highest)\n";
						$headers .= "X-MSMail-Priority: High\n";
						$headers .= "Importance: High\n";
						include("email_for_comment_to_user.php");
						$mail_result = mail($to, $subject, $body, $headers);
					}
					if($mail_result) {
						echo 'Admin Replied Successfully & Email sent to this User.' ;
					} else {
						echo 'Admin Replied Successfully & But problem in sending email. Try again.' ;
					}
				} else {
				echo 'Comment Edited Successfully .' ;
				}	 	
		} else {
			echo 'Something went wrong. Try again after Refresh the page.';
		}
	} else {
		echo "All fields are mandatory." ; 
	}
}
}
?>