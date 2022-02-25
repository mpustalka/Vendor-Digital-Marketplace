<?php
ob_start();
session_start();
include("_adminarea_/db/config.php");
include("_adminarea_/db/function_xss.php");
if(isset($_SESSION['user']['user_id'])){
	 $checkStatus =  check_user_status($pdo) ;
	 //if user deactivate by admin then it's automatically logout
	 if($checkStatus == 0) {
		unset($_SESSION['user']);
		header("location: ".BASE_URL.""); 
	}
} 
$itemId = filter_var($_GET['item_id'], FILTER_SANITIZE_NUMBER_INT) ;
if(empty($itemId)){
	header("location:".BASE_URL."") ;
}
$checking = check_item_foruser($pdo,$itemId) ;
if($checking == '0'){
	header("location:".BASE_URL."") ;
}
include("product_header.php") ;
?>
<div class="app-title">
<h1 class="text-muted"><?php echo get_item_title($pdo,$itemId) ; ?></h1>
<ul class="app-breadcrumb breadcrumb">
			<li>
			<a href="https://twitter.com/share?url=<?php echo BASE_URL."item/".$itemId ; ?>&text=<?php echo get_item_title($pdo,$itemId) ; ?>" target="_blank" class="float-right ml-2 mr-2 mt-1">
			<i class="fab fa-twitter-square text-info fa-2x"></i>
			</a>
			<a href="http://www.facebook.com/share.php?u=<?php echo BASE_URL."item/".$itemId ; ?>" target="_blank" class="float-right ml-2 mt-1">
			<i class="fab fa-facebook-square text-primary fa-2x"></i>
			</a>
			<a href="https://wa.me/?text=<?php echo BASE_URL."item/".$itemId ; ?>" target="_blank" class="float-right ml-2 mt-1">
			<i class="fab fa-whatsapp text-whatsapp fa-2x"></i>
			</a>
			</li>
