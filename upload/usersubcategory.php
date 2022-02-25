<?php
include("header.php") ; 
$subcatId = filter_var($_GET['sid'], FILTER_SANITIZE_NUMBER_INT) ;
if(empty($subcatId)){
	header("location:".BASE_URL."") ;
}
$checking = check_subcategory_foruser($pdo,$subcatId) ;
if($checking == '0'){
	header("location:".BASE_URL."") ;
}
?>
<div class="app-title p-2">
	<div id="loaderCat"></div>
	<ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><h1 class="text-muted">&ensp;<i class="fa fa-align-left"></i>&ensp;<i><?php echo get_subcategory_name($pdo,$subcatId) ; ?></i></h1></li>
    </ul>
	<div>
    	<label><i class="text-success">Filter By Child Category</i></label>
		<select name="browsenewchildcatitems" class="browsenewchildcatitems form-control mt-n2">
			<?php echo fill_childcategory_list($pdo, $subcatId) ; ?>
		</select>
		
    </div>
    
</div>
<div class="newPro">
<?php echo fetch_product_by_subcategory_foruser($pdo,$subcatId) ; ?>
<span class="jQueryNewItem"></span>
</div>
<div class="fetchNewPro"></div>
<span class="jQueryNewItemAppend"></span>
<?php include("footer.php") ; ?>
