<?php
require_once("header.php");

$admin = $pdo->prepare("SELECT * FROM ot_admin WHERE id = '1'");
$admin->execute();   
$admin_result = $admin->fetchAll(PDO::FETCH_ASSOC);
$total = $admin->rowCount();
foreach($admin_result as $adm) {
//escape all  data
	$pay_email = _e($adm['pay_email']);
	$rec_email = _e($adm['rec_email']);
}
$headers = "";

$payment_id = $statusMsg = $payment_status = ''; 
$ordStatus = 'error'; 

// Check whether stripe token is not empty 
if(!empty($_POST['tokenStripe'])){ 
     
	$item_id = $_POST['item_number'] ; 
	$itemName = $_POST['item_name'] ;
    $token  = $_POST['tokenStripe'] ; 
    $name = $_POST['cname']; 
    $email = $_POST['cemail'] ; 
	$itemPrice = $_POST['item_amount'] ;
	$itemLicense = $_POST['item_license'] ;
	$currency = $_POST['currency_code'] ;
	$uid = $_POST['uid'] ;
    // Include Stripe PHP library 
    require_once 'stripe-php/init.php'; 
     
    // Set API key 
    \Stripe\Stripe::setApiKey(STRIPE_API_KEY); 
	
	 $curl = new \Stripe\HttpClient\CurlClient();
	$curl->setEnablePersistentConnections(false);
	\Stripe\ApiRequestor::setHttpClient($curl);
     
    // Add customer to stripe 
    try {  
        $customer = \Stripe\Customer::create(array( 
            'email' => $email, 
			'name' => $name,
            'source'  => $token 
        )); 
    }catch(Exception $e) {  
        $api_error = $e->getMessage();  
    } 
     
    if(empty($api_error) && $customer){  
         
        // Convert price to cents 
        $itemPriceCents = ($itemPrice*100); 
         
        // Charge a credit or a debit card 
        try {  
            $charge = \Stripe\Charge::create(array( 
                'customer' => $customer->id, 
                'amount'   => $itemPriceCents, 
                'currency' => $currency, 
                'description' => $itemName 
            )); 
        }catch(Exception $e) {  
            $api_error = $e->getMessage();  
        } 
         
        if(empty($api_error) && $charge){ 
         
            // Retrieve charge details 
            $chargeJsonData = $charge->jsonSerialize(); 
         
            // Check whether the charge is successful 
            if($chargeJsonData['amount_refunded'] == 0 && empty($chargeJsonData['failure_code']) && $chargeJsonData['paid'] == 1 && $chargeJsonData['captured'] == 1){ 
                // Transaction details  
                $txn_id = $chargeJsonData['balance_transaction']; 
                $total_amt = $chargeJsonData['amount']; 
                $total_amt = ($total_amt/100); 
                $paidCurrency = $chargeJsonData['currency']; 
                $payment_status = "Completed"; 
                $payDate = date('Y-m-d') ;
				$complete_status = "1";
				if($itemLicense == '1'){
					$itemLicense = "Regular" ;
				} else {
					$itemLicense = "Extended" ;
				}
				$item_sale = get_item_sale($pdo,$item_id) + 1 ;
				$statement = $pdo->prepare("insert into ot_payments (p_user_id, p_item_id, p_total_amt, txn_id, payment_status, payment_date, complete_status, p_license) values (?,?,?,?,?,?,?,?)");
				$statement->execute(array($uid, $item_id, $total_amt, $txn_id, $payment_status, $payDate, $complete_status,$itemLicense));
				$item_sale_upd = $pdo->prepare("update item_db set item_sale = '".$item_sale."' where item_Id = '".$item_id."'");
				$item_sale_upd->execute();
				if($pay_email == '1') {
					$userName = get_userfullname_byid($pdo,$uid) ;
					$userEmail = get_useremail_byid($pdo,$uid) ;
					$itemName = get_item_title($pdo,$item_id) ;
					$webUrl = BASE_URL.'item/'.$item_id ;
					$to = $rec_email ;
					$subject = "Congratulation! New Sale of an Item";
					$headers .= 'MIME-Version: 1.0' . "\r\n" ;
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n" ; 
					$headers .= "X-Priority: 1 (Highest)\n";
					$headers .= "X-MSMail-Priority: High\n";
					$headers .= "Importance: High\n";
					include("email_for_sale.php");
					mail($to, $subject, $body, $headers);
				}
                // If the order is successful 
                if($payment_status == 'Completed'){ 
                    $ordStatus = 'Success'; 
					$statusMsg = "Payment Successfull";
                }else{ 
                    $statusMsg = "Your Payment has Failed!"; 
                } 
            }else{ 
                $statusMsg = "Transaction has been failed!"; 
            } 
        }else{ 
            $statusMsg = "Charge creation failed! $api_error";  
        } 
    }else{  
       $statusMsg = "Invalid card details! $api_error";  
    } 
}else{ 
    $statusMsg = "We found some error."; 
} 
?>
<div class="container mar-top">
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<div class="row">
				<div class="col-lg-3 col-md-3"></div>
				<div class="col-lg-6 col-md-6">
					<div class="card">
                		<div class="card-header bg-secondary text-white text-center"><h4> Payment Information</h4></div>
                		<div class="card-body">
							<div class="col-lg-12 text-left p-3">
								<h6 class="text-muted">
									<?php 
									if($payment_status === "Completed") {
									?>
									<i class="fa fa-check text-success"></i>
									<?php
									} else {
									?>
									<i class="fa fa-times text-danger"></i>
									<?php 
									}
										echo $statusMsg ; 
									?>
								</h6>
							</div>
							<?php if(!empty($txn_id)){ ?>
							<hr>
							<div class="col-lg-12 text-left p-3">
								<h4>Payment Information</h4>
								<p><b>Transaction ID:</b> <?php echo $txn_id; ?></p>
								<p><b>Paid Amount:</b> <?php echo $total_amt.' '.$paidCurrency; ?></p>
								<p><b>Payment Status:</b> <?php echo $payment_status; ?></p>
								<h4>Product Information</h4>
								<p><b>Name:</b> <?php echo $itemName; ?></p>
								<p><b>Price:</b> <?php echo $itemPrice.' '.$currency; ?></p>
								<p><b>Go to Download Option to Download the Script</b></p>
							</div>
							<?php } ?>
							</div>
           			 </div>
				</div>
				<div class="col-lg-3 col-md-3"></div>
			</div>
		</div>
	</div>
</div>
<?php include("footer.php") ; ?>


