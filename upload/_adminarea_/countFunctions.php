<?php
function count_total_users($pdo)
{	
	$query = "SELECT * FROM customer_active WHERE 1";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
	
}
function count_total_active_users($pdo)
{	
	$query = "SELECT * FROM customer_active WHERE active_status='1'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
	
}
function count_total_deactive_users($pdo)
{	
	$query = "SELECT * FROM customer_active WHERE active_status='0'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
	
}
function count_total_announcement($pdo)
{	
	$query = "SELECT * FROM admin_announcement WHERE 1";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
	
}
function count_total_active_announcement($pdo)
{	
	$query = "SELECT * FROM admin_announcement WHERE announcement_status='1'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
	
}
function count_total_deactive_announcement($pdo)
{	
	$query = "SELECT * FROM admin_announcement WHERE announcement_status='0'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
	
}
function count_total_sms($pdo)
{	
	$query = "SELECT * FROM send_user_email WHERE 1";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
	
}
function count_total_curmonth_sms($pdo)
{	
	$firstday = date("Y-m-01") ;
	$lastday = date("Y-m-t") ;
	$query = "SELECT * FROM send_user_email WHERE email_date between '".$firstday."' and '".$lastday."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
	
}
function count_total_curday_sms($pdo)
{	
	$today = date("Y-m-d") ;
	$query = "SELECT * FROM send_user_email WHERE email_date='".$today."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
	
}
function count_total_nonsms($pdo)
{	
	$query = "SELECT * FROM send_nonuser_email WHERE 1";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
	
}
function count_total_curmonth_nonsms($pdo)
{	
	$firstday = date("Y-m-01") ;
	$lastday = date("Y-m-t") ;
	$query = "SELECT * FROM send_nonuser_email WHERE nonuser_email_date between '".$firstday."' and '".$lastday."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
	
}
function count_total_curday_nonsms($pdo)
{	
	$today = date("Y-m-d") ;
	$query = "SELECT * FROM send_nonuser_email WHERE nonuser_email_date='".$today."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
	
}

?>