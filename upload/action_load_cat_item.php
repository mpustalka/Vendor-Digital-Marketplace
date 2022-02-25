<?php
ob_start();
session_start();
include("_adminarea_/db/config.php");
include("_adminarea_/db/function_xss.php");
if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'load_category_item')
		{
			$category_id = filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT) ;
			if($category_id != '0') {
				echo fetch_product_by_category_foruser($pdo,$category_id );
			} else {
				echo fetch_newallproduct_foruser($pdo) ;
			}
		}
	if($_POST['btn_action'] == 'load_subcategory_item')
		{
			$subcategory_id = filter_var($_POST['subcategory_id'], FILTER_SANITIZE_NUMBER_INT) ;
			if($subcategory_id != '') {
				echo fetch_product_by_subcategory_foruser($pdo,$subcategory_id );
			}
		}
	if($_POST['btn_action'] == 'load_childcategory_item')
		{
			$childcategory_id = filter_var($_POST['childcategory_id'], FILTER_SANITIZE_NUMBER_INT) ;
			if($childcategory_id != '') {
				echo fetch_product_by_childcategory_foruser($pdo,$childcategory_id );
			}
		}
	if($_POST['btn_action'] == 'load_featured_item')
		{
			$category_id = filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT) ;
			if($category_id != '0') {
				echo fetch_featuredproduct_by_category_foruser($pdo,$category_id );
			} else {
				echo fetch_featuredproduct_foruser($pdo) ;
			}
		}
	if($_POST['btn_action'] == 'load_price')
	{
		if(!empty($_POST['item_id']) && !empty($_POST['lic_id'])){
			$lic_id = filter_var($_POST['lic_id'], FILTER_SANITIZE_NUMBER_INT) ;
			if($lic_id == '1') {
				echo get_item_price($pdo, filter_var($_POST['item_id'], FILTER_SANITIZE_NUMBER_INT));
			} else {
				echo get_item_extended_price($pdo, filter_var($_POST['item_id'], FILTER_SANITIZE_NUMBER_INT));
			}
		} 
	}
}
?>
