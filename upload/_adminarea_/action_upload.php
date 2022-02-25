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
	$mainfile_email = _e($adm['mainfile_email']);
	$rec_email = _e($adm['rec_email']);
}
$headers = "";
if(!empty($_FILES['newfile']))
{
	$item_id = filter_var($_POST['item_id'], FILTER_SANITIZE_NUMBER_INT) ;
	$targetDir = "_item_secure_/".$item_id."/"; 
	$allowTypes = array('jpg', 'png', 'jpeg'); 
	$fileName = filter_var($_FILES["newfile"]["name"], FILTER_SANITIZE_STRING) ;
	$temp = explode(".", $fileName);
	$newfilename = round(microtime(true)) . '.' . end($temp);
	$targetFilePath = $targetDir.$newfilename; 
	// Check whether file type is valid 
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
	$tmpFileName = filter_var($_FILES["newfile"]["tmp_name"], FILTER_SANITIZE_STRING) ;
	//delete old file if exist
	$statement = $pdo->prepare("select item_thumbnail from item_db where item_id = '".$item_id."'");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	foreach($result as $row) {
		$thumbnailfile_name = _e($row['item_thumbnail']) ;
	} 
	if(in_array($fileType, $allowTypes)){
		//delete old image
		unlink($targetDir.$thumbnailfile_name); 
        // Upload file to the server 
        if(move_uploaded_file($tmpFileName , $targetFilePath)){ 
			$upd = $pdo->prepare("update item_db set item_thumbnail = '".$newfilename."' where item_Id = '".$item_id."'");
			$upd->execute();
        } 
    } 
} 
if(!empty($_FILES['previewfile']))
{
	$item_id = filter_var($_POST['item_id'], FILTER_SANITIZE_NUMBER_INT) ;
	$targetDir = "_item_secure_/".$item_id."/"; 
	$allowTypes = array('jpg', 'png', 'jpeg'); 
	$fileName = filter_var($_FILES["previewfile"]["name"], FILTER_SANITIZE_STRING) ;
	$temp = explode(".", $fileName);
	$newfilename = round(microtime(true)) . '.' . end($temp);
	$targetFilePath = $targetDir.$newfilename; 
	// Check whether file type is valid 
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
	$tmpFileName = filter_var($_FILES["previewfile"]["tmp_name"], FILTER_SANITIZE_STRING) ;
	//delete old file if exist
	$statement = $pdo->prepare("select item_preview from item_db where item_id = '".$item_id."'");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	foreach($result as $row) {
		$previewfile_name = _e($row['item_preview']) ;
	} 
	if(in_array($fileType, $allowTypes)){ 
		//delete old image
		unlink($targetDir.$previewfile_name); 
        // Upload file to the server 
        if(move_uploaded_file($tmpFileName , $targetFilePath)){ 
			$upd = $pdo->prepare("update item_db set item_preview = '".$newfilename."' where item_Id = '".$item_id."'");
			$upd->execute();
        } 
    } 
} 
if(!empty($_FILES['mainfile']))
{
	$item_id = filter_var($_POST['item_id'], FILTER_SANITIZE_NUMBER_INT) ;
	$targetDir = "_item_main_/".$item_id."/"; 
	$allowTypes = array('zip'); 
	$fileName = filter_var($_FILES["mainfile"]["name"], FILTER_SANITIZE_STRING) ;
	$temp = explode(".", $fileName);
	$newfilename = round(microtime(true)) . '.' . end($temp);
	$targetFilePath = $targetDir.$newfilename; 
	// Check whether file type is valid 
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
	$tmpFileName = filter_var($_FILES["mainfile"]["tmp_name"], FILTER_SANITIZE_STRING) ;
	//delete old file if exist
	$statement = $pdo->prepare("select item_mainfile from item_db where item_id = '".$item_id."'");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	foreach($result as $row) {
		$mainfile_name = _e($row['item_mainfile']) ;
	} 
	if(in_array($fileType, $allowTypes)){ 
		
		
		//delete old file
		unlink($targetDir.$mainfile_name);
		
        // Upload file to the server 
        if(move_uploaded_file($tmpFileName , $targetFilePath)){ 
			$upd = $pdo->prepare("update item_db set item_mainfile = '".$newfilename."' where item_Id = '".$item_id."'");
			$upd->execute();
			
			$checking = check_item_foruser($pdo,$item_id) ;
			if($checking > 0) {
				if($mainfile_email == '1') {
					$findUser = $pdo->prepare("select * from ot_payments where p_item_id = '".$item_id."' and payment_status = 'Completed'") ;
					$findUser->execute();
					$totalRow = $findUser->rowCount();
					$userStatement = $findUser->fetchAll();
					if($totalRow > 0) {
						foreach($userStatement as $uRow) {
							$userid = _e($uRow['p_user_id']) ;
							$userName = get_userfullname_byid($pdo,$userid) ;
							$userEmail = get_useremail_byid($pdo,$userid) ;
							$itemName = get_item_title($pdo,$item_id) ;
							$webUrl = BASE_URL.'item/'.$itemId ;
							$to = $userEmail ;
							$subject = "Your Purchased Item Update" ;
							$from = "Email From: ".$rec_email ;
							$headers .= 'MIME-Version: 1.0' . "\r\n" ;
							$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n" ; 
							$headers .= "X-Priority: 1 (Highest)\n";
							$headers .= "X-MSMail-Priority: High\n";
							$headers .= "Importance: High\n";
							include("email_for_itemupdate_to_user.php");
							$mail_result = mail($to, $subject, $body, $headers);
						}
					}
					
				}
			}
			
        } 
    } 
} 
if(!empty($_FILES['docufile']))
{
	$item_id = filter_var($_POST['item_id'], FILTER_SANITIZE_NUMBER_INT) ;
	$targetDir = "_item_secure_/".$item_id."/"; 
	$allowTypes = array('zip'); 
	$fileName = filter_var($_FILES["docufile"]["name"], FILTER_SANITIZE_STRING) ;
	$temp = explode(".", $fileName);
	$newfilename = round(microtime(true)) . '.' . end($temp);
	$targetFilePath = $targetDir.$newfilename; 
	// Check whether file type is valid 
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
	$tmpFileName = filter_var($_FILES["docufile"]["tmp_name"], FILTER_SANITIZE_STRING) ;
	//delete old file if exist
	$statement = $pdo->prepare("select item_docufile from item_db where item_id = '".$item_id."'");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	foreach($result as $row) {
		$screenshotfile_name = _e($row['item_docufile']) ;
	} 
	if(in_array($fileType, $allowTypes)){
		$fname = "screenshots";
		//delete old file
		unlink($targetDir.$screenshotfile_name);  
		deleteDirectory($targetDir.$fname) ;
        // Upload file to the server 
        if(move_uploaded_file($tmpFileName , $targetFilePath)){ 
			$upd = $pdo->prepare("update item_db set item_docufile = '".$newfilename."' where item_Id = '".$item_id."'");
			$upd->execute();
			//unzip the screenshot
			
			$zip = new ZipArchive;
			$res = $zip->open($targetDir.$newfilename); 
			if ($res === TRUE) {
			  $oldScreenshotName = $zip->getNameIndex(0) ;
			  $zip->extractTo("_item_secure_/".$item_id."/");
			  $zip->close();
			  
			} 
			$oldPath = "_item_secure_/".$item_id."/".$oldScreenshotName ;
			$newPath = "_item_secure_/".$item_id."/".$fname ;
			rename($oldPath, $newPath) ;
			
        } 
    } 
} 

?>