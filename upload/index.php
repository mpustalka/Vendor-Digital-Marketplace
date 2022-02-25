<?php include("header.php") ; ?>
<div class="app-title">
        <div>
          <h1 class="text-muted ml-n3">&ensp;<i class="fa fa-chevron-circle-right"></i>&ensp;<i>New Items</i></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
		  <li class="breadcrumb-item"><a href="<?php echo BASE_URL.'new/' ; ?>" class="btn btn-sm btn-success">Browse All New Items</a></li>
        </ul>
 </div>
<div class="row">
<?php echo fetch_newproduct_foruser($pdo) ; ?>
</div>
<div class="app-title mt-4">
        <div>
          <h1 class="text-muted ml-n3">&ensp;<i class="fa fa-star"></i>&ensp;<i>Featured Items</i></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
		  <li class="breadcrumb-item"><a href="<?php echo BASE_URL.'featured/' ; ?>" class="btn btn-sm btn-success">Browse All Featured Items</a></li>
        </ul>
 </div>
<div class="row">
<?php echo fetch_featuredproduct_foruser($pdo) ; ?>
</div>
<?php 
if(check_item_selling_or_not($pdo) > 0) {
?>
<div class="app-title mt-4">
        <div>
          <h1 class="text-muted ml-n3">&ensp;<i class="fa fa-chart-bar"></i>&ensp;<i>Top Selling Items</i></h1>
        </div>
</div>
<div class="row">
<?php echo fetch_maxsaleproduct_foruser($pdo) ; ?>
</div>
<?php 
} 
?>
<?php include("footer.php") ; ?>