<?php 
include("header.php") ; 
$search = filter_var($_GET['search_keyword'], FILTER_SANITIZE_STRING) ;
?>
<div class="app-title p-3">
	<ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><h4 class="text-muted">&ensp;<i class="fa fa-search"></i>&ensp;<i>Search / <?php echo $search ; ?></i></h4></li>
    </ul>
</div>
<?php echo fetch_searchallproduct_foruser($pdo,$search) ; ?>
<span class="jQueryLoadSearchItem"></span>
<?php include("footer.php") ; ?>