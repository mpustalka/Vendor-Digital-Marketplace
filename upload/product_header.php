<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo get_item_title($pdo,$itemId) ; ?></title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta property="og:site_name" content="<?php echo BASE_URL ; ?>" />
	<meta property="og:title" content="<?php echo get_item_title($pdo,$itemId) ; ?>" />
	<meta property="og:description" content="<?php echo get_item_title($pdo,$itemId) ; ?>" />
	<meta property="og:url" content="<?php echo BASE_URL."item/".$itemId ; ?>" />
	<meta property="og:type" content="article" />
	<meta property="article:publisher" content="<?php echo BASE_URL ; ?>" />
	<meta property="article:section" content="Coding" />
	<meta property="article:tag" content="<?php echo get_item_tags($pdo,$itemId) ; ?>" />
	<meta property="og:image" content="<?php echo get_item_previewImage_formetatags($pdo,$itemId) ; ?>" />
	<meta property="og:image:secure_url" content="<?php echo get_item_previewImage_formetatags($pdo,$itemId) ; ?>" />
	<meta property="og:image:width" content="1280" />
	<meta property="og:image:height" content="640" />
	<meta property="twitter:card" content="summary_large_image" />
	<meta property="twitter:image" content="<?php echo get_item_previewImage_formetatags($pdo,$itemId) ; ?>" />
	
	<link rel="stylesheet" href="<?php echo ADMIN_URL ; ?>css/main.css">
	<link rel="stylesheet" href="<?php echo ADMIN_URL ; ?>css/all.min.css">
	<link rel="stylesheet" href="<?php echo ADMIN_URL ; ?>css/Latofont.css">
	<link rel="stylesheet" href="<?php echo ADMIN_URL ; ?>css/Niconnefont.css">
	<link rel="icon" href="<?php echo ADMIN_URL; ?>images/favicon.png" type="image/png">
	
</head>
<body class="app sidebar-mini">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo text-left" href="<?php echo BASE_URL ; ?>"><img src="<?php echo ADMIN_URL ; ?>images/siteLogo.png" class="img-fluid" alt="Logo"></a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"><i class="fa fa-bars fa-2x"></i></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
	  	<li><button class="btn btn-sm openBtn mt-2"><i class="fa fa-search-plus text-warning"></i></button></li>
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
		  <?php if(isset($_SESSION['user']['user_id'])){ ?>
		  	<li><a class="dropdown-item" href="<?php echo BASE_URL ; ?>index.php"><i class="fa fa-envelope"></i> Email</a></li>
            <li><a class="dropdown-item"  href="<?php echo BASE_URL ; ?>change_password.php"><i class="fa fa-key"></i> Password</a></li>
            <li><a class="dropdown-item" href="<?php echo BASE_URL ; ?>logout.php"><i class="fa fa-sign-out-alt fa-lg"></i> Logout</a></li>
		  <?php } else { ?>
		  	<li><a class="dropdown-item" href="<?php echo BASE_URL ; ?>login.php"><i class="fa fa-envelope"></i> Login / SIgnUp</a></li>
		  <?php } ?>
          </ul>
        </li>
      </ul>
    </header>
	
	<!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
	<?php if(isset($_SESSION['user']['user_id'])){ ?>
      <div class="app-sidebar__user"><i class="fa fa-user fa-2x text-warning"></i>
        <div>
          <p class="app-sidebar__user-name"><small><?php echo get_userfullname($pdo) ;  ?></small></p>
          <p class="app-sidebar__user-designation"><small><?php echo get_useremail($pdo) ; ?></small></p>
        </div>
      </div>
	  <?php } ?>
      <ul class="app-menu">
        <li><a class="app-menu__item" href="<?php echo BASE_URL ; ?>"><i class="app-menu__icon fa fa-home"></i><span class="app-menu__label">Home</span></a></li>
		<li><a class="app-menu__item" href="<?php echo BASE_URL."new/" ; ?>"><i class="app-menu__icon fa fa-certificate"></i><span class="app-menu__label">New Items</span></a></li>
		<li><a class="app-menu__item" href="<?php echo BASE_URL."featured/" ; ?>"><i class="app-menu__icon fa fa-star text-warning"></i><span class="app-menu__label text-warning">Featured Items</span></a></li>
		<li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-align-left"></i><span class="app-menu__label">Category</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <?php echo fetch_active_category_foruser($pdo) ; ?>
          </ul>
        </li>
		<?php
			$subcat = $pdo->prepare("select s_c_id from item_subcategory where s_status ='1' group by s_c_id");
			$subcat->execute();
			$subcatcheck = $subcat->rowCount();
			$resultsubcat = $subcat->fetchAll();
			if($subcatcheck > 0) {
		?>
		<li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-align-center"></i><span class="app-menu__label">Sub Category</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
		  	<?php
				foreach($resultsubcat as $rowsubcat){
					$catId = _e($rowsubcat['s_c_id']);
					?>
					<p class="text-warning ml-3"><?php echo get_category_name($pdo,$catId) ; ?></p>
					<ul class="treeview-menu mt-n3">
					<?php echo fetch_active_subcategory_foruser($pdo,$catId) ; ?>
					</ul>
					<?php
				}
			?>
		   </ul>
		</li>
		<?php 
			}
		?>
		<?php if(isset($_SESSION['user']['user_id'])){ ?>
		<li><a class="app-menu__item" href="<?php echo BASE_URL."downloads/" ; ?>"><i class="app-menu__icon fa fa-download"></i><span class="app-menu__label">Downloads</span></a></li>
		<li><a class="app-menu__item" href="<?php echo BASE_URL."purchases/" ; ?>"><i class="app-menu__icon fa fa-shopping-cart"></i><span class="app-menu__label">Purchases</span></a></li>
		<?php } ?>
		<?php 
			$checkSlug = check_slug_for_user($pdo) ;
			if($checkSlug > '0') {
		?>
		<li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-hand-point-right"></i><span class="app-menu__label">Pages</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <?php echo fetch_active_pages_foruser($pdo) ; ?>
          </ul>
        </li>
		<?php } ?>
	  </ul>
    </aside>
	
	<main class="app-content">
	
	<div class="row">
		<div id="myOverlay" class="overlay">
		  <span class="closebtn" title="Close">×</span>
		  <div class="overlay-content">
			<form action="<?php echo BASE_URL.'usersearch.php' ; ?>" method="post">
			  <input type="text" placeholder="For Example : Wordpress Theme or PHP Script Or A Letter Logo" name="search_keyword">
			  <button type="submit"><i class="fa fa-search"></i></button>
			</form>
		  </div>
		</div>
	</div>