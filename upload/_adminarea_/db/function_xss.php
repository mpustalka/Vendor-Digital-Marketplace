<?php
function _e($string) {
	return htmlentities(strip_tags($string), ENT_QUOTES, 'UTF-8');
}
function code($no_of_char)
	{
		$code='';
		$possible_char="0123456789";
		while($no_of_char>0)
			{
				$code.=substr($possible_char, rand(0, strlen($possible_char)-1), 1);
				$no_of_char--;
			}
		return $code;
	}
function check_item_selling_or_not($pdo){
	$query = "SELECT * FROM item_db WHERE  item_sale > '0'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
}
function fetch_maxsaleproduct_foruser($pdo){
	$limit = "4";
	
	$query = "SELECT count(item_Id) as c, item_Id, item_name, item_rating, item_preview,item_thumbnail, regular_price FROM item_db WHERE item_status = '1' and item_sale > 0 group by item_Id order by c DESC LIMIT ".$limit."";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$strLength = strip_tags($row['item_name']);
		if(strlen($strLength) > 20) {
			$dot = "...";
		} else {
			$dot = "";
		}
		$subCatName = get_subcategory_name_foritem($pdo,_e($row['item_Id'])) ;
		$rating = _e($row['item_rating']);
		$star = "";
		if($rating != '0.00'){
			
			$star = '<img src="'.ADMIN_URL.'images/fillStar.png"  class="img-star" alt="Rating">('._e($row['item_rating']).')';
		}
		$output .= '<div class="col-lg-3 p-1 myLink">
						<a href="'.BASE_URL.'item/'._e($row['item_Id']).'">
							<div class="card card-custom bg-white border-white">
								<div class="card-custom-img img-fluid">
									<img src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_preview']).'"  class="myImage" alt="Preview Image">
								</div>
								<div class="card-custom-avatar">
									<img class="img-fluid" src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_thumbnail']).'" alt="Thumbnail Image" />
								</div>
								<div class="card-body cardBody">
    								<h5 class="text-muted">'.strip_tags(substr_replace($row['item_name'], $dot, 20)).'</h5>
									<hr>
									<div class="row">
										<div class="col-lg-12">
											<span class="text-left">
											'.$subCatName.'
											</span><span class="spanRight">'.$star.'&ensp;<button class="btn btn-light btn-sm mt-n1">$ '.$row['regular_price'].'</button></span>
										</div>
									</div>
 								</div>
							</div>
						</a>
						</div>
		';
	}
	return ($output);
}
function check_page_slug($pdo,$pageSlug){
	$query = "SELECT * FROM ot_admin_pages WHERE  page_slug = '".$pageSlug."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
}
function check_page_slug_byId($pdo,$pageSlug,$pageId){
	$query = "SELECT * FROM ot_admin_pages WHERE  page_slug = '".$pageSlug."' and page_id != '".$pageId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
}
function check_slug_for_user($pdo){
	$query = "SELECT * FROM ot_admin_pages WHERE  page_status = '1'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
}
function fetch_active_pages_foruser($pdo){
	$query = "SELECT * FROM ot_admin_pages WHERE page_status = '1' order by page_name ASC";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<a class="treeview-item" href="'.BASE_URL.'page/'._e($row["page_slug"]).'"><i class="icon fa fa-caret-right"></i> '._e($row["page_name"]).'</a></li>';
	}
	return ($output);
}
function get_page_title($pdo,$pageSlug){
	$query = "SELECT * FROM ot_admin_pages WHERE page_status = '1' and page_slug = '".$pageSlug."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= strip_tags($row["page_name"]) ;
	}
	return ($output);
}
function get_page_content($pdo,$pageSlug){
	$query = "SELECT * FROM ot_admin_pages WHERE page_status = '1' and page_slug = '".$pageSlug."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= base64_decode($row["page_text"]) ;
	}
	return ($output);
}
function check_activepage_for_user($pdo,$pageSlug){
	$query = "SELECT * FROM ot_admin_pages WHERE  page_status = '1' and page_slug = '".$pageSlug."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
}
function check_revoke_right_of_user($pdo,$itemId){
	$query = "SELECT * FROM item_rating WHERE  item_rating_itemid = '".$itemId."' and rating_rights_revoke = '1'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
}
function set_categoryname_intosubcategory($pdo,$categoryId,$categoryName) {
	$query = "SELECT * FROM item_subcategory WHERE s_c_id = '".$categoryId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	if($total > 0){
		foreach($result as $row){
			$subcategoryId = _e($row['s_id']) ;
			$upd = $pdo->prepare("update item_subcategory set s_c_name = '".$categoryName."' where s_id = '".$subcategoryId."'");
			$upd->execute();
		}
	}
	return $total ;
}
function set_categoryname_intochildcategory($pdo,$categoryId,$categoryName) {
	$query = "SELECT * FROM item_childcategory WHERE ch_c_id = '".$categoryId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	if($total > 0){
		foreach($result as $row){
			$childcategoryId = _e($row['ch_id']) ;
			$upd = $pdo->prepare("update item_childcategory set ch_c_name = '".$categoryName."' where ch_id = '".$childcategoryId."'");
			$upd->execute();
		}
	}
	return $total ;
}
function set_subcategoryname_intochildcategory($pdo,$subcategoryId,$subcategoryName,$categoryId) {
	$catName = get_category_name($pdo,$categoryId) ;
	$query = "SELECT * FROM item_childcategory WHERE ch_s_id = '".$subcategoryId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	if($total > 0){
		foreach($result as $row){
			$childcategoryId = _e($row['ch_id']) ;
			$upd = $pdo->prepare("update item_childcategory set ch_s_name = '".$subcategoryName."' , ch_s_id = '".$subcategoryId."' , ch_c_id = '".$categoryId."', ch_c_name = '".$catName."' where ch_id = '".$childcategoryId."'");
			$upd->execute();
		}
	}
	return $total ;
}
function set_subcategory_to_deactive($pdo,$categoryId) {
	$query = "SELECT * FROM item_subcategory WHERE s_c_id = '".$categoryId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	if($total > 0){
		foreach($result as $row){
			$subcategoryId = _e($row['s_id']) ;
			$upd = $pdo->prepare("update item_subcategory set s_status = '0' where s_id = '".$subcategoryId."'");
			$upd->execute();
		}
	}
	return $total ;
}
function set_childcategory_to_deactive($pdo,$categoryId) {
	$query = "SELECT * FROM item_childcategory WHERE ch_c_id = '".$categoryId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	if($total > 0){
		foreach($result as $row){
			$childcategoryId = _e($row['ch_id']) ;
			$upd = $pdo->prepare("update item_childcategory set ch_status = '0' where ch_id = '".$childcategoryId."'");
			$upd->execute();
		}
	}
	return $total ;
}
function set_item_to_deactive($pdo,$categoryId) {
	$query = "SELECT * FROM item_db WHERE main_category = '".$categoryId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	if($total > 0){
		foreach($result as $row){
			$itemId = _e($row['item_Id']) ;
			$upd = $pdo->prepare("update item_db set item_status = '0' where item_Id = '".$itemId."'");
			$upd->execute();
		}
	}
	return $total ;
}
function set_subcategory_to_active($pdo,$categoryId) {
	$query = "SELECT * FROM item_subcategory WHERE s_c_id = '".$categoryId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	if($total > 0){
		foreach($result as $row){
			$subcategoryId = _e($row['s_id']) ;
			$upd = $pdo->prepare("update item_subcategory set s_status = '1' where s_id = '".$subcategoryId."'");
			$upd->execute();
		}
	}
	return $total ;
}
function set_childcategory_to_active($pdo,$categoryId) {
	$query = "SELECT * FROM item_childcategory WHERE ch_c_id = '".$categoryId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	if($total > 0){
		foreach($result as $row){
			$childcategoryId = _e($row['ch_id']) ;
			$upd = $pdo->prepare("update item_childcategory set ch_status = '1' where ch_id = '".$childcategoryId."'");
			$upd->execute();
		}
	}
	return $total ;
}
function set_item_to_active($pdo,$categoryId) {
	$query = "SELECT * FROM item_db WHERE main_category = '".$categoryId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	if($total > 0){
		foreach($result as $row){
			$itemId = _e($row['item_Id']) ;
			$upd = $pdo->prepare("update item_db set item_status = '1' where item_Id = '".$itemId."'");
			$upd->execute();
		}
	}
	return $total ;
}
function set_childcategory_to_deactive_viasubcategory($pdo,$subcategoryId) {
	$query = "SELECT * FROM item_childcategory WHERE ch_s_id = '".$subcategoryId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	if($total > 0){
		foreach($result as $row){
			$childcategoryId = _e($row['ch_id']) ;
			$upd = $pdo->prepare("update item_childcategory set ch_status = '0' where ch_id = '".$childcategoryId."'");
			$upd->execute();
		}
	}
	return $total ;
}
function set_item_to_deactive_viasubcategory($pdo,$subcategoryId) {
	$query = "SELECT * FROM item_db WHERE sub_category = '".$subcategoryId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	if($total > 0){
		foreach($result as $row){
			$itemId = _e($row['item_Id']) ;
			$upd = $pdo->prepare("update item_db set item_status = '0' where item_Id = '".$itemId."'");
			$upd->execute();
		}
	}
	return $total ;
}
function set_childcategory_to_active_viasubcategory($pdo,$subcategoryId) {
	$query = "SELECT * FROM item_childcategory WHERE ch_s_id = '".$subcategoryId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	if($total > 0){
		foreach($result as $row){
			$childcategoryId = _e($row['ch_id']) ;
			$upd = $pdo->prepare("update item_childcategory set ch_status = '1' where ch_id = '".$childcategoryId."'");
			$upd->execute();
		}
	}
	return $total ;
}
function set_item_to_active_viasubcategory($pdo,$subcategoryId) {
	$query = "SELECT * FROM item_db WHERE sub_category = '".$subcategoryId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	if($total > 0){
		foreach($result as $row){
			$itemId = _e($row['item_Id']) ;
			$upd = $pdo->prepare("update item_db set item_status = '1' where item_Id = '".$itemId."'");
			$upd->execute();
		}
	}
	return $total ;
}
function set_item_to_deactive_viachildcategory($pdo,$childcategoryId) {
	$query = "SELECT * FROM item_db WHERE child_category = '".$childcategoryId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	if($total > 0){
		foreach($result as $row){
			$itemId = _e($row['item_Id']) ;
			$upd = $pdo->prepare("update item_db set item_status = '0' where item_Id = '".$itemId."'");
			$upd->execute();
		}
	}
	return $total ;
}
function set_item_to_active_viachildcategory($pdo,$childcategoryId) {
	$query = "SELECT * FROM item_db WHERE child_category = '".$childcategoryId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	if($total > 0){
		foreach($result as $row){
			$itemId = _e($row['item_Id']) ;
			$upd = $pdo->prepare("update item_db set item_status = '1' where item_Id = '".$itemId."'");
			$upd->execute();
		}
	}
	return $total ;
}
function count_total_item($pdo){
	$query = "SELECT * FROM item_db WHERE 1";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
}
function count_total_active_item($pdo){
	$query = "SELECT * FROM item_db WHERE item_status='1'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
}
function count_total_deactive_item($pdo){
	$query = "SELECT * FROM item_db WHERE item_status='0'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
}
function count_total_user($pdo){
	$query = "SELECT * FROM ot_user WHERE 1";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
}
function count_total_active_user($pdo){
	$query = "SELECT * FROM ot_user WHERE user_status='1'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
}
function count_total_deactive_user($pdo){
	$query = "SELECT * FROM ot_user WHERE user_blocked='1'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
}
function count_today_sale($pdo){
	$todayDate = date("Y-m-d") ;
	$query = "SELECT count(payment_id) as total_sale FROM ot_payments WHERE complete_status = '1' and payment_status = 'Completed' and payment_date='".$todayDate."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= _e($row['total_sale']) ;
	}
	return _e($output) ;
}
function count_today_earning($pdo){
	$todayDate = date("Y-m-d") ;
	$query = "SELECT sum(p_total_amt) as total_sale FROM ot_payments WHERE complete_status = '1' and payment_status = 'Completed' and payment_date='".$todayDate."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= _e($row['total_sale']) ;
	}
	if(empty($output)){
		$output = '0.00';
	}
	return _e($output) ;
}
function count_today_biggest_sold_item($pdo){
	$todayDate = date("Y-m-d") ;
	$query = "SELECT count(p_item_id) as c, p_item_id FROM `ot_payments` WHERE complete_status = '1' and payment_status = 'Completed' and payment_date = '".$todayDate."' GROUP BY p_item_id order by c desc limit 1 ";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$itemId = _e($row['p_item_id']) ;
		$output .= $itemId ;
	}
	
	return _e($output) ;
}
function count_thismonth_sale($pdo){
	$firstDate = date("Y-m-01") ;
	$lastDate = date("Y-m-t") ;
	$query = "SELECT count(payment_id) as total_sale FROM ot_payments WHERE complete_status = '1' and payment_status = 'Completed' and payment_date between '".$firstDate."' and '".$lastDate."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= _e($row['total_sale']) ;
	}
	return _e($output) ;
}
function count_thismonth_earning($pdo){
	$firstDate = date("Y-m-01") ;
	$lastDate = date("Y-m-t") ;
	$query = "SELECT sum(p_total_amt) as total_sale FROM ot_payments WHERE complete_status = '1' and payment_status = 'Completed' and payment_date between '".$firstDate."' and '".$lastDate."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= _e($row['total_sale']) ;
	}
	if(empty($output)){
		$output = '0.00';
	}
	return _e($output) ;
}
function count_thismonth_biggest_sold_item($pdo){
	$firstDate = date("Y-m-01") ;
	$lastDate = date("Y-m-t") ;
	$query = "SELECT count(p_item_id) as c, p_item_id FROM `ot_payments` WHERE complete_status = '1' and payment_status = 'Completed' and payment_date between '".$firstDate."' and '".$lastDate."' GROUP BY p_item_id order by c desc limit 1 ";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$itemId = _e($row['p_item_id']) ;
		$output .= $itemId ;
	}
	
	return _e($output) ;
}
function count_total_sale($pdo){
	$query = "SELECT count(payment_id) as total_sale FROM ot_payments WHERE complete_status = '1' and payment_status = 'Completed'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= _e($row['total_sale']) ;
	}
	return _e($output) ;
}
function count_total_earning($pdo){
	$query = "SELECT sum(p_total_amt) as total_sale FROM ot_payments WHERE complete_status = '1' and payment_status = 'Completed'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= _e($row['total_sale']) ;
	}
	if(empty($output)){
		$output = '0.00';
	}
	return _e($output) ;
}
function count_total_biggest_sold_item($pdo){
	$query = "SELECT count(p_item_id) as c, p_item_id FROM `ot_payments` WHERE complete_status = '1' and payment_status = 'Completed' GROUP BY p_item_id order by c desc limit 1 ";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$itemId = _e($row['p_item_id']) ;
		$output .= $itemId ;
	}
	
	return _e($output) ;
}
function fetch_searchallproduct_foruser($pdo,$search){
	$limit = "8";
	$newstring = implode(", ", preg_split("/[\s]+/", $search));
	$sql = "SELECT count(*) as number_rows FROM `item_db` WHERE item_status ='1' and (item_name LIKE '%$search%' OR item_tags LIKE '%$newstring%')" ;
	$newitem = $pdo->prepare($sql);
	$newitem->execute(); 
	$items = $newitem->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($items as $row) {
		$totalRows = _e($row['number_rows']);
	}
	$query = "SELECT * FROM `item_db` WHERE item_status ='1' and (item_name LIKE '%$search%' OR item_tags LIKE '%$newstring%') order by item_Id DESC LIMIT ".$limit."";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	$output .='<div class="row">';
	foreach($result as $row)
	{
		$item_id = _e($row['item_Id']);
		$strLength = strip_tags($row['item_name']);
		if(strlen($strLength) > 20) {
			$dot = "...";
		} else {
			$dot = "";
		}
		$subCatName = get_subcategory_name_foritem($pdo,_e($row['item_Id'])) ;
		$rating = _e($row['item_rating']);
		$star = "";
		if($rating != '0.00'){
			
			$star = '<img src="'.ADMIN_URL.'images/fillStar.png"  class="img-star" alt="Rating">('._e($row['item_rating']).')';
		}
		$output .= '<div class="col-lg-3 p-1 myLink">
						<a href="'.BASE_URL.'item/'._e($row['item_Id']).'">
							<div class="card card-custom bg-white border-white">
								<div class="card-custom-img img-fluid">
									<img src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_preview']).'"  class="myImage" alt="Preview Image">
								</div>
								<div class="card-custom-avatar">
									<img class="img-fluid" src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_thumbnail']).'" alt="Thumbnail Image" />
								</div>
								<div class="card-body cardBody">
    								<h5 class="text-muted">'.strip_tags(substr_replace($row['item_name'], $dot, 20)).'</h5>
									<hr>
									<div class="row">
										<div class="col-lg-12">
											<span class="text-left">
											'.$subCatName.'
											</span><span class="spanRight">'.$star.'&ensp;<button class="btn btn-light btn-sm mt-n1">$ '.$row['regular_price'].'</button></span>
										</div>
									</div>
 								</div>
							</div>
						</a>
					</div>
					
		';
	}
	if(empty($item_id)){
			$item_id = "";
		}
	if($totalRows > $limit){
		$output .= '<div class="col-lg-12 justify-content-center">
					<div class="show_more_new_search" id="show_more_new_search'.$item_id.'">
							
							<div class="col text-center p-2">
							<div id="loader-icon"><img src="'.ADMIN_URL.'images/loader.gif" class="img-fluid img-loader" /></div>
							<button id="'.$item_id.'" class="show_more_newest_search btn btn-info btn-sm ann'.$search.'" >Load More</button>
							</div>
							
					</div>
					</div>
					';
		}
		$output .='</div>';
	return ($output);
}
function fetch_searchallproduct_foruser_onload($pdo,$search,$itemId){
	$limit = "8";
	$newstring = implode(", ", preg_split("/[\s]+/", $search));
	$sql = "SELECT count(*) as number_rows FROM `item_db` WHERE item_status ='1' and item_Id < ".$itemId." and (item_name LIKE '%$search%' OR item_tags LIKE '%$newstring%')" ;
	$newitem = $pdo->prepare($sql);
	$newitem->execute(); 
	$items = $newitem->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($items as $row) {
		$totalRows = _e($row['number_rows']);
	}
	$query = "SELECT * FROM `item_db` WHERE item_status ='1' and item_Id < ".$itemId."  and (item_name LIKE '%$search%' OR item_tags LIKE '%$newstring%') order by item_Id DESC LIMIT ".$limit."";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	$output .='<div class="row">';
	foreach($result as $row)
	{
		$item_id = _e($row['item_Id']);
		$strLength = strip_tags($row['item_name']);
		if(strlen($strLength) > 20) {
			$dot = "...";
		} else {
			$dot = "";
		}
		$subCatName = get_subcategory_name_foritem($pdo,_e($row['item_Id'])) ;
		$rating = _e($row['item_rating']);
		$star = "";
		if($rating != '0.00'){
			
			$star = '<img src="'.ADMIN_URL.'images/fillStar.png"  class="img-star" alt="Rating">('._e($row['item_rating']).')';
		}
		$output .= '<div class="col-lg-3 p-1 myLink">
						<a href="'.BASE_URL.'item/'._e($row['item_Id']).'">
							<div class="card card-custom bg-white border-white">
								<div class="card-custom-img img-fluid">
									<img src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_preview']).'"  class="myImage" alt="Preview Image">
								</div>
								<div class="card-custom-avatar">
									<img class="img-fluid" src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_thumbnail']).'" alt="Thumbnail Image" />
								</div>
								<div class="card-body cardBody">
    								<h5 class="text-muted">'.strip_tags(substr_replace($row['item_name'], $dot, 20)).'</h5>
									<hr>
									<div class="row">
										<div class="col-lg-12">
											<span class="text-left">
											'.$subCatName.'
											</span><span class="spanRight">'.$star.'&ensp;<button class="btn btn-light btn-sm mt-n1">$ '.$row['regular_price'].'</button></span>
										</div>
									</div>
 								</div>
							</div>
						</a>
					</div>
					
		';
	}
	if(empty($item_id)){
			$item_id = "";
		}
	if($totalRows > $limit){
		$output .= '<div class="col-lg-12 justify-content-center">
					<div class="show_more_new_search" id="show_more_new_search'.$item_id.'">
							
							<div class="col text-center p-2">
							<div id="loader-icon"><img src="'.ADMIN_URL.'images/loader.gif" class="img-fluid img-loader" /></div>
							<button id="'.$item_id.'" class="show_more_newest_search btn btn-info btn-sm ann'.$search.'" >Load More</button>
							</div>
							
					</div>
					</div>
					';
		}
		$output .='</div>';
	return ($output);
}

