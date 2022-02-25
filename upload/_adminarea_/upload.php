<?php 
include("header.php") ; 
if(!empty($_GET['item_id'])) {
	$ItemId = filter_var($_GET['item_id'], FILTER_SANITIZE_NUMBER_INT) ;
	$item_statement = $pdo->prepare("select * from item_db where item_id = '".$ItemId."'");
	$item_statement->execute();
	$total_item = $item_statement->rowCount(); 
	$item_result = $item_statement->fetchAll(PDO::FETCH_ASSOC);
	if($total_item > 0){
		foreach($item_result as $itemRow) {
			$itemName = strip_tags($itemRow['item_name']) ;
			$itemRegularPrice = _e($itemRow['regular_price']) ;
			$itemExtendedPrice = _e($itemRow['extended_price']) ;
			$catId = _e($itemRow['main_category']) ;
			$catName = fetch_active_category_name($pdo,$catId) ;
			$subcatId = _e($itemRow['sub_category']) ;
			$subcatName = fetch_active_subcategory_name($pdo,$subcatId) ;
			$childcatId = _e($itemRow['child_category']) ;
			$childcatName = fetch_active_childcategory_name($pdo,$childcatId) ;
			$itemDetails = base64_decode($itemRow['item_description']) ;
			$itemTags = strip_tags($itemRow['item_tags']) ;
			$itemDemoLink = _e($itemRow['item_demo_link']) ;
			$youtubeDemoLink = _e($itemRow['item_youtube_link']) ;
		}
	} else {
		$_SESSION['item_error_msg'] = "This Item is not exist. Please Upload New Item instead.";
		header('location: '.ADMIN_URL.'upload.php') ;
	}
}
?>
<div class="app-title">
        <div>
		<?php 
		if(isset($total_item) > 0){ ?>
          <h1><i class="fa fa-upload"></i> Edit Item</h1>
		  <p class="text-success">Requirements (Item Name, Regular & Extended Price, Item Description, Main Category, Tags.)</p>
		<?php } else { ?>
		   <h1><i class="fa fa-upload"></i> Upload Item</h1>
		   <p class="text-success">Requirements (Item Name, Regular & Extended Price, Item Description, Main Category, Tags, Preview & Thumbnail Image & Main File).</p>
		<?php } ?>
		  
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?php echo ADMIN_URL ; ?>dashboard.php">Dashboard</a></li>
        </ul>
 </div>
<div class="tile">
<?php 
					if(! empty($_SESSION['item_error_msg'])){ ?>
						<div  class="alert alert-danger errorMessage">
						<button type="button" class="close float-right" aria-label="Close" >
						  <span aria-hidden="true" id="hide">&times;</span>
						</button>
				<?php
						echo $_SESSION['item_error_msg'] ;
						unset($_SESSION['item_error_msg']);
				?>
						</div>
			<?php } ?>
