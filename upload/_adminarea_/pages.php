<?php 
include("header.php") ; 
if(!empty($_GET['id'])) {
	$pageId = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT) ;
	$page_statement = $pdo->prepare("select * from ot_admin_pages where page_id = '".$pageId."'");
	$page_statement->execute();
	$page_item = $page_statement->rowCount(); 
	$page_result = $page_statement->fetchAll(PDO::FETCH_ASSOC);
	if($page_item > 0){
		foreach($page_result as $pageRow) {
			$pageName = strip_tags($pageRow['page_name']) ;
			$pageSlug = _e($pageRow['page_slug']) ;
			$pageContent = base64_decode($pageRow['page_text']) ;
		}
	} else {
		header('location: '.ADMIN_URL.'pages.php') ;
	}
}
?>
<div class="app-title">
        <div>
		<?php 
		if(isset($page_item) > 0){ ?>
          <h1><i class="fa fa-pencil-alt"></i> Edit Page</h1>
		  <p class="text-success">Requirements (Page Name, Page Slug (unique) & Page Content.)</p>
		<?php } else { ?>
          <h1><i class="fa fa-file-alt text-success"></i> Pages</h1>
		  <p class="text-success">Create / Edit Unlimited Pages for Users such as About Us, Refund, Privacy Policy pages etc.</p>
		  <?php } ?>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?php echo ADMIN_URL ; ?>dashboard.php">Dashboard</a></li>
        </ul>
</div>
<div class="tile">
<?php if(isset($page_item) > 0){ ?>
<form method="post" enctype="multipart/form-data" class="editPage" >
	<div class="row">
			<div class="col-lg-4">
				<div class="form-group">
					<label>Page Name* <small>(Max 25 Characters)</small></label>
					<input type="text" name="page_name" class="form-control" maxlength="25" autocomplete="off" autofocus required value="<?php echo $pageName ; ?>">
				</div>
			</div>
			<div class="col-lg-4">
				<div class="form-group">
					<label>Page Slug* <small>(Max 25 Characters & No Special Char & Numbers)</small></label>
					<input type="text" name="page_slug" class="page_slug lowercase form-control" maxlength="25" autocomplete="off" autofocus required value="<?php echo $pageSlug ; ?>">
				</div>
			</div>
			<div class="col-lg-4">
				<div class="form-group">
					<label>Page URL*</label>
					<input type="text" name="page_url" class="page_url form-control" autocomplete="off" autofocus  value="<?php echo BASE_URL.'page/'.$pageSlug ; ?>" readonly="readonly">
				</div>
			</div>
			<div class="col-lg-12">
				<div class="form-group">
					<label>Page Content*</label>
					<textarea name="page_content" id="item_message" class="form-control" autofocus required><?php echo $pageContent ; ?></textarea>
				</div>
			</div>
	</div>
	<div class="row mt-4">
		<div class="col-lg-12 text-center">
			<div class="remove-messages"></div>
			<input type="hidden" name="pageId" value="<?php echo $pageId ; ?>" >
			<input type="hidden" name="btn_action" id="btn_action" value="edit_page">
			<input type="submit" name="action_page" class="btn btn-md btn-info" value="Edit Page" >
		</div>
	</div>
</form>
<div class="step2">
	<div class="row">
		<div class="col-lg-12 text-center">
			<p class="text-success">Your Page has been Edited Successfully. &ensp; <a href="<?php echo ADMIN_URL ; ?>managepages.php" class="btn btn-success btn-sm">Change Status of Page</a>
		</div>
	</div>
</div>
<?php } else { ?>
<form method="post" enctype="multipart/form-data" class="savePage" >
	<div class="row">
			<div class="col-lg-4">
				<div class="form-group">
					<label>Page Name* <small>(Max 25 Characters)</small></label>
					<input type="text" name="page_name" class="form-control" maxlength="25" autocomplete="off" autofocus required placeholder="Privacy Policy">
				</div>
			</div>
			<div class="col-lg-4">
				<div class="form-group">
					<label>Page Slug* <small>(Max 25 Characters & No Special Char & Numbers)</small></label>
					<input type="text" name="page_slug" class="page_slug lowercase form-control" maxlength="25" autocomplete="off" autofocus required placeholder="privacy">
				</div>
			</div>
			<div class="col-lg-4">
				<div class="form-group">
					<label>Page URL*</label>
					<input type="text" name="page_url" class="page_url form-control" autocomplete="off" autofocus  placeholder="<?php echo BASE_URL.'page/privacy/' ; ?>" readonly="readonly">
				</div>
			</div>
			<div class="col-lg-12">
				<div class="form-group">
					<label>Page Content*</label>
					<textarea name="page_content" id="item_message" class="form-control" autofocus required></textarea>
				</div>
			</div>
	</div>
	<div class="row mt-4">
		<div class="col-lg-12 text-center">
			<div class="remove-messages"></div>
			<input type="hidden" name="btn_action" id="btn_action" value="save_page">
			<input type="submit" name="action_page" class="btn btn-md btn-info" value="Publish Page" >
		</div>
	</div>
</form>
<div class="step3">
	<div class="row">
		<div class="col-lg-12 text-center">
			<p class="text-success">Your Page has been Published. &ensp; <a href="<?php echo ADMIN_URL ; ?>pages.php" class="btn btn-success btn-sm">Create New Page</a>
		</div>
	</div>
</div>
<?php } ?>
</div>

<?php include("footer.php") ; ?>