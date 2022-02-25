<?php include("header.php") ; include("countFunctions.php") ; ?>
<div class="app-title">
        <div>
          <h1><i class="fa fa-laptop"></i> Admin Dashboard</h1>
		  <p class="text-success">Hassle Free Analysis for Users & Announcements.</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?php echo ADMIN_URL ; ?>dashboard.php">Dashboard</a></li>
        </ul>
 </div>
 <div class="row">
		<div class="col-lg-12 col-md-12">
			<h5 class="border-bottom text-muted"><i class="fa fa-download text-success"></i>&ensp;Top 5 Selling Item</h5>
		</div>
		<div class="col-lg-12 col-md-12 bg-white rounded p-3">
			<canvas id="graphCanvas"></canvas>
		</div>
		<div class="col-lg-12 col-md-12 mt-3">
			<h5 class="border-bottom text-muted"><i class="fa fa-cart-plus text-info"></i>&ensp;Top 5 Users</h5>
		</div>
		<div class="col-lg-12 col-md-12 bg-white rounded p-3">
			<canvas id="userCanvas"></canvas>
		</div>
</div>
<div class="row">
 		<div class="col-lg-12 col-md-12">
				<h5 class="border-bottom text-muted">Today Analysis</h5>
			</div>
        <div class="col-md-4 col-lg-4">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-list-ol fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Sales</h5>
              <p><b><?php echo count_today_sale($pdo) ; ?></b></p>
            </div>
          </div>
        </div>
		<div class="col-md-4 col-lg-4">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-usd fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Earning</h5>
              <p><b><?php echo  count_today_earning($pdo) ; ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-lg-4">
          <div class="widget-small warning coloured-icon"><i class="icon fa fa-signal fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Top Item</h5>
              <p><b>
			  <?php 
			  $todayItemId = count_today_biggest_sold_item($pdo) ;
			  $itemName = get_item_title($pdo,$todayItemId) ;
				$strLength = strip_tags($itemName);
				if(strlen($strLength) > 20) {
					$dot = "...";
				} else {
					$dot = "";
				}
				if(!empty($todayItemId)){
				echo '<a href="'.BASE_URL.'item/'.$todayItemId.'" class="text-info" target="_blank">'.strip_tags(substr_replace($strLength, $dot, 20)).'</a>' ;
				} else {
				echo "No Sale";
				}
			  ?>
			  </b></p>
            </div>
          </div>
        </div>
</div>
<div class="row">
 		<div class="col-lg-12 col-md-12">
				<h5 class="border-bottom text-muted">This Month Analysis</h5>
			</div>
        <div class="col-md-4 col-lg-4">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-list-ol fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Sales</h5>
              <p><b><?php echo count_thismonth_sale($pdo) ; ?></b></p>
            </div>
          </div>
        </div>
		<div class="col-md-4 col-lg-4">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-usd fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Earning</h5>
              <p><b><?php echo  count_thismonth_earning($pdo) ; ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-lg-4">
          <div class="widget-small warning coloured-icon"><i class="icon fa fa-signal fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Top Item</h5>
              <p><b>
			  <?php 
			  $thismonthItemId = count_thismonth_biggest_sold_item($pdo) ;
			  $thismonthitemName = get_item_title($pdo,$thismonthItemId) ;
				$strLength = strip_tags($thismonthitemName);
				if(strlen($strLength) > 20) {
					$dot = "...";
				} else {
					$dot = "";
				}
				if(!empty($thismonthItemId)){
				echo '<a href="'.BASE_URL.'item/'.$thismonthItemId.'" class="text-info" target="_blank">'.strip_tags(substr_replace($strLength, $dot, 20)).'</a>' ;
				} else {
				echo "No Sale";
				}
			  ?>
			  </b></p>
            </div>
          </div>
        </div>
</div>
<div class="row">
 		<div class="col-lg-12 col-md-12">
				<h5 class="border-bottom text-muted">Total Analysis</h5>
			</div>
        <div class="col-md-4 col-lg-4">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-list-ol fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Sales</h5>
              <p><b><?php echo count_total_sale($pdo) ; ?></b></p>
            </div>
          </div>
        </div>
		<div class="col-md-4 col-lg-4">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-usd fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Earning</h5>
              <p><b><?php echo  count_total_earning($pdo) ; ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-lg-4">
          <div class="widget-small warning coloured-icon"><i class="icon fa fa-signal fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Top Item</h5>
              <p><b>
			  <?php 
			  $totalItemId = count_total_biggest_sold_item($pdo) ;
			  $totalitemName = get_item_title($pdo,$totalItemId) ;
				$strLength = strip_tags($totalitemName);
				if(strlen($strLength) > 20) {
					$dot = "...";
				} else {
					$dot = "";
				}
				if(!empty($totalItemId)){
				echo '<a href="'.BASE_URL.'item/'.$totalItemId.'" class="text-info" target="_blank">'.strip_tags(substr_replace($strLength, $dot, 20)).'</a>' ;
				} else {
				echo "No Sale";
				}
			  ?>
			  </b></p>
            </div>
          </div>
        </div>
</div>

<div class="row">
 		<div class="col-lg-12 col-md-12">
				<h5 class="border-bottom text-muted">Item Analysis</h5>
			</div>
        <div class="col-md-4 col-lg-4">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-cubes fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Total Items</h5>
              <p><b><?php echo count_total_item($pdo) ; ?></b></p>
            </div>
          </div>
        </div>
		<div class="col-md-4 col-lg-4">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-check fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Active Items</h5>
              <p><b><?php echo  count_total_active_item($pdo) ; ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-lg-4">
          <div class="widget-small danger coloured-icon"><i class="icon fa fa-times fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Deactive Item</h5>
              <p><b><?php echo  count_total_deactive_item($pdo) ; ?></b></p>
            </div>
          </div>
        </div>
</div>

<div class="row">
 		<div class="col-lg-12 col-md-12">
				<h5 class="border-bottom text-muted">User Analysis</h5>
			</div>
        <div class="col-md-4 col-lg-4">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Total Users</h5>
              <p><b><?php echo count_total_user($pdo) ; ?></b></p>
            </div>
          </div>
        </div>
		<div class="col-md-4 col-lg-4">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-check fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Active User</h5>
              <p><b><?php echo  count_total_active_user($pdo) ; ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-lg-4">
          <div class="widget-small danger coloured-icon"><i class="icon fa fa-times fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Blocked User</h5>
              <p><b><?php echo  count_total_deactive_user($pdo) ; ?></b></p>
            </div>
          </div>
        </div>
</div>
<?php include("footer.php") ; ?>