</ul>
</div>
<div class="row">
	<div id="loaderCat"></div>
	<div class="col-lg-7 p-1">
		<?php echo get_item_previewImage($pdo,$itemId) ; ?>
	</div>
	<div class="col-lg-5 p-1">
		<div class="card">
            <div class="card-header bg-light text-white text-center myLink">
			<?php
				if(check_screenshot_foruser($pdo,$itemId) > 0) {
						$targetDir = "_adminarea_/_item_secure_/".$itemId."/";
						$fname = "screenshots";
						$files = glob($targetDir.$fname.'/*.{jpg,png,jpeg}', GLOB_BRACE);
						$in = 1 ;
						foreach($files as $file) {
							$file = BASE_URL.$file ;
						?>
							<a href="<?php echo $file ; ?>" class="spotlight">
							<?php if($in == '1') { $in = 0 ; ?> <span class="btn btn-sm btn-info">Screenshots</span> <?php } ?> 
							</a>
						<?php
						}
					}
						?>
					
					<?php echo item_preview($pdo,$itemId) ; ?> <?php echo get_item_youtube_video($pdo,$itemId) ; ?>
					<?php if( empty(check_screenshot_foruser($pdo,$itemId)) && empty(item_preview($pdo,$itemId)) && empty(get_item_youtube_video($pdo,$itemId)) ){?>
					<h4 class="text-muted">Item Details</h4>
					<?php } ?>
			</div>
			<form action="<?php echo BASE_URL."checkout/" ; ?>" method="post" enctype="multipart/form-data" >
             <div class="card-body mb-n3">
			 	<div class="row">
			 	<div class="col-lg-6 p-1">
			 	<div class="form-group">
					<label class="text-muted">Choose License</label>
					<hr class="mt-n2">
					<select name="lic" class="lic form-control" id="<?php echo $itemId ; ?>">
						<option value="1">Regular License</option>
						<option value="2">Extended License</option>
					</select>
				</div>
				</div>
				<div class="col-lg-6 p-1">
					<label class="text-muted">Sales & Rating</label>
					<hr class="mt-n2">
					<div class="form-group text-muted mt-4">
						<i class="fa fa-shopping-bag text-success"></i>&ensp; Sales (<?php echo get_item_sale($pdo,$itemId) ; ?>)
						&ensp;
						<?php echo get_item_rating($pdo,$itemId) ; ?>
					</div>
					</div>
				</div>
				
				<div class="row mt-4 justify-content-center">
					<h3 class="text-muted">$<span class="pri"> <?php echo get_item_price($pdo,$itemId) ; ?></span></h3>
				</div>
			 </div>
			
			 <div class="card-footer text-center">
			 	<?php echo item_was_featured($pdo,$itemId) ; ?> &ensp;
			 	<input type="hidden" name="itemId" value="<?php echo $itemId ; ?>"  />
			 	<input type="hidden" name="item_name" value="<?php echo get_item_title($pdo,$itemId) ; ?>"  />
			 	<input type="hidden" name="item_amount" class="item_amount" value="<?php echo get_item_price($pdo,$itemId) ; ?>" >
				<?php if(isset($_SESSION['user']['user_id'])){ ?> 
				<input type="submit"  class="btn btn-sm btn-success" name="submit" value="Buy Now"  />
				<?php } else { ?>
			 	<a href="<?php echo BASE_URL."login.php" ; ?>" class="btn btn-sm btn-success" >Buy Now</a>
				<?php } ?>
				
			 </div>
			 </form>
		</div>
	</div>
	<div class="col-lg-12 card p-1 mt-4">
		<ul class="nav nav-tabs bg-white shadow-lg">
			<li class="nav-item"><a class="nav-link" href="#descr" data-toggle="tab"><h6>Description</h6></a></li>
			<li class="nav-item"><a class="nav-link" href="#comme" data-toggle="tab"><h6>Comments</h6></a></li>
			<li class="nav-item"><a class="nav-link" href="#revie" data-toggle="tab"><h6>Reviews</h6></a></li>
		</ul>
		<div class="tab-content bg-white shadow-lg" id="tabs">
			<div class="tab-pane p-4 blueLink" id="descr"><?php echo get_item_description($pdo,$itemId) ; ?></div>
			<div class="tab-pane" id="comme">
			<div class="row p-3">
				<div class="col-lg-12">
						<?php if(isset($_SESSION['user']['user_id'])){ ?> 
							<form method="post" class="userComment">
								
										<div class="form-group">
											<textarea class="form-control" name="comment" placeholder="Type Your Comment..." required></textarea>
										</div>
										<div class="form-group text-right">
											<input type="hidden" name="userId" value="<?php echo $_SESSION['user']['user_id']; ?>"  />
											<input type="hidden" name="itemId" value="<?php echo $itemId ; ?>"  />
											<input type="hidden" name="btn_submit_comment" id="btn_submit_comment" value="SubmitComment" />
											<input type="submit" name="submitComment" id="submitComment" class="btn btn-success btn-sm" value="Submit Comment"  />
										</div>
									
							</form>
							<span class="jQueryNewComment"></span>
						<?php } ?>
						<?php echo get_usercomment($pdo,$itemId) ; ?>
						<span class="jQueryOldComment"></span>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="revie"><?php echo get_item_rating_data_byuser($pdo,$itemId) ; ?><span class="jQueryNewRating"></span></div>
		</div>
	</div>
</div>
<!-- View Youtube Video Modal -->
	<div id="youtubeModal" class="modal fade youtubeModal">
    	<div class="modal-dialog modal-lg">
    			<div class="modal-content">
    				<div class="modal-header">
						<h4 class="modal-title text-danger"><i class="fa fa-video text-danger"></i> Youtube Demo Video</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
    				</div>
    				<div class="modal-body1 text-center">
    				</div> 
    				<div class="modal-footer"> 
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		
    	</div>
    </div>
<?php include("footer.php") ; ?>