<!-- STEP 1 Start-->
<div class="step1">
<?php if(isset($total_item) > 0){ ?>
<form method="post" enctype="multipart/form-data" class="step1formedit">
	<div class="row">
		<div class="col-lg-12">
		<h4 class="text-muted">Item Name & Price</h4>
		<hr>
		</div>
		<div class="col-lg-6">
			<div class="form-group">
				<label>Item Name* (Max 100 Characters)</label>
				<input type="text" name="item_name" class="form-control" maxlength="100" autocomplete="off" autofocus required value="<?php echo $itemName ; ?>">
			</div>
		</div>
		<div class="col-lg-3">
			<div class="form-group">
				<label>Regular License Price*</label>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text">(USD)&ensp;<b> $</b></span>
					</div>
					<input type="number" name="regular_amount" class="form-control" required autofocus min="1" value="<?php echo $itemRegularPrice ; ?>"> 
				</div>
			</div>
		</div>
		<div class="col-lg-3">
			<div class="form-group">
				<label>Extended License Price*</label>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text">(USD)&ensp;<b> $</b></span>
					</div>
					<input type="number" name="extended_amount" class="form-control" required autofocus min="1" value="<?php echo $itemExtendedPrice ; ?>"> 
				</div>
			</div>
		</div>
		
	</div>
	<div class="row">
		<div class="col-lg-12">
		<h4 class="text-muted">Item Category, Sub Category & Child Category</h4>
		<hr>
		</div>
		<div class="col-lg-4">
			<div class="form-group">
				<label>Main Category*</label>
				<select name="cat" id="cat" required class="form-control">
					<?php echo $catName ; ?>
					<?php echo get_active_category_selected($pdo,$catId) ; ?>
				</select>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="form-group">
				<label>Sub Category*</label>
				<select name="subcat" id="subcat" required class="form-control">
				<?php echo $subcatName ; ?>
				<option value="">Select Sub Category</option>
				<?php echo get_active_subcategory_selected($pdo,$subcatId,$catId) ; ?>
				</select>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="form-group">
				<label>Child Category<small>(Optional)</small></label>
				<select name="childcat" id="childcat" class="form-control">
				<?php echo $childcatName ; ?>
				<option value="">Select Child Category</option>
				<?php echo get_active_childcategory_selected($pdo,$childcatId,$catId,$subcatId) ; ?>
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
		<h4 class="text-muted">Item Description*</h4>
		<hr>
		</div>
		<div class="col-lg-12">
		<textarea name="item_message" id="item_message" class="form-control" autofocus required><?php echo $itemDetails ; ?></textarea>
		</div>
	</div>
	<div class="row mt-2">
		<div class="col-lg-12">
		<h4 class="text-muted">Item Tags* <small class="text-muted">(Tags will Boost the SEO & Item Search)</small></h4>
		<hr>
		</div>
		<div class="col-lg-12">
		<textarea name="item_tag" id="item_tag" class="form-control" placeholder="Example : 2FA, Wordpress Theme, Login System, Contact Form, PHP Script, javascript" autofocus required><?php echo $itemTags ; ?></textarea>
		</div>
	</div>
	<div class="row mt-2">
		<div class="col-lg-12">
		<h4 class="text-muted">Item Additional Information</h4>
		<hr>
		</div>
		<div class="col-lg-6">
			<label>Item Demo Link<small>(Optional)</small></label>
			<input type="text" name="demo_link" class="form-control" maxlength="200" value="<?php echo $itemDemoLink ; ?>" >
		</div>
		<div class="col-lg-6">
			<label>Youtube Video Link<small>(Optional)</small></label>
			<input type="text" name="youtube_link" class="form-control" maxlength="200"  value="<?php echo $youtubeDemoLink ; ?>" >
		</div>
	</div>
	<div class="row mt-4">
		<div class="col-lg-12 text-center">
			<div class="remove-messages"></div>
			<input type="hidden" id="item_id" name="item_id" value="<?php echo $ItemId ; ?>">
			<input type="hidden" name="btn-action" id="btn-action" value="edit_step_1">
			<input type="submit" name="action-item" class="btn btn-md btn-success" value="Save & Next" >
		</div>
	</div>
</form>
<?php } else { ?>
<form method="post" enctype="multipart/form-data" class="step1form">
	<div class="row">
		<div class="col-lg-12">
		<h4 class="text-muted">Item Name & Price</h4>
		<hr>
		</div>
		<div class="col-lg-6">
			<div class="form-group">
				<label>Item Name* (Max 100 Characters)</label>
				<input type="text" name="item_name" class="form-control" maxlength="100" autocomplete="off" autofocus required>
			</div>
		</div>
		<div class="col-lg-3">
			<div class="form-group">
				<label>Regular License Price*</label>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text">(USD)&ensp;<b> $</b></span>
					</div>
					<input type="number" name="regular_amount" class="form-control" required autofocus min="1"> 
				</div>
			</div>
		</div>
		<div class="col-lg-3">
			<div class="form-group">
				<label>Extended License Price*</label>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text">(USD)&ensp;<b> $</b></span>
					</div>
					<input type="number" name="extended_amount" class="form-control" required autofocus min="1"> 
				</div>
			</div>
		</div>
		
	</div>
	<div class="row">
		<div class="col-lg-12">
		<h4 class="text-muted">Item Category, Sub Category & Child Category</h4>
		<hr>
		</div>
		<div class="col-lg-4">
			<div class="form-group">
				<label>Main Category*</label>
				<select name="cat" id="cat" required class="form-control">
					<option value="">Select Category</option>
					<?php echo get_active_category($pdo) ; ?>
				</select>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="form-group">
				<label>Sub Category*</label>
				<select name="subcat" id="subcat" required class="form-control">
				<option value="">Select Sub Category</option>
				</select>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="form-group">
				<label>Child Category<small>(Optional)</small></label>
				<select name="childcat" id="childcat" class="form-control">
				<option value="">Select Child Category</option>
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
		<h4 class="text-muted">Item Description*</h4>
		<hr>
		</div>
		<div class="col-lg-12">
		<textarea name="item_message" id="item_message" class="form-control" autofocus required></textarea>
		</div>
	</div>
	<div class="row mt-2">
		<div class="col-lg-12">
		<h4 class="text-muted">Item Tags* <small class="text-muted">(Tags will Boost the SEO & Item Search)</small></h4>
		<hr>
		</div>
		<div class="col-lg-12">
		<textarea name="item_tag" id="item_tag" class="form-control" placeholder="Example : 2FA, Wordpress Theme, Login System, Contact Form, PHP Script, javascript" autofocus required></textarea>
		</div>
	</div>
	<div class="row mt-2">
		<div class="col-lg-12">
		<h4 class="text-muted">Item Additional Information</h4>
		<hr>
		</div>
		<div class="col-lg-6">
			<label>Item Demo Link<small>(Optional)</small></label>
			<input type="text" name="demo_link" class="form-control" maxlength="200" >
		</div>
		<div class="col-lg-6">
			<label>Youtube Video Link<small>(Optional)</small></label>
			<input type="text" name="youtube_link" class="form-control" maxlength="200" >
		</div>
	</div>
	<div class="row mt-4">
		<div class="col-lg-12 text-center">
			<div class="remove-messages"></div>
			<input type="hidden" name="btn-action" id="btn-action" value="save_step_1">
			<input type="submit" name="action-item" class="btn btn-md btn-success" value="Save & Next" >
		</div>
	</div>
</form>
<?php } ?>
</div>
<!-- STEP 1 End-->
<!-- STEP 2 Start-->
<div class="step2">
<form  method="post" id="uploadFilesNew" class="uploadFilesNew">
	<div class="row mt-4">
	<!--Preview & Thumbnail Image Start-->
		
			<div class="col-lg-6 col-md-6">
				<div class="form-group thmb">
					<label>Thumbnail Image<?php if(isset($total_item) == 0){ ?>* <?php } ?> <small>(Only .jpeg, .jpg, .png allowed, 2 MB Allowed, Best View 200px * 200px)</small></label>
					<input type="file" name="uploadThumbnail" id="uploadThumbnail" class="form-control" accept="image/x-png,image/jpeg" <?php if(isset($total_item) == 0){ ?> required <?php } ?>/>
				</div>
				<div class="remove-messagesthumbnail"></div>
			</div>
			<div class="col-lg-6 col-md-6">
				<div class="form-group prvw">
					<label>Preview Image<?php if(isset($total_item) == 0){ ?>* <?php } ?> <small>(Only .jpeg, .jpg, .png allowed, 10 MB Allowed, Best View 600px * 300px)</small></label>
					<input type="file" name="uploadPreview" id="uploadPreview" class="form-control" accept="image/x-png,image/jpeg" <?php if(isset($total_item) == 0){ ?> required <?php } ?>/>
				</div>
				<div class="remove-messagespreview"></div>
			</div>
			<div class="col-lg-12 col-md-12 thumbprogress">
				<div class="progress">
					<div class="progress-bar thumb-bar bg-success"  role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<!--<div id="targetLayer"></div>-->
			</div>
			
			<div class="col-lg-12 col-md-12 previewprogress">
				<div class="progress">
					<div class="progress-bar preview-bar bg-success"  role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<!--<div id="targetLayer"></div>-->
			</div>
		
	<!--Preview & Thumbnail Image End-->
	<!--Main File & Documentation File Start-->
		
			<div class="col-lg-6 col-md-6">
				<div class="form-group mainfile">
					<label>Main File<?php if(isset($total_item) == 0){ ?>* <?php } ?> <small>(Only .zip allowed, 256 MB Allowed, Include documentation)</small></label>
					<input type="file" name="uploadMainFile" id="uploadMainFile" class="form-control" accept="application/x-zip-compressed" <?php if(isset($total_item) == 0){ ?> required <?php } ?>/>
				</div>
				<div class="remove-messagesmainfile"></div>
			</div>
			<div class="col-lg-6 col-md-6">
				<div class="form-group dcmntn">
					<label>Screenshot File <small>(Optional & Only .zip, 128 MB Allowed)</small></label>
					<input type="file" name="uploadDocumentation" id="uploadDocumentation" class="form-control" accept="application/x-zip-compressed" />
				</div>
				<div class="remove-messagesdocumentation"></div>
			</div>
			<div class="col-lg-12 col-md-12 mainfileprogress">
				<div class="progress">
					<div class="progress-bar mainfile-bar bg-success"  role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<!--<div id="targetLayer"></div>-->
			</div>
			
			<div class="col-lg-12 col-md-12 documentationprogress">
				<div class="progress">
					<div class="progress-bar docufile-bar bg-success"  role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<!--<div id="targetLayer"></div>-->
			</div>
		
	<!--Main File & Documentation File End-->
				
		<div class="col-lg-12 text-center">
			<input type="hidden" name="btn-action-3" id="btn-action-3" value="save_step_3">
			<input type="hidden" id="item_id" name="item_id" class="item_id">
			<input type="submit" class="btn btn-md btn-success" name="action_files" id="action_files" <?php if(isset($total_item) == 0){ ?> value="Publish Item"  <?php } else { ?>value="Update Files / Publish Item" <?php } ?>>&ensp;
			<?php if(isset($total_item) > 0){ ?>
			<a class="btn btn-danger btn-md draftupdateitem text-white" id="<?php echo $ItemId ; ?>">Save into Draft</a>
			<?php } else { ?>
			<a class="btn btn-danger btn-md draftitem text-white">Save into Draft</a>
			<?php } ?>
		</div>
	</div>
</form>
</div>
<!-- STEP 2 End-->
<!-- STEP 3 Start-->
<div class="step3">
	<div class="row">
		<div class="col-lg-12 text-center">
			<p class="text-success">Your Item has been Published. Go to <a href="<?php echo ADMIN_URL ; ?>items.php">Item Option</a>
		</div>
	</div>
</div>
<!-- STEP 3 End-->
<!-- STEP 4 Start-->
<div class="step4">
	<div class="row">
		<div class="col-lg-12 text-center">
			<p class="text-danger">Your Item has been saved into Draft. Go to <a href="<?php echo ADMIN_URL ; ?>drafts.php">Draft Option</a>
		</div>
	</div>
</div>
<!-- STEP 4 End-->
</div>
<!-- Add Save Edit Modal -->
	<div id="editModal" class="modal fade" data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog">
    			<div class="modal-content">
    				<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
    				</div>
    				<div class="modal-body">
						<div class="row justify-content-center">
						<h5 class="text-success ">You Edit has been saved successfully.</h5>
						</div>						
    				</div> 
    				<div class="modal-footer"> 
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    	</div>
    </div>
<?php include("footer.php") ; ?>