function user_purchased_tag($pdo,$userId,$itemId){
	$query = "SELECT * FROM ot_payments WHERE p_item_id='".$itemId."' and p_user_id = '".$userId."' and payment_status = 'Completed'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total = $statement->rowCount();
	$output = '';
	if($total > 0) {
		foreach($result as $row)
		{
			$output .='<span class="bg-success text-white p-1 rounded"><small>Purchased</small></span>';
		}
	}
	return ($output);
}

function get_usercomment($pdo,$itemId){
	$sql = "SELECT count(*) as number_rows FROM ot_user_comment WHERE comment_status = '1' and  comment_item_id='".$itemId."' order by comment_id desc " ;
	$newitem = $pdo->prepare($sql);
	$newitem->execute(); 
	$items = $newitem->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($items as $row) {
		$totalRows = _e($row['number_rows']);
	}
	$commentlimit = 4 ;
	$query = "SELECT * FROM ot_user_comment WHERE comment_status = '1' and  comment_item_id='".$itemId."' order by comment_id desc limit ".$commentlimit."";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	$output = '<div class="row p-3">';
	foreach($result as $row)
		{
		$commentId = _e($row['comment_id']) ;
		$userId = _e($row['comment_user_id']) ;
		$comment = strip_tags($row['user_comment']) ;
		$adminComment = base64_decode($row['admin_comment']) ;
		$adminvisibleComment = '';
		if(!empty($adminComment)){
			$adminvisibleComment = '<div class="col-lg-12 mt-2">
								<i class="fa fa-user-secret text-success"></i> &ensp;<b>Admin</b> <i class="fa fa-check-circle text-success"></i>
							</div>
							<div class="col-lg-12 p-2">
								'.$adminComment.'
							</div>
							<div class="col mt-n2"><hr></div>
			';
		} else {
			$adminvisibleComment = '<div class="col mt-n2"><hr></div>' ;
		}
		$userName = get_userfullname_byid($pdo,$userId) ;
			$output .= '<div class="col-lg-12 mt-2">
							<i class="fa fa-user"></i> &ensp;'.$userName.' &ensp; '.user_purchased_tag($pdo,$userId,$itemId).'
						</div>	
						<div class="col-lg-12 text-muted p-2">
							'.$comment.'
						</div>
						'.$adminvisibleComment.'
						';
		}
	if($totalRows > $commentlimit){
		$output .= '<div class="col-lg-12 justify-content-center">
					<div class="show_more_new_comment" id="show_more_new_comment'.$itemId.'">
							
							<div class="col text-center p-2">
							<div id="loader-icon"><img src="'.ADMIN_URL.'images/loader.gif" class="img-fluid img-loader" /></div>
							<button id="'.$itemId.'" class="show_more_newest_comment btn btn-info btn-sm ann'.$commentId.'" >Load More</button>
							</div>
							
					</div>
					</div>
					';
		}
	$output .= '</div>';
	return $output ;
}
function get_usercomment_onload($pdo,$itemId,$commentId){
	$sql = "SELECT count(*) as number_rows FROM ot_user_comment WHERE comment_status = '1' and  comment_item_id='".$itemId."' and comment_id < ".$_GET['commentId']." order by comment_id desc " ;
	$newitem = $pdo->prepare($sql);
	$newitem->execute(); 
	$items = $newitem->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($items as $row) {
		$totalRows = _e($row['number_rows']);
	}
	$commentlimit = 4 ;
	$query = "SELECT * FROM ot_user_comment WHERE comment_status = '1' and  comment_item_id='".$itemId."' and comment_id < ".$_GET['commentId']."  order by comment_id desc limit ".$commentlimit."";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	$output = '<div class="row p-3">';
	foreach($result as $row)
		{
		$commentId = _e($row['comment_id']) ;
		$userId = _e($row['comment_user_id']) ;
		$comment = strip_tags($row['user_comment']) ;
		$adminComment = base64_decode($row['admin_comment']) ;
		$adminvisibleComment = '';
		if(!empty($adminComment)){
			$adminvisibleComment = '<div class="col-lg-12 mt-2">
								<i class="fa fa-user-secret text-success"></i> &ensp;<b>Admin</b> <i class="fa fa-check-circle text-success"></i>
							</div>
							<div class="col-lg-12 border-bottom p-2">
								'.$adminComment.'
							</div>
							<div class="col mt-n2"><hr></div>
			';
		} else {
			$adminvisibleComment = '<div class="col mt-n2"><hr></div>' ;
		}
		$userName = get_userfullname_byid($pdo,$userId) ;
			$output .= '<div class="col-lg-12 mt-2">
							<i class="fa fa-user"></i> &ensp;'.$userName.' &ensp; '.user_purchased_tag($pdo,$userId,$itemId).'
						</div>	
						<div class="col-lg-12 text-muted p-2">
							'.$comment.'
						</div>
						'.$adminvisibleComment.'
						';
		}
	if($totalRows > $commentlimit){
		$output .= '<div class="col-lg-12 justify-content-center">
					<div class="show_more_new_comment" id="show_more_new_comment'.$itemId.'">
							
							<div class="col text-center p-2">
							<div id="loader-icon"><img src="'.ADMIN_URL.'images/loader.gif" class="img-fluid img-loader" /></div>
							<button id="'.$itemId.'" class="show_more_newest_comment btn btn-info btn-sm ann'.$commentId.'" >Load More</button>
							</div>
							
					</div>
					</div>
					';
		}
	$output .= '</div>';
	return $output ;
}
function item_was_featured($pdo,$itemId){
	$query = "SELECT * FROM item_db WHERE was_featured = '1' and item_Id='".$itemId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .='<span class="btn btn-secondary btn-sm text-white"><i class="fa fa-star text-warning mt-n1"></i> This Item was Featured</span>';
	}
	return ($output);
}
function get_userfullname_byid($pdo,$uid){
	$query = "SELECT * FROM ot_user WHERE user_id='".$uid."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	if($total > 0) {
	$output = '';
	foreach($result as $row)
		{
			$output = _e($row['user_name']) ; 
		}
	}
	return _e($output) ;
}
function getuser_purchases_by_id($pdo,$uid){
	$query = "SELECT sum(p_total_amt) as toal_amt FROM ot_payments WHERE p_user_id='".$uid."' and payment_status = 'Completed' group by p_user_id";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	$output = '0';
	if($total > 0) {
	foreach($result as $row)
		{
			$output = _e($row['toal_amt']) ; 
		}
	}
	return _e($output) ;
}
function get_useremail_byid($pdo,$uid){
	$query = "SELECT * FROM ot_user WHERE user_id='".$uid."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	if($total > 0) {
	$output = '';
	foreach($result as $row)
		{
			$output = _e($row['user_email']) ; 
		}
	}
	return _e($output) ;
}
function get_item_rating_data_byuser($pdo,$itemId){
	$sql = "SELECT count(*) as number_rows FROM item_rating WHERE item_rating_itemid='".$itemId."' order by item_rating_id desc " ;
	$newitem = $pdo->prepare($sql);
	$newitem->execute(); 
	$items = $newitem->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($items as $row) {
		$totalRows = _e($row['number_rows']);
	}
	$reviewlimit = 4 ;
	$query = "SELECT * FROM item_rating WHERE item_rating_itemid='".$itemId."' order by item_rating_id desc  limit ".$reviewlimit."";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '<div class="row p-3 text-muted">';
	foreach($result as $row)
	{
		$ratingId = _e($row['item_rating_id']) ;
		$output .= '<div class="col-lg-12">
						'._e($row['item_star']).' <i class="fa fa-star text-warning"></i>&ensp;by&ensp;'.get_userfullname_byid($pdo,$row['item_u_id']).'
						</div>
						<div class="col-lg-12 border-bottom mt-2">
							<h6>'._e($row['item_rating_description']).'</h6>
						</div>'
		;
	}
	if($totalRows > $reviewlimit){
		$output .= '<div class="col-lg-12 justify-content-center">
					<div class="show_more_new_rating" id="show_more_new_rating'.$itemId.'">
							
							<div class="col text-center p-2">
							<div id="loader-icon"><img src="'.ADMIN_URL.'images/loader.gif" class="img-fluid img-loader" /></div>
							<button id="'.$itemId.'" class="show_more_newest_rating btn btn-info btn-sm ann'.$ratingId.'" >Load More</button>
							</div>
							
					</div>
					</div>
					';
		}
	$output .= '</div>';
	return ($output);
}
function get_item_rating_data_byuser_onload($pdo,$itemId,$ratingId){
	$sql = "SELECT count(*) as number_rows FROM item_rating WHERE item_rating_itemid='".$itemId."'  and item_rating_id < ".$_GET['ratingId']." order by item_rating_id desc " ;
	$newitem = $pdo->prepare($sql);
	$newitem->execute(); 
	$items = $newitem->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($items as $row) {
		$totalRows = _e($row['number_rows']);
	}
	$reviewlimit = 4 ;
	$query = "SELECT * FROM item_rating WHERE item_rating_itemid='".$itemId."' and item_rating_id < ".$_GET['ratingId']." order by item_rating_id desc  limit ".$reviewlimit."";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '<div class="row p-3 text-muted">';
	foreach($result as $row)
	{
		$ratingId = _e($row['item_rating_id']) ;
		$output .= '<div class="col-lg-12">
						'._e($row['item_star']).' <i class="fa fa-star text-warning"></i>&ensp;by&ensp;'.get_userfullname_byid($pdo,$row['item_u_id']).'
						</div>
						<div class="col-lg-12 border-bottom mt-2">
							<h6>'._e($row['item_rating_description']).'</h6>
						</div>'
		;
	}
	if($totalRows > $reviewlimit){
		$output .= '<div class="col-lg-12 justify-content-center">
					<div class="show_more_new_rating" id="show_more_new_rating'.$itemId.'">
							
							<div class="col text-center p-2">
							<div id="loader-icon"><img src="'.ADMIN_URL.'images/loader.gif" class="img-fluid img-loader" /></div>
							<button id="'.$itemId.'" class="show_more_newest_rating btn btn-info btn-sm ann'.$ratingId.'" >Load More</button>
							</div>
							
					</div>
					</div>
					';
		}
	$output .= '</div>';
	return ($output);
}
function get_item_youtube_video($pdo,$itemId){
	$query = "SELECT * FROM item_db WHERE item_status = '1' and item_youtube_id != '' and item_Id='".$itemId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$yid = _e($row['item_youtube_id']) ;
		$output .= '<button type="button" name="viewVideo" id="'.$yid.'" class="btn btn-danger btn-sm viewVideo"><i class="fa fa-video text-white fa-2x "></i> Video</button>';
	}
	return ($output);
}
function item_preview($pdo,$itemId){
	$query = "SELECT * FROM item_db WHERE item_status = '1' and item_demo_link != '' and item_Id='".$itemId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<a href="'.BASE_URL.'itempreview/'.$itemId.'" class="btn btn-info btn-sm">Live Preview</a>';
	}
	return ($output);
}
function item_demo_link($pdo,$itemId){
	$query = "SELECT * FROM item_db WHERE item_status = '1' and item_demo_link != '' and item_Id='".$itemId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= _e($row['item_demo_link']);
	}
	return ($output);
}
function get_item_tags($pdo,$itemId){
	$query = "SELECT * FROM item_db WHERE item_status = '1' and item_Id='".$itemId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= _e(strtoupper($row['item_tags']));
	}
	return ($output);
}
function get_item_sale($pdo,$itemId){
	$query = "SELECT * FROM item_db WHERE item_status = '1' and item_Id='".$itemId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= _e($row['item_sale']);
	}
	return ($output);
}
function get_item_ratedby($pdo,$itemId){
	$query = "SELECT * FROM item_db WHERE item_Id='".$itemId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= _e($row['item_rated_by']);
	}
	return ($output);
}
function get_item_rating($pdo,$itemId){
	$query = "SELECT * FROM item_db WHERE item_status = '1' and item_Id='".$itemId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		if($row['item_rating'] > 0){
		$output .='<i class="fa fa-star text-warning"></i> '._e($row['item_rating']);
		}
	}
	return ($output);
}
function check_item_rating_byuser($pdo,$itemId,$userId){
	$query = "SELECT * FROM item_rating WHERE item_u_id = '".$userId."' and item_rating_itemid='".$itemId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	return _e($total) ;
}
function get_item_rating_byuser($pdo,$itemId,$userId){
	$query = "SELECT * FROM item_rating WHERE item_u_id = '".$userId."' and item_rating_itemid='".$itemId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<i class="fa fa-star text-warning"></i> '._e($row['item_star']);
	}
	return ($output);
}
function get_item_ratingcomment_byuser($pdo,$itemId,$userId){
	$query = "SELECT * FROM item_rating WHERE item_u_id = '".$userId."' and item_rating_itemid='".$itemId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= _e($row['item_rating_description']);
	}
	return ($output);
}
function get_item_mainfile_name($pdo,$itemId){
	$query = "SELECT * FROM item_db WHERE item_status = '1' and item_Id='".$itemId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	$total = $statement->rowCount();
	if($total > 0) {
		foreach($result as $row)
		{
			$output .= _e($row['item_mainfile']);
		}
	}
	return ($output);
}
function get_item_small_thumbnail($pdo,$itemId){
	$query = "SELECT * FROM item_db WHERE item_Id='".$itemId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<a href="'.ADMIN_URL.'_item_secure_/'.$itemId.'/'._e($row['item_thumbnail']).'" class="spotlight"><img src='.ADMIN_URL.'_item_secure_/'.$itemId.'/'._e($row['item_thumbnail']).' class="img-fluid myThumbnailImage border border-light rounded shadow-lg" /></a>';
	}
	return ($output);
}
function check_user_status($pdo){
	$query = "SELECT * FROM ot_user WHERE user_blocked = '0' and user_id='".$_SESSION['user']['user_id']."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	return _e($total) ;
}
function check_user_chance($pdo){
	$query = "SELECT * FROM ot_user WHERE user_blocked = '0' and user_status ='0' and user_id='".$_SESSION['user']['user_id']."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	$output = '';
	if($total > 0) {
		foreach($result as $row){
			$output .= _e($row['u_chance']) ;
		}
	}
	return _e($output) ;
}
function check_user_registration_status($pdo){
	$query = "SELECT * FROM ot_user WHERE user_status = '1' and user_id='".$_SESSION['user']['user_id']."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
}
function get_userfullname($pdo){
	$query = "SELECT * FROM ot_user WHERE user_id='".$_SESSION['user']['user_id']."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	if($total > 0) {
	$output = '';
	foreach($result as $row)
		{
			$output = _e($row['user_name']) ; 
		}
	}
	return _e($output) ;
}
function get_useremail($pdo){
	$query = "SELECT * FROM ot_user WHERE user_id='".$_SESSION['user']['user_id']."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	if($total > 0) {
	$output = '';
	foreach($result as $row)
		{
			$output = _e($row['user_email']) ; 
		}
	}
	return _e($output) ;
}
function check_screenshot_foruser($pdo,$itemId){
	$query = "SELECT * FROM item_db WHERE item_docufile != '' and item_status = '1' and item_Id='".$itemId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
}
function check_item_foruser($pdo,$itemId){
	$query = "SELECT * FROM item_db WHERE item_status = '1' and item_Id='".$itemId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
}
function get_item_previewImage($pdo,$itemId){
	$query = "SELECT * FROM item_db WHERE item_status = '1' and item_Id='".$itemId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<a href="'.ADMIN_URL.'_item_secure_/'.$itemId.'/'._e($row['item_preview']).'" class="spotlight"><img src='.ADMIN_URL.'_item_secure_/'.$itemId.'/'._e($row['item_preview']).' class="img-fluid myPreviewImage border border-light rounded shadow-lg" /></a>';
	}
	return ($output);
}
function get_item_previewImage_formetatags($pdo,$itemId){
	$query = "SELECT * FROM item_db WHERE item_status = '1' and item_Id='".$itemId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= ADMIN_URL.'_item_secure_/'.$itemId.'/'._e($row['item_preview']) ;
	}
	return ($output);
}
function get_item_description($pdo,$itemId){
	$query = "SELECT * FROM item_db WHERE item_status = '1' and item_Id='".$itemId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= base64_decode(_e($row['item_description']));
	}
	return ($output);
}
function get_item_title($pdo,$itemId){
	$query = "SELECT * FROM item_db WHERE item_Id='".$itemId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= strip_tags($row['item_name']);
	}
	return ($output);
}
function get_item_price($pdo,$itemId){
	$query = "SELECT * FROM item_db WHERE item_status = '1' and item_Id='".$itemId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= _e($row['regular_price']);
	}
	return ($output);
}
function get_item_extended_price($pdo,$itemId){
	$query = "SELECT * FROM item_db WHERE item_status = '1' and item_Id='".$itemId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= _e($row['extended_price']);
	}
	return ($output);
}
function check_category_foruser($pdo,$catId){
	$query = "SELECT * FROM item_category WHERE c_status = '1' and c_id='".$catId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
}
function check_subcategory_foruser($pdo,$subcatId){
	$query = "SELECT * FROM item_subcategory WHERE s_status = '1' and s_id='".$subcatId."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
}
function fetch_active_category_foruser($pdo){
	$query = "SELECT * FROM item_category WHERE c_status = '1' order by c_name ASC";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<a class="treeview-item" href="'.BASE_URL.'category/'._e($row["c_id"]).'"><i class="icon fa fa-caret-right"></i> '._e($row["c_name"]).'</a></li>';
	}
	return ($output);
}
function fetch_active_subcategory_foruser($pdo,$catId){
	$query = "SELECT * FROM item_subcategory WHERE s_status = '1' and s_c_id='".$catId."' order by s_name ASC";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<a class="treeview-item" href="'.BASE_URL.'subcategory/'._e($row["s_id"]).'"><i class="icon fa fa-caret-right"></i> '._e($row["s_name"]).'</a></li>';
	}
	return ($output);
}
function fetch_newproduct_foruser($pdo){
	$limit = "4";
	
	$query = "SELECT * FROM item_db WHERE item_status = '1' order by item_Id DESC LIMIT ".$limit."";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$strLength = strip_tags($row['item_name']);
		if(strlen($strLength) > 20) {
			$dot = "...";
		} else {
			$dot = "";
		}
		$subCatName = get_subcategory_name_foritem($pdo,_e($row['item_Id'])) ;
		$rating = _e($row['item_rating']);
		$star = "";
		if($rating != '0.00'){
			
			$star = '<img src="'.ADMIN_URL.'images/fillStar.png"  class="img-star" alt="Rating">('._e($row['item_rating']).')';
		}
		$output .= '<div class="col-lg-3 p-1 myLink">
						<a href="'.BASE_URL.'item/'._e($row['item_Id']).'">
							<div class="card card-custom bg-white border-white">
								<div class="card-custom-img img-fluid">
									<img src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_preview']).'"  class="myImage" alt="Preview Image">
								</div>
								<div class="card-custom-avatar">
									<img class="img-fluid" src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_thumbnail']).'" alt="Thumbnail Image" />
								</div>
								<div class="card-body cardBody">
    								<h5 class="text-muted">'.strip_tags(substr_replace($row['item_name'], $dot, 20)).'</h5>
									<hr>
									<div class="row">
										<div class="col-lg-12">
											<span class="text-left">
											'.$subCatName.'
											</span><span class="spanRight">'.$star.'&ensp;<button class="btn btn-light btn-sm mt-n1">$ '.$row['regular_price'].'</button></span>
										</div>
									</div>
 								</div>
							</div>
						</a>
						</div>
		';
	}
	return ($output);
}
function fetch_newallproduct_foruser($pdo){
	$limit = "8";
	$sql = "SELECT count(*) as number_rows FROM item_db WHERE item_status='1' order by item_Id desc " ;
	$newitem = $pdo->prepare($sql);
	$newitem->execute(); 
	$items = $newitem->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($items as $row) {
		$totalRows = _e($row['number_rows']);
	}
	$query = "SELECT * FROM item_db WHERE item_status = '1' order by item_Id DESC LIMIT ".$limit."";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	$output .='<div class="row">';
	foreach($result as $row)
	{
		$item_id = _e($row['item_Id']);
		$strLength = strip_tags($row['item_name']);
		if(strlen($strLength) > 20) {
			$dot = "...";
		} else {
			$dot = "";
		}
		$subCatName = get_subcategory_name_foritem($pdo,_e($row['item_Id'])) ;
		$rating = _e($row['item_rating']);
		$star = "";
		if($rating != '0.00'){
			
			$star = '<img src="'.ADMIN_URL.'images/fillStar.png"  class="img-star" alt="Rating">('._e($row['item_rating']).')';
		}
		$output .= '<div class="col-lg-3 p-1 myLink">
						<a href="'.BASE_URL.'item/'._e($row['item_Id']).'">
							<div class="card card-custom bg-white border-white">
								<div class="card-custom-img img-fluid">
									<img src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_preview']).'"  class="myImage" alt="Preview Image">
								</div>
								<div class="card-custom-avatar">
									<img class="img-fluid" src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_thumbnail']).'" alt="Thumbnail Image" />
								</div>
								<div class="card-body cardBody">
    								<h5 class="text-muted">'.strip_tags(substr_replace($row['item_name'], $dot, 20)).'</h5>
									<hr>
									<div class="row">
										<div class="col-lg-12">
											<span class="text-left">
											'.$subCatName.'
											</span><span class="spanRight">'.$star.'&ensp;<button class="btn btn-light btn-sm mt-n1">$ '.$row['regular_price'].'</button></span>
										</div>
									</div>
 								</div>
							</div>
						</a>
					</div>
					
		';
	}
	if(empty($item_id)){
			$item_id = "";
		}
	if($totalRows > $limit){
		$output .= '<div class="col-lg-12 justify-content-center">
					<div class="show_more_new_item" id="show_more_new_item'.$item_id.'">
							
							<div class="col text-center p-2">
							<div id="loader-icon"><img src="'.ADMIN_URL.'images/loader.gif" class="img-fluid img-loader" /></div>
							<button id="'.$item_id.'" class="show_more_newest_item btn btn-light btn-sm" >Load More</button>
							</div>
							
					</div>
					</div>
					';
		}
		$output .='</div>';
	return ($output);
}
function fetch_newallproduct_load_foruser($pdo){
	$limit = "8";
	$sql = "SELECT count(*) as number_rows FROM item_db WHERE item_status='1' and item_Id < ".$_GET['id']." order by item_Id desc " ;
	$newitem = $pdo->prepare($sql);
	$newitem->execute(); 
	$items = $newitem->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($items as $row) {
		$totalRows = _e($row['number_rows']);
	}
	$query = "SELECT * FROM item_db WHERE item_status = '1' and item_Id < ".$_GET['id']." order by item_Id DESC LIMIT ".$limit."";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	$output .='<div class="row  mt-2">';
	foreach($result as $row)
	{
		$item_id = _e($row['item_Id']);
		$strLength = strip_tags($row['item_name']);
		if(strlen($strLength) > 20) {
			$dot = "...";
		} else {
			$dot = "";
		}
		$subCatName = get_subcategory_name_foritem($pdo,_e($row['item_Id'])) ;
		$rating = _e($row['item_rating']);
		$star = "";
		if($rating != '0.00'){
			
			$star = '<img src="'.ADMIN_URL.'images/fillStar.png"  class="img-star" alt="Rating">('._e($row['item_rating']).')';
		}
		$output .= '<div class="col-lg-3 p-1 myLink">
						<a href="'.BASE_URL.'item/'._e($row['item_Id']).'">
							<div class="card card-custom bg-white border-white">
								<div class="card-custom-img img-fluid">
									<img src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_preview']).'"  class="myImage" alt="Preview Image">
								</div>
								<div class="card-custom-avatar">
									<img class="img-fluid" src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_thumbnail']).'" alt="Thumbnail Image" />
								</div>
								<div class="card-body cardBody">
    								<h5 class="text-muted">'.strip_tags(substr_replace($row['item_name'], $dot, 20)).'</h5>
									<hr>
									<div class="row">
										<div class="col-lg-12">
											<span class="text-left">
											'.$subCatName.'
											</span><span class="spanRight">'.$star.'&ensp;<button class="btn btn-light btn-sm mt-n1">$ '.$row['regular_price'].'</button></span>
										</div>
									</div>
 								</div>
							</div>
						</a>
					</div>
					
		';
	}
	if(empty($item_id)){
			$item_id = "";
		}
	if($totalRows > $limit){
		$output .= '<div class="col-lg-12 justify-content-center">
					<div class="show_more_new_item" id="show_more_new_item'.$item_id.'">
							
							<div class="col text-center p-2">
							<div id="loader-icon"><img src="'.ADMIN_URL.'images/loader.gif" class="img-fluid img-loader" /></div>
							<button id="'.$item_id.'" class="show_more_newest_item btn btn-light btn-sm" >Load More</button>
							</div>
							
					</div>
					</div>
					';
	}
	$output .='</div>';
	return ($output);
}
function fetch_product_by_category_foruser($pdo,$category_id){
	$limit = "8";
	$sql = "SELECT count(*) as number_rows FROM item_db WHERE item_status='1'  and main_category = '".$category_id."'" ;
	$newitem = $pdo->prepare($sql);
	$newitem->execute(); 
	$items = $newitem->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($items as $row) {
		$totalRows = _e($row['number_rows']);
	}
	$query = "SELECT * FROM item_db WHERE item_status = '1' and main_category = '".$category_id."' order by item_Id DESC LIMIT ".$limit."";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	$output .='<div class="row">';
	foreach($result as $row)
	{
		$item_id = _e($row['item_Id']);
		
		$strLength = strip_tags($row['item_name']);
		if(strlen($strLength) > 20) {
			$dot = "...";
		} else {
			$dot = "";
		}
		$subCatName = get_subcategory_name_foritem($pdo,_e($row['item_Id'])) ;
		$rating = _e($row['item_rating']);
		$star = "";
		if($rating != '0.00'){
			
			$star = '<img src="'.ADMIN_URL.'images/fillStar.png"  class="img-star" alt="Rating">('._e($row['item_rating']).')';
		}
		$output .= '<div class="col-lg-3 p-1 myLink">
						<a href="'.BASE_URL.'item/'._e($row['item_Id']).'">
							<div class="card card-custom bg-white border-white">
								<div class="card-custom-img img-fluid">
									<img src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_preview']).'"  class="myImage" alt="Preview Image">
								</div>
								<div class="card-custom-avatar">
									<img class="img-fluid" src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_thumbnail']).'" alt="Thumbnail Image" />
								</div>
								<div class="card-body cardBody">
    								<h5 class="text-muted">'.strip_tags(substr_replace($row['item_name'], $dot, 20)).'</h5>
									<hr>
									<div class="row">
										<div class="col-lg-12">
											<span class="text-left">
											'.$subCatName.'
											</span><span class="spanRight">'.$star.'&ensp;<button class="btn btn-light btn-sm mt-n1">$ '.$row['regular_price'].'</button></span>
										</div>
									</div>
 								</div>
							</div>
						</a>
					</div>
					
		';
	}
	if(empty($item_id)){
			$item_id = "";
		}
	if($totalRows > $limit){
		$output .= '<div class="col-lg-12 justify-content-center">
					<div class="show_more_newfilter_item" id="show_more_newfilter_item'.$item_id.'">
							
							<div class="col text-center p-2">
							<div id="loader-icon"><img src="'.ADMIN_URL.'images/loader.gif" class="img-fluid img-loader" /></div>
							<button id="'.$item_id.'" class="show_more_newestfilter_item btn btn-light btn-sm ann'.$category_id.'" >Load More</button>
							</div>
							
					</div>
					</div>
					';
	}
		$output .='</div>';
	return ($output);
}
function fetch_product_by_category_onload_foruser($pdo,$item_id,$category_id){
	$limit = "8";
	$sql = "SELECT count(*) as number_rows FROM item_db WHERE item_status='1' and main_category = '".$category_id."' and item_Id < ".$_GET['ID']." order by item_Id desc " ;
	$newitem = $pdo->prepare($sql);
	$newitem->execute(); 
	$items = $newitem->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($items as $row) {
		$totalRows = _e($row['number_rows']);
	}
	$query = "SELECT * FROM item_db WHERE item_status = '1' and main_category = '".$category_id."' and item_Id < ".$_GET['ID']." order by item_Id DESC LIMIT ".$limit."";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	$output .='<div class="row mt-2">';
	foreach($result as $row)
	{
		$item_id = _e($row['item_Id']);
		$strLength = strip_tags($row['item_name']);
		if(strlen($strLength) > 20) {
			$dot = "...";
		} else {
			$dot = "";
		}
		$subCatName = get_subcategory_name_foritem($pdo,_e($row['item_Id'])) ;
		$rating = _e($row['item_rating']);
		$star = "";
		if($rating != '0.00'){
			
			$star = '<img src="'.ADMIN_URL.'images/fillStar.png"  class="img-star" alt="Rating">('._e($row['item_rating']).')';
		}
		$output .= '<div class="col-lg-3 p-1 myLink">
						<a href="'.BASE_URL.'item/'._e($row['item_Id']).'">
							<div class="card card-custom bg-white border-white">
								<div class="card-custom-img img-fluid">
									<img src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_preview']).'"  class="myImage" alt="Preview Image">
								</div>
								<div class="card-custom-avatar">
									<img class="img-fluid" src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_thumbnail']).'" alt="Thumbnail Image" />
								</div>
								<div class="card-body cardBody">
    								<h5 class="text-muted">'.strip_tags(substr_replace($row['item_name'], $dot, 20)).'</h5>
									<hr>
									<div class="row">
										<div class="col-lg-12">
											<span class="text-left">
											'.$subCatName.'
											</span><span class="spanRight">'.$star.'&ensp;<button class="btn btn-light btn-sm mt-n1">$ '.$row['regular_price'].'</button></span>
										</div>
									</div>
 								</div>
							</div>
						</a>
					</div>
					
		';
	}
	if(empty($item_id)){
			$item_id = "";
		}
	if($totalRows > $limit){
		$output .= '<div class="col-lg-12 justify-content-center">
					<div class="show_more_newfilter_item" id="show_more_newfilter_item'.$item_id.'">
							
							<div class="col text-center p-2">
							<div id="loader-icon"><img src="'.ADMIN_URL.'images/loader.gif" class="img-fluid img-loader" /></div>
							<button id="'.$item_id.'" class="show_more_newestfilter_item btn btn-light btn-sm ann'.$category_id.'" >Load More</button>
							</div>
							
					</div>
					</div>
					';
	}
	$output .='</div>';
	return ($output);
}
function fetch_product_by_subcategory_foruser($pdo,$subcategory_id){
	$limit = "8";
	$sql = "SELECT count(*) as number_rows FROM item_db WHERE item_status='1'  and sub_category = '".$subcategory_id."'" ;
	$newitem = $pdo->prepare($sql);
	$newitem->execute(); 
	$items = $newitem->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($items as $row) {
		$totalRows = _e($row['number_rows']);
	}
	$query = "SELECT * FROM item_db WHERE item_status = '1' and sub_category = '".$subcategory_id."' order by item_Id DESC LIMIT ".$limit."";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	$output .='<div class="row">';
	foreach($result as $row)
	{
		$item_id = _e($row['item_Id']);
		
		$strLength = strip_tags($row['item_name']);
		if(strlen($strLength) > 20) {
			$dot = "...";
		} else {
			$dot = "";
		}
		$subCatName = get_subcategory_name_foritem($pdo,_e($row['item_Id'])) ;
		$rating = _e($row['item_rating']);
		$star = "";
		if($rating != '0.00'){
			
			$star = '<img src="'.ADMIN_URL.'images/fillStar.png"  class="img-star" alt="Rating">('._e($row['item_rating']).')';
		}
		$output .= '<div class="col-lg-3 p-1 myLink">
						<a href="'.BASE_URL.'item/'._e($row['item_Id']).'">
							<div class="card card-custom bg-white border-white">
								<div class="card-custom-img img-fluid">
									<img src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_preview']).'"  class="myImage" alt="Preview Image">
								</div>
								<div class="card-custom-avatar">
									<img class="img-fluid" src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_thumbnail']).'" alt="Thumbnail Image" />
								</div>
								<div class="card-body cardBody">
    								<h5 class="text-muted">'.strip_tags(substr_replace($row['item_name'], $dot, 20)).'</h5>
									<hr>
									<div class="row">
										<div class="col-lg-12">
											<span class="text-left">
											'.$subCatName.'
											</span><span class="spanRight">'.$star.'&ensp;<button class="btn btn-light btn-sm mt-n1">$ '.$row['regular_price'].'</button></span>
										</div>
									</div>
 								</div>
							</div>
						</a>
					</div>
					
		';
	}
	if(empty($item_id)){
			$item_id = "";
		}
	if($totalRows > $limit){
		$output .= '<div class="col-lg-12 justify-content-center">
					<div class="show_more_subcat_item" id="show_more_subcat_item'.$item_id.'">
							
							<div class="col text-center p-2">
							<div id="loader-icon"><img src="'.ADMIN_URL.'images/loader.gif" class="img-fluid img-loader" /></div>
							<button id="'.$item_id.'" class="show_more_subcatfilter_item btn btn-light btn-sm ann'.$subcategory_id.'" >Load More</button>
							</div>
							
					</div>
					</div>
					';
	}
		$output .='</div>';
	return ($output);
}
function fetch_product_by_subcategory_onload_foruser($pdo,$item_id,$subcategory_id){
	$limit = "8";
	$sql = "SELECT count(*) as number_rows FROM item_db WHERE item_status='1' and sub_category = '".$subcategory_id."' and item_Id < ".$_GET['ID']." order by item_Id desc " ;
	$newitem = $pdo->prepare($sql);
	$newitem->execute(); 
	$items = $newitem->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($items as $row) {
		$totalRows = _e($row['number_rows']);
	}
	$query = "SELECT * FROM item_db WHERE item_status = '1' and sub_category = '".$subcategory_id."' and item_Id < ".$_GET['ID']." order by item_Id DESC LIMIT ".$limit."";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	$output .='<div class="row mt-2">';
	foreach($result as $row)
	{
		$item_id = _e($row['item_Id']);
		$strLength = strip_tags($row['item_name']);
		if(strlen($strLength) > 20) {
			$dot = "...";
		} else {
			$dot = "";
		}
		$subCatName = get_subcategory_name_foritem($pdo,_e($row['item_Id'])) ;
		$rating = _e($row['item_rating']);
		$star = "";
		if($rating != '0.00'){
			
			$star = '<img src="'.ADMIN_URL.'images/fillStar.png"  class="img-star" alt="Rating">('._e($row['item_rating']).')';
		}
		$output .= '<div class="col-lg-3 p-1 myLink">
						<a href="'.BASE_URL.'item/'._e($row['item_Id']).'">
							<div class="card card-custom bg-white border-white">
								<div class="card-custom-img img-fluid">
									<img src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_preview']).'"  class="myImage" alt="Preview Image">
								</div>
								<div class="card-custom-avatar">
									<img class="img-fluid" src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_thumbnail']).'" alt="Thumbnail Image" />
								</div>
								<div class="card-body cardBody">
    								<h5 class="text-muted">'.strip_tags(substr_replace($row['item_name'], $dot, 20)).'</h5>
									<hr>
									<div class="row">
										<div class="col-lg-12">
											<span class="text-left">
											'.$subCatName.'
											</span><span class="spanRight">'.$star.'&ensp;<button class="btn btn-light btn-sm mt-n1">$ '.$row['regular_price'].'</button></span>
										</div>
									</div>
 								</div>
							</div>
						</a>
					</div>
					
		';
	}
	if(empty($item_id)){
			$item_id = "";
		}
	if($totalRows > $limit){
		$output .= '<div class="col-lg-12 justify-content-center">
					<div class="show_more_subcat_item" id="show_more_subcat_item'.$item_id.'">
							
							<div class="col text-center p-2">
							<div id="loader-icon"><img src="'.ADMIN_URL.'images/loader.gif" class="img-fluid img-loader" /></div>
							<button id="'.$item_id.'" class="show_more_subcatfilter_item btn btn-light btn-sm ann'.$subcategory_id.'" >Load More</button>
							</div>
							
					</div>
					</div>
					';
	}
	$output .='</div>';
	return ($output);
}
function fetch_product_by_childcategory_foruser($pdo,$childcategory_id){
	$limit = "8";
	$sql = "SELECT count(*) as number_rows FROM item_db WHERE item_status='1'  and child_category = '".$childcategory_id."'" ;
	$newitem = $pdo->prepare($sql);
	$newitem->execute(); 
	$items = $newitem->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($items as $row) {
		$totalRows = _e($row['number_rows']);
	}
	$query = "SELECT * FROM item_db WHERE item_status = '1' and child_category = '".$childcategory_id."' order by item_Id DESC LIMIT ".$limit."";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	$output .='<div class="row">';
	foreach($result as $row)
	{
		$item_id = _e($row['item_Id']);
		
		$strLength = strip_tags($row['item_name']);
		if(strlen($strLength) > 20) {
			$dot = "...";
		} else {
			$dot = "";
		}
		$subCatName = get_subcategory_name_foritem($pdo,_e($row['item_Id'])) ;
		$rating = _e($row['item_rating']);
		$star = "";
		if($rating != '0.00'){
			
			$star = '<img src="'.ADMIN_URL.'images/fillStar.png"  class="img-star" alt="Rating">('._e($row['item_rating']).')';
		}
		$output .= '<div class="col-lg-3 p-1 myLink">
						<a href="'.BASE_URL.'item/'._e($row['item_Id']).'">
							<div class="card card-custom bg-white border-white">
								<div class="card-custom-img img-fluid">
									<img src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_preview']).'"  class="myImage" alt="Preview Image">
								</div>
								<div class="card-custom-avatar">
									<img class="img-fluid" src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_thumbnail']).'" alt="Thumbnail Image" />
								</div>
								<div class="card-body cardBody">
    								<h5 class="text-muted">'.strip_tags(substr_replace($row['item_name'], $dot, 20)).'</h5>
									<hr>
									<div class="row">
										<div class="col-lg-12">
											<span class="text-left">
											'.$subCatName.'
											</span><span class="spanRight">'.$star.'&ensp;<button class="btn btn-light btn-sm mt-n1">$ '.$row['regular_price'].'</button></span>
										</div>
									</div>
 								</div>
							</div>
						</a>
					</div>
					
		';
	}
	if(empty($item_id)){
			$item_id = "";
		}
	if($totalRows > $limit){
		$output .= '<div class="col-lg-12 justify-content-center">
					<div class="show_more_childcat_item" id="show_more_childcat_item'.$item_id.'">
							
							<div class="col text-center p-2">
							<div id="loader-icon"><img src="'.ADMIN_URL.'images/loader.gif" class="img-fluid img-loader" /></div>
							<button id="'.$item_id.'" class="show_more_childcatfilter_item btn btn-light btn-sm ann'.$childcategory_id.'" >Load More</button>
							</div>
							
					</div>
					</div>
					';
	}
		$output .='</div>';
	return ($output);
}
function fetch_product_by_childcategory_onload_foruser($pdo,$item_id,$childcategory_id){
	$limit = "8";
	$sql = "SELECT count(*) as number_rows FROM item_db WHERE item_status='1' and child_category = '".$childcategory_id."' and item_Id < ".$_GET['ID']." order by item_Id desc " ;
	$newitem = $pdo->prepare($sql);
	$newitem->execute(); 
	$items = $newitem->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($items as $row) {
		$totalRows = _e($row['number_rows']);
	}
	$query = "SELECT * FROM item_db WHERE item_status = '1' and child_category = '".$childcategory_id."' and item_Id < ".$_GET['ID']." order by item_Id DESC LIMIT ".$limit."";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	$output .='<div class="row mt-2">';
	foreach($result as $row)
	{
		$item_id = _e($row['item_Id']);
		$strLength = strip_tags($row['item_name']);
		if(strlen($strLength) > 20) {
			$dot = "...";
		} else {
			$dot = "";
		}
		$subCatName = get_subcategory_name_foritem($pdo,_e($row['item_Id'])) ;
		$rating = _e($row['item_rating']);
		$star = "";
		if($rating != '0.00'){
			
			$star = '<img src="'.ADMIN_URL.'images/fillStar.png"  class="img-star" alt="Rating">('._e($row['item_rating']).')';
		}
		$output .= '<div class="col-lg-3 p-1 myLink">
						<a href="'.BASE_URL.'item/'._e($row['item_Id']).'">
							<div class="card card-custom bg-white border-white">
								<div class="card-custom-img img-fluid">
									<img src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_preview']).'"  class="myImage" alt="Preview Image">
								</div>
								<div class="card-custom-avatar">
									<img class="img-fluid" src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_thumbnail']).'" alt="Thumbnail Image" />
								</div>
								<div class="card-body cardBody">
    								<h5 class="text-muted">'.strip_tags(substr_replace($row['item_name'], $dot, 20)).'</h5>
									<hr>
									<div class="row">
										<div class="col-lg-12">
											<span class="text-left">
											'.$subCatName.'
											</span><span class="spanRight">'.$star.'&ensp;<button class="btn btn-light btn-sm mt-n1">$ '.$row['regular_price'].'</button></span>
										</div>
									</div>
 								</div>
							</div>
						</a>
					</div>
					
		';
	}
	if(empty($item_id)){
			$item_id = "";
		}
	if($totalRows > $limit){
		$output .= '<div class="col-lg-12 justify-content-center">
					<div class="show_more_childcat_item" id="show_more_childcat_item'.$item_id.'">
							
							<div class="col text-center p-2">
							<div id="loader-icon"><img src="'.ADMIN_URL.'images/loader.gif" class="img-fluid img-loader" /></div>
							<button id="'.$item_id.'" class="show_more_childcatfilter_item btn btn-light btn-sm ann'.$childcategory_id.'" >Load More</button>
							</div>
							
					</div>
					</div>
					';
	}
	$output .='</div>';
	return ($output);
}
function fetch_featuredproduct_foruser($pdo){
	$limit = "4";
	
	$query = "SELECT * FROM item_db WHERE item_status = '1'  and item_featured='1' order by item_Id DESC LIMIT ".$limit."";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$strLength = strip_tags($row['item_name']);
		if(strlen($strLength) > 20) {
			$dot = "...";
		} else {
			$dot = "";
		}
		$subCatName = get_subcategory_name_foritem($pdo,_e($row['item_Id'])) ;
		$rating = _e($row['item_rating']);
		$star = "";
		if($rating != '0.00'){
			
			$star = '<img src="'.ADMIN_URL.'images/fillStar.png"  class="img-star" alt="Rating">('._e($row['item_rating']).')';
		}
		$output .= '<div class="col-lg-3 p-1 myLink">
						<a href="'.BASE_URL.'item/'._e($row['item_Id']).'">
							<div class="card card-custom bg-white border-white">
								<div class="card-custom-img img-fluid">
									<img src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_preview']).'"  class="myImage" alt="Preview Image">
								</div>
								<div class="card-custom-avatar">
									<img class="img-fluid" src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_thumbnail']).'" alt="Thumbnail Image" />
								</div>
								<div class="card-body cardBody">
    								<h5 class="text-muted">'.strip_tags(substr_replace($row['item_name'], $dot, 20)).'</h5>
									<hr>
									<div class="row">
										<div class="col-lg-12">
											<span class="text-left">
											'.$subCatName.'
											</span><span class="spanRight">'.$star.'&ensp;<button class="btn btn-light btn-sm mt-n1">$ '.$row['regular_price'].'</button></span>
										</div>
									</div>
 								</div>
							</div>
						</a>
						</div>
		';
	}
	return ($output);
}
function fetch_featuredallproduct_foruser($pdo){
	$limit = "8";
	$sql = "SELECT count(*) as number_rows FROM item_db WHERE item_status='1' and item_featured='1' order by item_Id desc " ;
	$newitem = $pdo->prepare($sql);
	$newitem->execute(); 
	$items = $newitem->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($items as $row) {
		$totalRows = _e($row['number_rows']);
	}
	$query = "SELECT * FROM item_db WHERE item_status = '1' and item_featured='1'  order by item_Id DESC LIMIT ".$limit."";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	$output .='<div class="row">';
	foreach($result as $row)
	{
		$item_id = _e($row['item_Id']);
		$strLength = strip_tags($row['item_name']);
		if(strlen($strLength) > 20) {
			$dot = "...";
		} else {
			$dot = "";
		}
		$subCatName = get_subcategory_name_foritem($pdo,_e($row['item_Id'])) ;
		$rating = _e($row['item_rating']);
		$star = "";
		if($rating != '0.00'){
			
			$star = '<img src="'.ADMIN_URL.'images/fillStar.png"  class="img-star" alt="Rating">('._e($row['item_rating']).')';
		}
		$output .= '<div class="col-lg-3 p-1 myLink">
						<a href="'.BASE_URL.'item/'._e($row['item_Id']).'">
							<div class="card card-custom bg-white border-white">
								<div class="card-custom-img img-fluid">
									<img src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_preview']).'"  class="myImage" alt="Preview Image">
								</div>
								<div class="card-custom-avatar">
									<img class="img-fluid" src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_thumbnail']).'" alt="Thumbnail Image" />
								</div>
								<div class="card-body cardBody">
    								<h5 class="text-muted">'.strip_tags(substr_replace($row['item_name'], $dot, 20)).'</h5>
									<hr>
									<div class="row">
										<div class="col-lg-12">
											<span class="text-left">
											'.$subCatName.'
											</span><span class="spanRight">'.$star.'&ensp;<button class="btn btn-light btn-sm mt-n1">$ '.$row['regular_price'].'</button></span>
										</div>
									</div>
 								</div>
							</div>
						</a>
					</div>
					
		';
	}
	if(empty($item_id)){
			$item_id = "";
		}
	if($totalRows > $limit){
		$output .= '<div class="col-lg-12 justify-content-center">
					<div class="show_more_featured_item" id="show_more_featured_item'.$item_id.'">
							
							<div class="col text-center p-2">
							<div id="loader-icon"><img src="'.ADMIN_URL.'images/loader.gif" class="img-fluid img-loader" /></div>
							<button id="'.$item_id.'" class="show_more_newfeatured_item btn btn-light btn-sm" >Load More</button>
							</div>
							
					</div>
					</div>
					';
		}
		$output .='</div>';
	return ($output);
}
function fetch_featuredproduct_load_foruser($pdo){
	$limit = "8";
	$sql = "SELECT count(*) as number_rows FROM item_db WHERE item_status='1' and item_featured='1' and item_Id < ".$_GET['id']." order by item_Id desc " ;
	$newitem = $pdo->prepare($sql);
	$newitem->execute(); 
	$items = $newitem->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($items as $row) {
		$totalRows = _e($row['number_rows']);
	}
	$query = "SELECT * FROM item_db WHERE item_status = '1'  and item_featured='1' and item_Id < ".$_GET['id']." order by item_Id DESC LIMIT ".$limit."";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	$output .='<div class="row  mt-2">';
	foreach($result as $row)
	{
		$item_id = _e($row['item_Id']);
		$strLength = strip_tags($row['item_name']);
		if(strlen($strLength) > 20) {
			$dot = "...";
		} else {
			$dot = "";
		}
		$subCatName = get_subcategory_name_foritem($pdo,_e($row['item_Id'])) ;
		$rating = _e($row['item_rating']);
		$star = "";
		if($rating != '0.00'){
			
			$star = '<img src="'.ADMIN_URL.'images/fillStar.png"  class="img-star" alt="Rating">('._e($row['item_rating']).')';
		}
		$output .= '<div class="col-lg-3 p-1 myLink">
						<a href="'.BASE_URL.'item/'._e($row['item_Id']).'">
							<div class="card card-custom bg-white border-white">
								<div class="card-custom-img img-fluid">
									<img src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_preview']).'"  class="myImage" alt="Preview Image">
								</div>
								<div class="card-custom-avatar">
									<img class="img-fluid" src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_thumbnail']).'" alt="Thumbnail Image" />
								</div>
								<div class="card-body cardBody">
    								<h5 class="text-muted">'.strip_tags(substr_replace($row['item_name'], $dot, 20)).'</h5>
									<hr>
									<div class="row">
										<div class="col-lg-12">
											<span class="text-left">
											'.$subCatName.'
											</span><span class="spanRight">'.$star.'&ensp;<button class="btn btn-light btn-sm mt-n1">$ '.$row['regular_price'].'</button></span>
										</div>
									</div>
 								</div>
							</div>
						</a>
					</div>
					
		';
	}
	if(empty($item_id)){
			$item_id = "";
		}
	if($totalRows > $limit){
		$output .= '<div class="col-lg-12 justify-content-center">
					<div class="show_more_featured_item" id="show_more_featured_item'.$item_id.'">
							
							<div class="col text-center p-2">
							<div id="loader-icon"><img src="'.ADMIN_URL.'images/loader.gif" class="img-fluid img-loader" /></div>
							<button id="'.$item_id.'" class="show_more_newfeatured_item btn btn-light btn-sm" >Load More</button>
							</div>
							
					</div>
					</div>
					';
	}
	$output .='</div>';
	return ($output);
}
function fetch_featuredproduct_by_category_foruser($pdo,$category_id){
	$limit = "8";
	$sql = "SELECT count(*) as number_rows FROM item_db WHERE item_status='1' and item_featured='1'  and main_category = '".$category_id."'" ;
	$newitem = $pdo->prepare($sql);
	$newitem->execute(); 
	$items = $newitem->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($items as $row) {
		$totalRows = _e($row['number_rows']);
	}
	$query = "SELECT * FROM item_db WHERE item_status = '1' and item_featured='1' and main_category = '".$category_id."' order by item_Id DESC LIMIT ".$limit."";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	$output .='<div class="row">';
	foreach($result as $row)
	{
		$item_id = _e($row['item_Id']);
		
		$strLength = strip_tags($row['item_name']);
		if(strlen($strLength) > 20) {
			$dot = "...";
		} else {
			$dot = "";
		}
		$subCatName = get_subcategory_name_foritem($pdo,_e($row['item_Id'])) ;
		$rating = _e($row['item_rating']);
		$star = "";
		if($rating != '0.00'){
			
			$star = '<img src="'.ADMIN_URL.'images/fillStar.png"  class="img-star" alt="Rating">('._e($row['item_rating']).')';
		}
		$output .= '<div class="col-lg-3 p-1 myLink">
						<a href="'.BASE_URL.'item/'._e($row['item_Id']).'">
							<div class="card card-custom bg-white border-white">
								<div class="card-custom-img img-fluid">
									<img src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_preview']).'"  class="myImage" alt="Preview Image">
								</div>
								<div class="card-custom-avatar">
									<img class="img-fluid" src="'.ADMIN_URL.'_item_secure_/'._e($row['item_Id']).'/'._e($row['item_thumbnail']).'" alt="Thumbnail Image" />
								</div>
								<div class="card-body cardBody">
    								<h5 class="text-muted">'.strip_tags(substr_replace($row['item_name'], $dot, 20)).'</h5>
									<hr>
									<div class="row">
										<div class="col-lg-12">
											<span class="text-left">
											'.$subCatName.'
											</span><span class="spanRight">'.$star.'&ensp;<button class="btn btn-light btn-sm mt-n1">$ '.$row['regular_price'].'</button></span>
										</div>
									</div>
 								</div>
							</div>
						</a>
					</div>
					
		';
	}
	if(empty($item_id)){
			$item_id = "";
		}
	if($totalRows > $limit){
		$output .= '<div class="col-lg-12 justify-content-center">
					<div class="show_more_newfilter_item" id="show_more_newfilter_item'.$item_id.'">
							
							<div class="col text-center p-2">
							<div id="loader-icon"><img src="'.ADMIN_URL.'images/loader.gif" class="img-fluid img-loader" /></div>
							<button id="'.$item_id.'" class="show_more_newestfilter_item btn btn-light btn-sm ann'.$category_id.'" >Load More</button>
							</div>
							
					</div>
					</div>
					';
	}
		$output .='</div>';
	return ($output);
}
function fetchcategory_name($pdo,$id){
	$query = "SELECT * FROM item_category WHERE c_id = '".$id."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= strip_tags($row["c_name"]) ;
	}
	return ($output);
}
function fetchsubcategory_name($pdo,$id){
	$query = "SELECT * FROM item_subcategory WHERE s_id = '".$id."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= strip_tags($row["s_name"]) ;
	}
	return ($output);
}
function fetchchildcategory_name($pdo,$id){
	$query = "SELECT * FROM item_childcategory WHERE ch_id = '".$id."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= strip_tags($row["ch_name"]) ;
	}
	return ($output);
}
function get_active_category($pdo){
	$query = "SELECT * FROM item_category WHERE c_status = '1' order by c_id desc";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value='._e($row["c_id"]).'>'._e($row["c_name"]).'</option>';
	}
	return ($output);
}
function fetch_active_category_name($pdo,$id){
	$query = "SELECT * FROM item_category WHERE c_status = '1' and c_id = '".$id."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value='._e($row["c_id"]).'>'._e($row["c_name"]).'</option>';
	}
	return ($output);
}
function fetch_active_subcategory_name($pdo,$id){
	$query = "SELECT * FROM item_subcategory WHERE s_status = '1' and s_id = '".$id."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value='._e($row["s_id"]).'>'._e($row["s_name"]).'</option>';
	}
	return ($output);
}
function fetch_active_childcategory_name($pdo,$id){
	$query = "SELECT * FROM item_childcategory WHERE ch_status = '1' and ch_id = '".$id."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value='._e($row["ch_id"]).'>'._e($row["ch_name"]).'</option>';
	}
	return ($output);
}
function get_active_category_selected($pdo,$id){
	$query = "SELECT * FROM item_category WHERE c_status = '1' and c_id != '".$id."' order by c_id desc";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value='._e($row["c_id"]).'>'._e($row["c_name"]).'</option>';
	}
	return ($output);
}
function get_active_subcategory_selected($pdo,$id,$catId){
	$query = "SELECT * FROM item_subcategory WHERE s_status = '1' and s_id != '".$id."' and s_c_id='".$catId."' order by s_id desc";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value='._e($row["s_id"]).'>'._e($row["s_name"]).'</option>';
	}
	return ($output);
}
function get_active_childcategory_selected($pdo,$id,$catId,$subcatId){
	$query = "SELECT * FROM item_childcategory WHERE ch_status = '1' and ch_id != '".$id."' and ch_c_id='".$catId."' and ch_s_id = '".$subcatId."' order by ch_id desc";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value='._e($row["ch_id"]).'>'._e($row["ch_name"]).'</option>';
	}
	return ($output);
}
function get_active_subcategory($pdo){
	$query = "SELECT * FROM item_subcategory WHERE s_status = '1' order by s_id desc";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value='._e($row["s_id"]).'>'._e($row["s_name"]).'</option>';
	}
	return ($output);
}
function get_active_childcategory($pdo){
	$query = "SELECT * FROM item_childcategory WHERE ch_status = '1' order by ch_id desc";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value='._e($row["ch_id"]).'>'._e($row["ch_name"]).'</option>';
	}
	return ($output);
}
function get_category_name($pdo,$c_id){
	$query = "SELECT * FROM item_category WHERE c_id = '".$c_id."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= _e($row["c_name"]);
	}
	return ($output);
}
function get_subcategory_name($pdo,$s_id){
	$query = "SELECT * FROM item_subcategory WHERE s_id = '".$s_id."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= _e($row["s_name"]);
	}
	return ($output);
}
function fill_subcategory_list($pdo, $category_id)
{
	$query = "SELECT * FROM item_subcategory WHERE s_status = '1' AND s_c_id = '".$category_id."' ORDER BY s_name ASC";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '<option value="">Select Sub Category</option>';
	foreach($result as $row)
	{
		$output .= '<option value="'._e($row["s_id"]).'">'._e($row["s_name"]).'</option>';
	}
	return ($output);
}
function fill_childcategory_list($pdo, $subcategory_id)
{
	$query = "SELECT * FROM item_childcategory WHERE ch_status = '1' AND ch_s_id = '".$subcategory_id."' ORDER BY ch_name ASC";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '<option value="">Select Child Category</option>';
	foreach($result as $row)
	{
		$output .= '<option value="'._e($row["ch_id"]).'">'._e($row["ch_name"]).'</option>';
	}
	return ($output);
}
function get_subcategory_name_foritem($pdo,$item_id){
	$query = "SELECT s_name FROM item_db left join item_subcategory on (item_subcategory.s_id = item_db.sub_category) WHERE item_Id = '".$item_id."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= _e($row["s_name"]);
	}
	return ($output);
}
function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($dir);
}
?>