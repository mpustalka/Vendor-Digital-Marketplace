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
$Statement = $pdo->prepare("SELECT * FROM ot_user_comment WHERE 1 order by comment_id desc ");
$Statement->execute(); 
$total = $Statement->rowCount();    
$result = $Statement->fetchAll(PDO::FETCH_ASSOC); 
$sum = 0 ;
$output = array('data' => array());
if($total > 0) {
	$active = "";
	foreach($result as $row) {
		$sum = $sum + 1 ;
		$itemId = _e($row['comment_item_id']) ;
		$itemName = get_item_title($pdo,$itemId) ;
		$commentDate = _e($row['comment_date']);
		$commentDate =  date('d F, Y',strtotime($commentDate));
		$uid = _e($row['comment_user_id']) ;
		$username = get_userfullname_byid($pdo,$uid) ;
		$useremail = get_useremail_byid($pdo,$uid);
		$status = _e($row['comment_status']);
		$commentId = _e($row['comment_id']) ;
		$commentText = strip_tags($row['user_comment']);
		$reply = base64_decode($row['admin_comment']) ; 
		$purchased = user_purchased_tag($pdo,$uid,$itemId) ;
		$itemLink = '<a href="'.BASE_URL.'item/'.$itemId.'" class="btn btn-sm btn-light" target="_blank"><i class="fa fa-eye"></i></a>';
		if($status== 1) {
			// deactivate comment
			$active ="<b>Approved</b>";
			$banComment = '<button type="button" name="changeCommentStatus" id="'.$commentId.'" class="btn btn-danger btn-sm changeCommentStatus" data-status="0">Unapprove</button>';
		} else {
			// activate comment
			$active ="Unapproved";
			$banComment = '<button type="button" name="changeCommentStatus" id="'.$commentId.'" class="btn btn-success btn-sm changeCommentStatus" data-status="1">Approve</button>';
		} 
		$editComment = '<button type="button" name="editCommentStatus" id="'.$commentId.'" class="btn btn-light btn-sm editCommentStatus" ><i class="fa fa-pencil-alt"></i></button>'; 
		$output['data'][] = array( 
		$sum,
		$commentId,	
		$commentDate,
		$uid,
		$username,
		$useremail,	
		$itemId,
		$itemName,
		$itemLink,
		$commentText,
		$purchased,
		$reply,
		$active,
		$editComment,
		$banComment
		); 	
	}
}
echo json_encode($output);
?>