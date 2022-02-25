<?php include("header.php") ; ?>
<div class="app-title p-2">
	<div id="loaderCat"></div>
	<ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><h1 class="text-muted">&ensp;<i class="fa fa-star"></i>&ensp;<i>Featured Items</i></h1></li>
    </ul>
	<div>
   		<label><i class="text-success">Filter By Category</i></label>
		<select name="browsenewfeatureditems" class="browsenewfeatureditems form-control mt-n2">
			<option value="0">All</option>
			<?php echo get_active_category($pdo) ; ?>
		</select>
		
    </div>
</div>
<div class="newPro">
<?php echo fetch_featuredallproduct_foruser($pdo) ; ?>
<span class="jQueryNewItem"></span>
</div>

<div class="fetchNewPro"></div>
<span class="jQueryNewItemAppend"></span>
<?php include("footer.php") ; ?>