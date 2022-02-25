<?php
include("header.php") ; 
$catId = filter_var($_GET['cid'], FILTER_SANITIZE_NUMBER_INT) ;
if(empty($catId)){
	header("location:".BASE_URL."") ;
}
$checking = check_category_foruser($pdo,$catId) ;
if($checking == '0'){
	header("location:".BASE_URL."") ;
}
?>
<div class="app-title p-2">
	<div id="loaderCat"></div>
	<ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><h1 class="text-muted">&ensp;<i class="fa fa-align-left"></i>&ensp;<i><?php echo fetchcategory_name($pdo,$catId) ; ?></i></h1></li>
    </ul>
	<div>
    	<label><i class="text-success">Filter By Sub Category</i></label>
		<select name="browsenewsubcatitems" class="browsenewsubcatitems form-control mt-n2">
			<?php echo fill_subcategory_list($pdo, $catId) ; ?>
		</select>
		
    </div>
    
</div>
<div class="newPro">
<?php echo fetch_product_by_category_foruser($pdo,$catId) ; ?>
<span class="jQueryNewItem"></span>
</div>
<div class="fetchNewPro"></div>
<span class="jQueryNewItemAppend"></span>
<?php include("footer.php") ; ?>
