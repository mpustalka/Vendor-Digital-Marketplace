<?php include("header.php") ; 
$pageSlug = filter_var($_GET['page_slug'], FILTER_SANITIZE_STRING);
$checkPageStatus = check_activepage_for_user($pdo,$pageSlug) ; 
if($checkPageStatus == 0) {
	header("location: ".BASE_URL."") ;
	exit ;
}
?>
<div class="app-title">
        <div>
          <h1 class="text-muted ml-n3">&ensp;<i class="fa fa-angle-double-right"></i>&ensp;<i><?php echo get_page_title($pdo,$pageSlug); ?></i></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
		  <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		  <li class="breadcrumb-item"><a href="<?php echo BASE_URL ; ?>" >Home</a></li>
        </ul>
 </div>
<div class="tile">
	<div class="row p-3">
		<div class="text-wordbreak">
			<?php echo get_page_content($pdo,$pageSlug) ; ?>
		</div>
	</div>
</div>
<?php include("footer.php") ; ?>