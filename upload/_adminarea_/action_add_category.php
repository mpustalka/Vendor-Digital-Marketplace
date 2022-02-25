<?php
ob_start();
session_start();
include("db/config.php");
include("db/function_xss.php") ;
// Checking Admin is logged in or not
if(!isset($_SESSION['admin'])) {
	header("location: ".ADMIN_URL."login.php");
	exit;
}
if(isset($_POST['btn_action_cat']))
{
	if($_POST['btn_action_cat'] == 'SaveCategory')
	{
		if(!empty($_POST['cat'])){
			$categoryName = filter_var($_POST['cat'], FILTER_SANITIZE_STRING) ;
			$date = date("Y-m-d") ;
			$ins = $pdo->prepare("insert into item_category (c_name,c_date) values (?,?)") ;
			$ins->execute(array($categoryName,$date));
			echo "Category is live now.";
		} else {
			echo "Category Name should not be Empty.";
		}
	}
	if($_POST['btn_action_cat'] == 'SaveSubCategory')
	{
		if(!empty($_POST['cat']) && !empty($_POST['subcat'])){
			$categoryID = filter_var($_POST['cat'], FILTER_SANITIZE_NUMBER_INT) ;
			$subcategoryName = filter_var($_POST['subcat'], FILTER_SANITIZE_STRING) ;
			$date = date("Y-m-d") ;
			$categoryName = get_category_name($pdo,$categoryID) ;
			$ins = $pdo->prepare("insert into item_subcategory (s_c_name,s_c_id,s_name,s_date) values (?,?,?,?)") ;
			$ins->execute(array($categoryName,$categoryID,$subcategoryName,$date));
			echo "Sub Category is live now.";
		} else {
			echo "Sub Category Name should not be Empty.";
		}
	}
	if($_POST['btn_action_cat'] == 'SaveChildCategory')
	{
		if(!empty($_POST['cat']) && !empty($_POST['subcat']) && !empty($_POST['childcat']) ){
			$categoryID = filter_var($_POST['cat'], FILTER_SANITIZE_NUMBER_INT) ;
			$subcategoryID = filter_var($_POST['subcat'], FILTER_SANITIZE_NUMBER_INT) ;
			$childcategoryName = filter_var($_POST['childcat'], FILTER_SANITIZE_STRING) ;
			$date = date("Y-m-d") ;
			$categoryName = get_category_name($pdo,$categoryID) ;
			$subcategoryName = get_subcategory_name($pdo,$subcategoryID) ;
			$ins = $pdo->prepare("insert into item_childcategory (ch_c_name,ch_c_id,ch_s_name,ch_s_id,ch_name,ch_date) values (?,?,?,?,?,?)") ;
			$ins->execute(array($categoryName,$categoryID,$subcategoryName,$subcategoryID,$childcategoryName,$date));
			echo "Child Category is live now.";
		} else {
			echo "Child Category Name should not be Empty.";
		}
	}
	
	if($_POST['btn_action_cat'] == 'changeCatStatusToDeactive')
	{
		if(!empty($_POST['catId']) ){
			$status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT) ;
			$categoryId = filter_var($_POST['catId'], FILTER_SANITIZE_NUMBER_INT) ;
			
			$ins = $pdo->prepare("update item_category set c_status = '0' where c_id = '".$categoryId."'") ;
			$ins->execute();
			set_subcategory_to_deactive($pdo,$categoryId) ;
			set_childcategory_to_deactive($pdo,$categoryId) ;
			set_item_to_deactive($pdo,$categoryId) ;
			echo "Category is deactivated & All the Items, Subcategory & Child category belongs to this Category is also Deactivated.";
		} else {
			echo "Category ID should not be Empty.";
		}
	}
	if($_POST['btn_action_cat'] == 'changeCatStatusToActive')
	{
		if(!empty($_POST['catId']) ){
			$status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT) ;
			$categoryId = filter_var($_POST['catId'], FILTER_SANITIZE_NUMBER_INT) ;
			
			$ins = $pdo->prepare("update item_category set c_status = '1' where c_id = '".$categoryId."'") ;
			$ins->execute();
			set_subcategory_to_active($pdo,$categoryId) ;
			set_childcategory_to_active($pdo,$categoryId) ;
			set_item_to_active($pdo,$categoryId) ;
			echo "Category is activated & All the Items, Subcategory & Child category belongs to this Category is Activated & Live Now.";
		} else {
			echo "Category ID should not be Empty.";
		}
	}
	
	if($_POST['btn_action_cat'] == 'changeSubCatStatusToDeactive')
	{
		if(!empty($_POST['subcatId']) ){
			$status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT) ;
			$subcategoryId = filter_var($_POST['subcatId'], FILTER_SANITIZE_NUMBER_INT) ;
			
			$ins = $pdo->prepare("update item_subcategory set s_status = '0' where s_id = '".$subcategoryId."'") ;
			$ins->execute();
			set_childcategory_to_deactive_viasubcategory($pdo,$subcategoryId) ;
			set_item_to_deactive_viasubcategory($pdo,$subcategoryId) ;
			echo "Sub Category is deactivated & All the Items & Child category belongs to this Sub Category is also Deactivated.";
		} else {
			echo "Sub Category ID should not be Empty.";
		}
	}
	if($_POST['btn_action_cat'] == 'changeSubCatStatusToActive')
	{
		if(!empty($_POST['subcatId']) ){
			$status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT) ;
			$subcategoryId = filter_var($_POST['subcatId'], FILTER_SANITIZE_NUMBER_INT) ;
			
			$ins = $pdo->prepare("update item_subcategory set s_status = '1' where s_id = '".$subcategoryId."'") ;
			$ins->execute();
			set_childcategory_to_active_viasubcategory($pdo,$subcategoryId) ;
			set_item_to_active_viasubcategory($pdo,$subcategoryId) ;
			echo "Sub Category is activated & All the Items & Child category belongs to this Sub Category is Activated & Live Now.";
		} else {
			echo "Sub Category ID should not be Empty.";
		}
	}
	
	if($_POST['btn_action_cat'] == 'changeChildCatStatusToDeactive')
	{
		if(!empty($_POST['childcatId']) ){
			$status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT) ;
			$childcategoryId = filter_var($_POST['childcatId'], FILTER_SANITIZE_NUMBER_INT) ;
			
			$ins = $pdo->prepare("update item_childcategory set ch_status = '0' where ch_id = '".$childcategoryId."'") ;
			$ins->execute();
			set_item_to_deactive_viachildcategory($pdo,$childcategoryId) ;
			echo "Child Category is deactivated & All the Items belongs to this Child Category is also Deactivated.";
		} else {
			echo "Child Category ID should not be Empty.";
		}
	}
	if($_POST['btn_action_cat'] == 'changeChildCatStatusToActive')
	{
		if(!empty($_POST['childcatId']) ){
			$status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT) ;
			$childcategoryId = filter_var($_POST['childcatId'], FILTER_SANITIZE_NUMBER_INT) ;
			
			$ins = $pdo->prepare("update item_childcategory set ch_status = '1' where ch_id = '".$childcategoryId."'") ;
			$ins->execute();
			set_item_to_active_viachildcategory($pdo,$childcategoryId) ;
			echo "Child Category is activated & All the Items belongs to this Child Category is Activated & Live Now.";
		} else {
			echo "Child Category ID should not be Empty.";
		}
	}
	
	if($_POST['btn_action_cat'] == 'fetch_category')
	{	
		if(!empty($_POST['catId'])){
			$catId = filter_var($_POST['catId'], FILTER_SANITIZE_NUMBER_INT);
			$announce = $pdo->prepare("select * from item_category where c_id = ?");
			$announce->execute(array($catId));
			$result = $announce->fetchAll(PDO::FETCH_ASSOC);
			foreach($result as $row) {
				$output['catId'] = _e($row['c_id']);
				$output['categoryName'] = strip_tags($row['c_name']);
			}
			echo json_encode($output) ;
		} else {
			echo "Error : Category Id is mandatory." ;
		}
	}
	if($_POST['btn_action_cat'] == 'EditCategory')
	{	
		if(!empty($_POST['catId']) && !empty($_POST['cat'])){
			$categoryName = filter_var($_POST['cat'], FILTER_SANITIZE_STRING) ;
			$categoryId = filter_var($_POST['catId'], FILTER_SANITIZE_NUMBER_INT);
			$upd = $pdo->prepare("update item_category set c_name = '".$categoryName."' where c_id = '".$categoryId."'") ;
			$upd->execute();
			set_categoryname_intosubcategory($pdo,$categoryId,$categoryName) ;
			set_categoryname_intochildcategory($pdo,$categoryId,$categoryName) ;
			echo "Category Name is Updated Successfully";
			
		} else {
			echo "Error : Category Id & Name is mandatory." ;
		}
	}
	if($_POST['btn_action_cat'] == 'fetch_subcategory')
	{	
		if(!empty($_POST['subcatId'])){
			$subcatId = filter_var($_POST['subcatId'], FILTER_SANITIZE_NUMBER_INT);
			$announce = $pdo->prepare("select * from item_subcategory where s_id = ?");
			$announce->execute(array($subcatId));
			$result = $announce->fetchAll(PDO::FETCH_ASSOC);
			foreach($result as $row) {
				$output['subcatId'] = _e($row['s_id']);
				$output['categoryId'] = _e($row['s_c_id']);
				$output['subcategoryName'] = strip_tags($row['s_name']);
			}
			echo json_encode($output) ;
		} else {
			echo "Error : Category Id is mandatory." ;
		}
	}
	if($_POST['btn_action_cat'] == 'EditSubCategory')
	{	
		if(!empty($_POST['subcatId']) && !empty($_POST['subcat']) && !empty($_POST['cat'])){
			$subcategoryName = filter_var($_POST['subcat'], FILTER_SANITIZE_STRING) ;
			$subcategoryId = filter_var($_POST['subcatId'], FILTER_SANITIZE_NUMBER_INT);
			$categoryId = filter_var($_POST['cat'], FILTER_SANITIZE_NUMBER_INT);
			$catName = get_category_name($pdo,$categoryId) ;
			$upd = $pdo->prepare("update item_subcategory set s_name = '".$subcategoryName."' , s_c_id = '".$categoryId."' , s_c_name = '".$catName."' where s_id = '".$subcategoryId."'") ;
			$upd->execute();
			set_subcategoryname_intochildcategory($pdo,$subcategoryId,$subcategoryName,$categoryId) ;
			echo "Sub Category is Updated Successfully";
			
		} else {
			echo "Error : Sub Category & Category Id & Sub Category Name is mandatory." ;
		}
	}
	if($_POST['btn_action_cat'] == 'fetch_childcategory')
	{	
		if(!empty($_POST['childcatId'])){
			$childcatId = filter_var($_POST['childcatId'], FILTER_SANITIZE_NUMBER_INT);
			$announce = $pdo->prepare("select * from item_childcategory where ch_id = ?");
			$announce->execute(array($childcatId));
			$result = $announce->fetchAll(PDO::FETCH_ASSOC);
			foreach($result as $row) {
				$output['childcatId'] = _e($row['ch_id']);
				$output['subcatId'] = _e($row['ch_s_id']);
				$output['categoryId'] = _e($row['ch_c_id']);
				$output['childcategoryName'] = strip_tags($row['ch_name']);
			}
			echo json_encode($output) ;
		} else {
			echo "Error : Child Category Id is mandatory." ;
		}
	}
	if($_POST['btn_action_cat'] == 'EditChildCategory')
	{	
		if(!empty($_POST['childcatId']) && !empty($_POST['childcat']) && !empty($_POST['subcat']) && !empty($_POST['cat'])){
			$childcategoryName = filter_var($_POST['childcat'], FILTER_SANITIZE_STRING) ;
			$childcategoryId = filter_var($_POST['childcatId'], FILTER_SANITIZE_NUMBER_INT);
			$subcategoryId = filter_var($_POST['subcat'], FILTER_SANITIZE_NUMBER_INT);
			$categoryId = filter_var($_POST['cat'], FILTER_SANITIZE_NUMBER_INT);
			$catName = get_category_name($pdo,$categoryId) ;
			$subcatName = get_subcategory_name($pdo,$subcategoryId) ;
			$upd = $pdo->prepare("update item_childcategory set ch_name = '".$childcategoryName."' , ch_c_id = '".$categoryId."' , ch_c_name = '".$catName."', ch_s_id = '".$subcategoryId."', ch_s_name = '".$subcatName."' where ch_id = '".$childcategoryId."'") ;
			$upd->execute();
			echo "Child Category is Updated Successfully";
			
		} else {
			echo "Error : Child Category Name, Id, Category Id & Sub Category Id is mandatory." ;
		}
	}
}
?>