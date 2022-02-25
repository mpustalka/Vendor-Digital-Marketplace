jQuery(document).ready(function($) {
	
	 "use strict";
	 var base_url = location.protocol + '//' + location.host + location.pathname ;
	base_url = base_url.substring(0, base_url.lastIndexOf("/") + 1);
	
	var newbase_url = window.location.href;
	newbase_url = newbase_url.substring(0, newbase_url.substring(0, newbase_url.lastIndexOf("/")).lastIndexOf("/")+1) ;
	var mainDocument = $(document);
	
	var manageSubCategoryTable = $('#manageSubCategoryTable').DataTable({
		'ajax': 'fetchSubCategory.php',
		'order': []
	});
	var manageCategoryTable = $('#manageCategoryTable').DataTable({
		'ajax': 'fetchCategory.php',
		'order': []
	});
	var manageChildCategoryTable = $('#manageChildCategoryTable').DataTable({
		'ajax': 'fetchChildCategory.php',
		'order': []
	});
	var manageItemsTable = $('#manageItemsTable').DataTable({
		'ajax': 'fetchItems.php',
		'order': []
	});
	var manageTopItemsTable = $('#manageTopItemsTable').DataTable({
		'ajax': 'fetchTopItems.php',
		'order': []
	});
	var manageFeaturedItemsTable = $('#manageFeaturedItemsTable').DataTable({
		'ajax': 'fetchFeaturedItems.php',
		'order': []
	});
	var manageDraftItemsTable = $('#manageDraftItemsTable').DataTable({
		'ajax': 'fetchDraftItems.php',
		'order': []
	});
	
	var manageRatingTable = $('#manageRatingTable').DataTable({
		'ajax': 'fetchRating.php',
		'order': []
	});
	
	var managePaymentTable = $('#managePaymentTable').DataTable({
		'ajax': 'fetchPayment.php',
		'order': []
	});
	
	var manageUserTable = $('#manageUserTable').DataTable({
		'ajax': 'fetchUsers.php',
		'order': []
	});
	var manageBlockedUserTable = $('#manageBlockedUserTable').DataTable({
		'ajax': 'fetchBlockedUser.php',
		'order': []
	});
	var manageCommentTable = $('#manageCommentTable').DataTable({
		'ajax': 'fetchComment.php',
		'order': []
	});
	var managePagesTable = $('#managePagesTable').DataTable({
		'ajax': 'fetchPages.php',
		'order': []
	});
	
	mainDocument.on("click","#hide", function() {
		$(".errorMessage").hide();
	});
	
	 $(document).on('keyup','.page_slug', function(){
        var pageSlug = $('.page_slug').val();
		var newPageSlug = pageSlug.replace(/[^A-Za-z]+/g, '');
        $('.page_slug').val(newPageSlug);
		var newUrl = newbase_url + 'page/' + newPageSlug ;
		$('.page_url').val(newUrl);
    });
	 mainDocument.on('click', '.changeUserStatus', function(){
			var id = $(this).attr("id");
			var status = $(this).data("status");
			var btn_action = "changeUserStatus";
			if(confirm("Are you sure you want to change User Block Status ?"))
			{
				$.ajax({
					url: base_url+"action_page.php",
					method:"POST",
					data:{id:id, status:status, btn_action:btn_action},
					success:function(data)
					{
						$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
						manageUserTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		
		});
	
	mainDocument.on('submit','.savePage', function(event){
		event.preventDefault();
		$('#action_page').attr('disabled','disabled'); 
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"action_page.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				
				if(data == 1) {
					$('#action_page').attr('disabled', false); 
					$('.remove-messages').fadeIn().html('<div  class="alert alert-danger errorMessage">Any of the Mandatory Field is missing.<button type="button" class="close float-right" aria-label="Close" > <span aria-hidden="true" id="hide">&times;</span></button></div>');
				} 
				if(data == 2) {
					$('#action_page').attr('disabled', false); 
					$('.remove-messages').fadeIn().html('<div  class="alert alert-danger errorMessage">Page Slug already used & must be different for every page.<button type="button" class="close float-right" aria-label="Close" > <span aria-hidden="true" id="hide">&times;</span></button></div>');
				} 
				if(data == 0) {
					$('.savePage')[0].reset();
					$('.savePage').hide('slow') ;
					$('.step3').show('slow') ;
				}
			}
		})
	});
	
	mainDocument.on('submit','.editPage', function(event){
		event.preventDefault();
		$('#action_page').attr('disabled','disabled'); 
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"action_page.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				
				if(data == 1) {
					$('#action_page').attr('disabled', false); 
					$('.remove-messages').fadeIn().html('<div  class="alert alert-danger errorMessage">Any of the Mandatory Field is missing.<button type="button" class="close float-right" aria-label="Close" > <span aria-hidden="true" id="hide">&times;</span></button></div>');
				} 
				if(data == 2) {
					$('#action_page').attr('disabled', false); 
					$('.remove-messages').fadeIn().html('<div  class="alert alert-danger errorMessage">Page Slug already used & must be different for every page.<button type="button" class="close float-right" aria-label="Close" > <span aria-hidden="true" id="hide">&times;</span></button></div>');
				} 
				if(data == 0) {
					$('.editPage')[0].reset();
					$('.editPage').hide('slow') ;
					$('.step2').show('slow') ;
				}
			}
		})
	});
	
	mainDocument.on('click', '.changePageStatus', function(){
			var id = $(this).attr("id");
			var status = $(this).data("status");
			var btn_action = "changePageStatus";
			if(confirm("Are you sure you want to change Page Status ?"))
			{
				$.ajax({
					url: base_url+"action_page.php",
					method:"POST",
					data:{id:id, status:status, btn_action:btn_action},
					success:function(data)
					{
						$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
						managePagesTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		
		});
	
	$(document).on('click', '.editRating', function(){
		var itempId = $(this).attr("id"); 
		var btn_action_view = 'fetch_rating' ;
		$.ajax({
			url: base_url+"action_fetch_rating.php",
			method:"POST",
			data:{itempId:itempId, btn_action_view:btn_action_view},
			dataType:"json",
			success:function(data)
			{
				$('#editratingModal').modal('show');
				$('.modal-title').html("<i class='fa fa-pencil-alt'></i> Edit Rating");
				$('.oldRating').html('<b>Old Rating : '+data.rating+'&ensp;</b>');
				$('#edititemId').val(data.itemId);
				$('#userid').val(data.userid);
				$('#itempId').val(data.itempId);
				$('.itemReview').val(data.comment);
				$('#oldRating').val(data.rating);
			}
		});
		
	});
	
	$(document).on('submit','.editrating_form', function(event){
		event.preventDefault();
		var that = $(this),
        url = that.attr('action'),
        type = that.attr('method'),
        data = {};

		that.find('[name]').each(function(index, value){
			var that = $(this),
			name = that.attr('name'),
			value = that.val();
	
			data[name] = value;
		});
		data = $(this).serialize() ;
		$.ajax({
			url: base_url+"submit_rating.php",
			method:"POST",
			data:data,
			dataType:"json",
			success:function(data)
			{	
				$('#editratingModal').modal('hide');
				$('#action_sb_edit').attr('disabled',false);
				$('.remove-messages').fadeIn().html('<div class="alert alert-success">'+(data.form_message)+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
				manageRatingTable.ajax.reload();
				
			}
		});
		return false;
	});
	
	mainDocument.on('click', '.revokeRight', function(){
			var itempId = $(this).attr("id");
			var status = $(this).data("status");
			var btn_action_sb_edit = "revokeRight";
			if(confirm("Are you sure you want to change Revoke Right status of this User on this Item?"))
			{
				$.ajax({
					url: base_url+"submit_rating.php",
					method:"POST",
					data:{itempId:itempId, status:status, btn_action_sb_edit:btn_action_sb_edit},
					success:function(data)
					{
						$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
						manageRatingTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		
		});
	
	mainDocument.on('click', '.changeCommentStatus', function(){
			var commentId = $(this).attr("id");
			var status = $(this).data("status");
			var btn_action = "changeCommentStatus";
			if(confirm("Are you sure you want to change Comment status?"))
			{
				$.ajax({
					url: base_url+"change_comment_status.php",
					method:"POST",
					data:{commentId:commentId, status:status, btn_action:btn_action},
					success:function(data)
					{
						$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
						manageCommentTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		
		});
	
	mainDocument.on('click', '.editCommentStatus', function(){												
		var commentId = $(this).attr("id");
		var btn_action = 'fetch_comment';
		$('#comment_form')[0].reset();
		$.ajax({
			url: base_url+"change_comment_status.php",
			method:"POST",
			data:{commentId:commentId, btn_action:btn_action},
			dataType:"json",
			success:function(data)
			{	
				$('#commentModal').modal('show');
				$('#comment_date').val(data.commentDate);
				var ad = tinymce.get("replyText").setContent(decodeEntities(data.replyText));
				$('#comment_id').val(data.commentId);
				$('#comment_name').val(data.commentName);
				$('#comment_email').val(data.commentEmail);
				$('.itemId').val(data.itemId);
				$('#commentText').val(decodeEntities(data.commentText));
				$('#action').val('Edit Comment');
				$('#btn_action').val('EditComment');
			}
		})
	});
	
	mainDocument.on('submit','#comment_form', function(event){
		event.preventDefault();
		$('#action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"change_comment_status.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#comment_form')[0].reset();
				$('#commentModal').modal('hide');
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
				$('#action').attr('disabled', false);
				manageCommentTable.ajax.reload();
			}
		})
	});
	
	mainDocument.on('click', '.changeBlockedStatus', function(){
			var userId = $(this).attr("id");
			var status = $(this).data("status");
			var btn_action = "changeBlockedStatus";
			if(confirm("Are you sure you want to change Block Status of this User & Send Email ? "))
			{
				$.ajax({
					url: base_url+"change_blocked_status.php",
					method:"POST",
					data:{userId:userId, status:status, btn_action:btn_action},
					success:function(data)
					{
						$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
						manageBlockedUserTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		
		});
	
	mainDocument.ready(function(){
		$('.announce_date ,.comment_date ,.order_date').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
			orientation: "top",
			endDate: "today"
		});
	});
	
	
	 mainDocument.on('click', '.changeItemFeatureStatus', function(){
			var item_id = $(this).attr("id");
			var status = $(this).data("status");
			var btn_action = "changeItemFeatureStatus";
			if(confirm("Note : Are you sure you want to change Featured Status of this Item ?"))
			{
				$.ajax({
					url: base_url+"action_item.php",
					method:"POST",
					data:{item_id:item_id, status:status, btn_action:btn_action},
					success:function(data)
					{
						$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
						manageItemsTable.ajax.reload();
						manageFeaturedItemsTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		
		});
		
	
	mainDocument.on('click', '#add_catgory', function(){
		$('#catModal').modal('show');
		$('.cat_form')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add Category");
		$('#action_cat').val('Save Category');
		$('#btn_action_cat').val('SaveCategory');
	});
	 
	 $(document).on('submit','#cat_form', function(event){
		event.preventDefault();
		var form_data = $(this).serialize();
		$.ajax({
			url: "action_add_category.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{	
				$('#catModal').modal('hide');
				$('.cat_form')[0].reset();
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+(data)+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
				manageCategoryTable.ajax.reload();
			}
		})
	});
	 
	 mainDocument.on('click', '.editCategory', function(){												
		var catId = $(this).attr("id");
		var btn_action_cat = 'fetch_category';
		$('.cat_form')[0].reset();
		$.ajax({
			url:base_url+"action_add_category.php",
			method:"POST",
			data:{catId:catId, btn_action_cat:btn_action_cat},
			dataType:"json",
			success:function(data)
			{	
				$('#catModal').modal('show');
				$('.modal-title').html("<i class='fa fa-pencil-alt'></i> Edit Category");
				$('#cat').val(data.categoryName);
				$('.catId').val(data.catId);
				$('#action_cat').val('Edit Category');
				$('#btn_action_cat').val('EditCategory');
			}
		})
	});
	 
	 mainDocument.on('click', '.changeCatStatusToDeactive', function(){
			var catId = $(this).attr("id");
			var status = $(this).data("status");
			var btn_action_cat = "changeCatStatusToDeactive";
			if(confirm("Note : If Category deactive then All the Subcategory, Child Category & Item belongs to this category will also be deactivated. Are you sure ?"))
			{
				$.ajax({
					url: base_url+"action_add_category.php",
					method:"POST",
					data:{catId:catId, status:status, btn_action_cat:btn_action_cat},
					success:function(data)
					{
						$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
						manageCategoryTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		
		});
	 mainDocument.on('click', '.changeCatStatusToActive', function(){
			var catId = $(this).attr("id");
			var status = $(this).data("status");
			var btn_action_cat = "changeCatStatusToActive";
			if(confirm("Note : If Category active then All the Subcategory, Child Category & Item belongs to this category will also be Activated & Live. Are you sure ?"))
			{
				$.ajax({
					url: base_url+"action_add_category.php",
					method:"POST",
					data:{catId:catId, status:status, btn_action_cat:btn_action_cat},
					success:function(data)
					{
						$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
						manageCategoryTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		
		});
	 
	 mainDocument.on('click', '#add_subcatgory', function(){
		$('#subcatModal').modal('show');
		$('#subcat_form')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add Sub Category");
		$('#action_cat').val('Save Sub Category');
		$('#btn_action_cat').val('SaveSubCategory');
	});
	  $(document).on('submit','#subcat_form', function(event){
		event.preventDefault();
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"action_add_category.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{	
				$('#subcatModal').modal('hide');
				$('#subcat_form')[0].reset();
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+(data)+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
				manageSubCategoryTable.ajax.reload();
			}
		})
	});
	  
	  mainDocument.on('click', '.editSubCategory', function(){												
		var subcatId = $(this).attr("id");
		var btn_action_cat = 'fetch_subcategory';
		$('#subcat_form')[0].reset();
		$.ajax({
			url:base_url+"action_add_category.php",
			method:"POST",
			data:{subcatId:subcatId, btn_action_cat:btn_action_cat},
			dataType:"json",
			success:function(data)
			{	
				$('#subcatModal').modal('show');
				$('.modal-title').html("<i class='fa fa-pencil-alt'></i> Edit Sub Category");
				$('#subcat').val(data.subcategoryName);
				$('.cat').val(data.categoryId);
				$('.subcatId').val(data.subcatId);
				$('#action_cat').val('Edit Sub Category');
				$('#btn_action_cat').val('EditSubCategory');
			}
		})
	});
	  
	   mainDocument.on('click', '.changeSubCatStatusToDeactive', function(){
			var subcatId = $(this).attr("id");
			var status = $(this).data("status");
			var btn_action_cat = "changeSubCatStatusToDeactive";
			if(confirm("Note : If SubCategory deactive then All Child Category & Item belongs to this sub category will also be deactivated. Are you sure ?"))
			{
				$.ajax({
					url: base_url+"action_add_category.php",
					method:"POST",
					data:{subcatId:subcatId, status:status, btn_action_cat:btn_action_cat},
					success:function(data)
					{
						$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
						manageSubCategoryTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		
		});
	 mainDocument.on('click', '.changeSubCatStatusToActive', function(){
			var subcatId = $(this).attr("id");
			var status = $(this).data("status");
			var btn_action_cat = "changeSubCatStatusToActive";
			if(confirm("Note : If Category active then All the Child Category & Item belongs to this sub category will also be Activated & Live. Are you sure ?"))
			{
				$.ajax({
					url: base_url+"action_add_category.php",
					method:"POST",
					data:{subcatId:subcatId, status:status, btn_action_cat:btn_action_cat},
					success:function(data)
					{
						$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
						manageSubCategoryTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		
		});
	  
	   mainDocument.on('click', '#add_childcatgory', function(){
		$('#childcatModal').modal('show');
		$('#childcat_form')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add Child Category");
		$('#action_cat').val('Save Child Category');
		$('#btn_action_cat').val('SaveChildCategory');
	});
	  $(document).on('submit','#childcat_form', function(event){
		event.preventDefault();
		var form_data = $(this).serialize();
		$.ajax({
			url: "action_add_category.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{	
				$('#childcatModal').modal('hide');
				$('#childcat_form')[0].reset();
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+(data)+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
				manageChildCategoryTable.ajax.reload();
			}
		})
	});
	  
	  mainDocument.on('click', '.editChildCategory', function(){												
		var childcatId = $(this).attr("id");
		var btn_action_cat = 'fetch_childcategory';
		$('#childcat_form')[0].reset();
		$.ajax({
			url:base_url+"action_add_category.php",
			method:"POST",
			data:{childcatId:childcatId, btn_action_cat:btn_action_cat},
			dataType:"json",
			success:function(data)
			{	
				$('#childcatModal').modal('show');
				$('.modal-title').html("<i class='fa fa-pencil-alt'></i> Edit Child Category");
				$('#childcat').val(data.childcategoryName);
				$('.cat').val(data.categoryId);
				$('.subcat').val(data.subcatId);
				$('.childcatId').val(data.childcatId);
				$('#action_cat').val('Edit Child Category');
				$('#btn_action_cat').val('EditChildCategory');
			}
		})
	});
	  
	  mainDocument.on('click', '.changeChildCatStatusToDeactive', function(){
			var childcatId = $(this).attr("id");
			var status = $(this).data("status");
			var btn_action_cat = "changeChildCatStatusToDeactive";
			if(confirm("Note : If Child Category deactive then All the Item belongs to this child category will also be deactivated. Are you sure ?"))
			{
				$.ajax({
					url: base_url+"action_add_category.php",
					method:"POST",
					data:{childcatId:childcatId, status:status, btn_action_cat:btn_action_cat},
					success:function(data)
					{
						$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
						manageChildCategoryTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		
		});
	 mainDocument.on('click', '.changeChildCatStatusToActive', function(){
			var childcatId = $(this).attr("id");
			var status = $(this).data("status");
			var btn_action_cat = "changeChildCatStatusToActive";
			if(confirm("Note : If Child Category active then All the Item belongs to this child category will also be Activated & Live. Are you sure ?"))
			{
				$.ajax({
					url: base_url+"action_add_category.php",
					method:"POST",
					data:{childcatId:childcatId, status:status, btn_action_cat:btn_action_cat},
					success:function(data)
					{
						$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
						manageChildCategoryTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		
		});
	  
	  mainDocument.on('submit','.step1form', function(event){
		event.preventDefault();
		$('#action-item').attr('disabled','disabled'); 
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"action_item.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				if(data == 1) {
					$('#action-item').attr('disabled', false); 
					$('.remove-messages').fadeIn().html('<div  class="alert alert-danger errorMessage">Youtube Link is wrong.<button type="button" class="close float-right" aria-label="Close" > <span aria-hidden="true" id="hide">&times;</span></button></div>');
				} 
				if(data == 2) {
					$('#action-item').attr('disabled', false); 
					$('.remove-messages').fadeIn().html('<div  class="alert alert-danger errorMessage">Any of the Mandatory Field is missing.<button type="button" class="close float-right" aria-label="Close" > <span aria-hidden="true" id="hide">&times;</span></button></div>');
				} 
				data = JSON.parse(data);
				if(data.error == 0){
					$('.step1form')[0].reset();
					$('#item_id').val(data.item_id);
					$('.step1').hide('slow') ;
					$('.step2').show('slow') ;
				}
			}
		})
	});
	  
	   mainDocument.on('submit','.step1formedit', function(event){
		event.preventDefault();
		$('#action-item').attr('disabled','disabled'); 
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"action_item.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				if(data == 1) {
					$('#action-item').attr('disabled', false); 
					$('.remove-messages').fadeIn().html('<div  class="alert alert-danger errorMessage">Youtube Link is wrong.<button type="button" class="close float-right" aria-label="Close" > <span aria-hidden="true" id="hide">&times;</span></button></div>');
				} 
				if(data == 2) {
					$('#action-item').attr('disabled', false); 
					$('.remove-messages').fadeIn().html('<div  class="alert alert-danger errorMessage">Any of the Mandatory Field is missing.<button type="button" class="close float-right" aria-label="Close" > <span aria-hidden="true" id="hide">&times;</span></button></div>');
				}
				data = JSON.parse(data);
				if(data.error == 0){
					$('#editModal').modal('show') ;
					$('.step1formedit')[0].reset();
					$('.item_id').val(data.item_id);
					$('.step1').hide('slow') ;
					$('.step2').show('slow') ;
				}
			}
		})
	});
	 
	 $(document).on('change','#cat', function(){
        var category_id = $('#cat').val();
        var btn_action = 'load_subcategory';
        $.ajax({
            url: base_url+"action_item.php",
            method:"POST",
            data:{category_id:category_id, btn_action:btn_action},
            success:function(data)
            {
                $('#subcat').html(data);
				$('#childcat').html('<option value="">Select Child Category</option>');
            }
        });
    });
	 
	 $(document).on('change','#subcat', function(){
        var subcategory_id = $('#subcat').val();
        var btn_action = 'load_childcategory';
        $.ajax({
            url: base_url+"action_item.php",
            method:"POST",
            data:{subcategory_id:subcategory_id, btn_action:btn_action},
            success:function(data)
            {
                $('#childcat').html(data);
            }
        });
    });
	 
	 $(document).on('change','#uploadThumbnail', function(event){
		event.preventDefault();
		$('.thumbprogress').show();
		var allowedTypes = ['jpeg', 'jpg', 'png'];
		var FileSize = (document.getElementById("uploadThumbnail").files[0].size/1024)/1024; 
        var file = $('#uploadThumbnail').val().split('\\').pop();
        var fileType = file.allowedTypes;
		var extension = file.substr( (file.lastIndexOf('.') +1) );
		var item_id = $('#item_id').val();
		var newfile = $('input[name="uploadThumbnail"]').get(0).files[0];
		var formData = new FormData();
		formData.append('newfile', newfile);
		formData.append('item_id', item_id);
		if($('#uploadThumbnail').val()) {
			if(allowedTypes.includes(extension))
			{
				if(FileSize < 10) {
					event.preventDefault();
					$('#targetLayer').hide();
					$.ajax({
						   xhr: function() {
							var xhr = new window.XMLHttpRequest();
							xhr.upload.addEventListener("progress", function(evt) {
								if (evt.lengthComputable) {
									
									var percentComplete = (evt.loaded / evt.total) * 100;
									//Do something with upload progress here
									$('.thumb-bar').animate({
										width: percentComplete + '%'
									}, {
										duration: 1000
									});
								}
						   }, false);
						   return xhr;
						},
						 url: base_url+"action_upload.php",
           				 method:"POST",
						 data: formData,
						 contentType: false,
						 processData: false,
						 cache: false,
						target: '#targetLayer',
						success:function(data){
							
							$('.remove-messagesthumbnail').fadeIn().html('<div class="alert alert-success">Thumbnail  Image Uploaded Successfully.</div>');
							$('.thmb').hide();
							$('.thumbprogress').hide();
						},
						resetForm: true
					});
				} else {
					alert("Image must not be greater than 10 MB.") ;
					$('#uploadThumbnail').val('');
					$('.thumbprogress').hide();
					return false;
				}
			} else {
				alert("Wrong File Type") ;
				$('#uploadThumbnail').val('');
				$('.thumbprogress').hide();
				return false;
			}
		} else {
			alert("Please Select an Image.") ;
			$('#uploadThumbnail').val('');
			$('.thumbprogress').hide();
			return false;
		}
		return false;
	});
	 
	 $(document).on('change','#uploadPreview', function(event){
		event.preventDefault();
		$('.previewprogress').show();
		var allowedTypes = ['jpeg', 'jpg', 'png'];
		var FileSize = (document.getElementById("uploadPreview").files[0].size/1024)/1024; 
        var file = $('#uploadPreview').val().split('\\').pop();
        var fileType = file.allowedTypes;
		var extension = file.substr( (file.lastIndexOf('.') +1) );
		var item_id = $('#item_id').val();
		var previewfile = $('input[name="uploadPreview"]').get(0).files[0];
		var formData = new FormData();
		formData.append('previewfile', previewfile);
		formData.append('item_id', item_id);
		if($('#uploadPreview').val()) {
			if(allowedTypes.includes(extension))
			{
				if(FileSize < 10) {
					event.preventDefault();
					$('#targetLayer').hide();
					$.ajax({
						   xhr: function() {
							var xhr = new window.XMLHttpRequest();
							xhr.upload.addEventListener("progress", function(evt) {
								if (evt.lengthComputable) {
									
									var percentComplete = (evt.loaded / evt.total) * 100;
									$('.preview-bar').animate({
										width: percentComplete + '%'
									}, {
										duration: 1000
									});
								}
						   }, false);
						   return xhr;
						},
						 url: base_url+"action_upload.php",
           				 method:"POST",
						 data: formData,
						 contentType: false,
						 processData: false,
						 cache: false,
						target: '#targetLayer',
						success:function(data){
							
							$('.remove-messagespreview').fadeIn().html('<div class="alert alert-success">Preview Image Uploaded Successfully.</div>');
							$('.prvw').hide();
							$('.previewprogress').hide();
						},
						resetForm: true
					});
				} else {
					alert("Image must not be greater than 10 MB.") ;
					$('#uploadPreview').val('');
					$('.previewprogress').hide();
					return false;
				}
			} else {
				alert("Wrong File Type") ;
				$('#uploadPreview').val('');
				$('.previewprogress').hide();
				return false;
			}
		} else {
			alert("Please Select an Image.") ;
			$('#uploadPreview').val('');
			$('.previewprogress').hide();
			return false;
		}
		return false;
	});
	 
	 $(document).on('change','#uploadMainFile', function(event){
		event.preventDefault();
		$('.mainfileprogress').show();
		var allowedTypes = ['zip'];
		var FileSize = (document.getElementById("uploadMainFile").files[0].size/1024)/1024; 
        var file = $('#uploadMainFile').val().split('\\').pop();
        var fileType = file.allowedTypes;
		var extension = file.substr( (file.lastIndexOf('.') +1) );
		var item_id = $('#item_id').val();
		var mainfile = $('input[name="uploadMainFile"]').get(0).files[0];
		var formData = new FormData();
		formData.append('mainfile', mainfile);
		formData.append('item_id', item_id);
		if($('#uploadMainFile').val()) {
			if(allowedTypes.includes(extension))
			{
				if(FileSize < 256.1) {
					event.preventDefault();
					$('#targetLayer').hide();
					$.ajax({
						   xhr: function() {
							var xhr = new window.XMLHttpRequest();
							xhr.upload.addEventListener("progress", function(evt) {
								if (evt.lengthComputable) {
									
									var percentComplete = (evt.loaded / evt.total) * 100;
									//Do something with upload progress here
									$('.mainfile-bar').animate({
										width: percentComplete + '%'
									}, {
										duration: 1000
									});
								}
						   }, false);
						   return xhr;
						},
						 url: base_url+"action_upload.php",
           				 method:"POST",
						 data: formData,
						 contentType: false,
						 processData: false,
						 cache: false,
						target: '#targetLayer',
						success:function(data){
							
							$('.remove-messagesmainfile').fadeIn().html('<div class="alert alert-success">Main Zip File Uploaded Successfully.</div>');
							$('.mainfile').hide();
							$('.mainfileprogress').hide();
						},
						resetForm: true
					});
				} else {
					alert("File must not be greater than 256 MB.") ;
					$('#uploadMainFile').val('');
					$('.mainfileprogress').hide();
					return false;
				}
			} else {
				alert("Wrong File Type") ;
				$('#uploadMainFile').val('');
				$('.mainfileprogress').hide();
				return false;
			}
		} else {
			alert("Please Select a zip file.") ;
			$('#uploadMainFile').val('');
			$('.mainfileprogress').hide();
			return false;
		}
		return false;
	});
	 
	 $(document).on('change','#uploadDocumentation', function(event){
		event.preventDefault();
		$('.documentationprogress').show();
		var allowedTypes = ['zip'];
		var FileSize = (document.getElementById("uploadDocumentation").files[0].size/1024)/1024; 
        var file = $('#uploadDocumentation').val().split('\\').pop();
        var fileType = file.allowedTypes;
		var extension = file.substr( (file.lastIndexOf('.') +1) );
		var item_id = $('#item_id').val();
		var docufile = $('input[name="uploadDocumentation"]').get(0).files[0];
		var formData = new FormData();
		formData.append('docufile', docufile);
		formData.append('item_id', item_id);
		if($('#uploadDocumentation').val()) {
			if(allowedTypes.includes(extension))
			{
				if(FileSize < 128.1) {
					event.preventDefault();
					$('#targetLayer').hide();
					$.ajax({
						   xhr: function() {
							var xhr = new window.XMLHttpRequest();
							xhr.upload.addEventListener("progress", function(evt) {
								if (evt.lengthComputable) {
									
									var percentComplete = (evt.loaded / evt.total) * 100;
									//Do something with upload progress here
									$('.docufile-bar').animate({
										width: percentComplete + '%'
									}, {
										duration: 1000
									});
								}
						   }, false);
						   return xhr;
						},
						 url: base_url+"action_upload.php",
           				 method:"POST",
						 data: formData,
						 contentType: false,
						 processData: false,
						 cache: false,
						target: '#targetLayer',
						success:function(data){
							
							$('.remove-messagesdocumentation').fadeIn().html('<div class="alert alert-success">Screenshot Zip File Uploaded Successfully.</div>');
							$('.dcmntn').hide();
							$('.documentationprogress').hide();
						},
						resetForm: true
					});
				} else {
					alert("File must not be greater than 100 MB.") ;
					$('#uploadDocumentation').val('');
					$('.documentationprogress').hide();
					return false;
				}
			} else {
				alert("Wrong File Type") ;
				$('#uploadDocumentation').val('');
				$('.documentationprogress').hide();
				return false;
			}
		} else {
			alert("Please Select a zip file.") ;
			$('#uploadDocumentation').val('');
			$('.documentationprogress').hide();
			return false;
		}
		return false;
	});
	 
	  $(document).on('click','.draftitem', function(event){
		$('.step2').hide('slow') ;
		$('.step4').show('slow') ;
	});
	 $(document).on('submit','.uploadFilesNew', function(event){
		event.preventDefault();
		var form_data = $(this).serialize();
		if(confirm("Update Item means Item will be active and live for Sale, Are you sure to do this ?"))
			{
				$.ajax({
					url: base_url+"action_item.php",
					method:"POST",
					data:form_data,
					success:function(data)
					{	
						$('.step2').hide('slow') ;
						$('.step3').show('slow') ;
					}
				})
			}
			else
			{
				return false;
			}
	});
	 $(document).on('click','.draftupdateitem', function(event){
		var item_id = $(this).attr("id");
		var btn_action = "changeItemStatus";
		if(confirm("Save into Draft means Item will be inactive and cannot view by User, Are you sure to do this ?"))
			{
				$.ajax({
					url: base_url+"action_item.php",
					method:"POST",
					data:{item_id:item_id, btn_action:btn_action},
					success:function(data)
					{	
						$('.step2').hide('slow') ;
						$('.step4').show('slow') ;
					}
				})
			}
			else
			{
				return false;
			}
	});
	 
	  $(document).on('click','.changeItemStatus', function(event){
		var item_id = $(this).attr("id");
		var btn_action = "changeItemStatus";
		if(confirm("Save into Draft means Item will be inactive and cannot view by User, Are you sure to do this ?"))
			{
				$.ajax({
					url: base_url+"action_item.php",
					method:"POST",
					data:{item_id:item_id, btn_action:btn_action},
					success:function(data)
					{	
						$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+(data)+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
						manageItemsTable.ajax.reload();
						manageFeaturedItemsTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
	});
	 
	 $(document).on('submit','.password_validation', function(event){
		event.preventDefault();
		var form_data = $(this).serialize();
		$.ajax({
			url: "action_password_detail.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{	
				$('#password_validation')[0].reset();
				data = JSON.parse(data);
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+(data.form_message)+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},3000);
			}
		})
	});
	
	$(document).on('submit','.email_validation', function(event){
		event.preventDefault();
		var form_data = $(this).serialize();
		$.ajax({
			url: "action_email_detail.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{	
				$('#email_validation')[0].reset();
				data = JSON.parse(data);
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+(data.form_message)+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},3000);
			}
		})
	});
	
	mainDocument.on('submit','.admin_settings', function(event){
		event.preventDefault();
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"action_setting.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{	
				data = JSON.parse(data);
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+(data.form_message)+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},3000);
			}
		})
	});
	
	
		
	function decodeEntities(encodedString) {
	  var textArea = document.createElement('textarea');
	  textArea.innerHTML = encodedString;
	  return textArea.value;
	}
});
