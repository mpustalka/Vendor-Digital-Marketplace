// JavaScript Document
jQuery(document).ready(function($) {
	
	 "use strict";	
	 
	var base_url = window.location.href;
	base_url = base_url.substring(0, base_url.substring(0, base_url.lastIndexOf("/")).lastIndexOf("/")+1) ;
	activaTab('descr');
	var spinner = $('#loaderCat');
	var manageDownloadTable = $('#manageDownloadTable').DataTable({
		'ajax': base_url+'fetchMyDownload.php',
		'order': []
	});
	
	var managePurchaseTable = $('#managePurchaseTable').DataTable({
		'ajax': base_url+'fetchMyPurchases.php',
		'order': []
	});
	
	$(document).on('click', '.openBtn', function(){
		openSearch() ;
	}) ;
	
	$(document).on('click', '.closebtn', function(){
		closeSearch() ;
	}) ;
	
	$(document).on('click', '.viewVideo', function(){
		var yid = $(this).attr("id");									
		$('.youtubeModal').modal('show');
		$('.modal-title').html('<i class="fa fa-video"></i> Youtube Video');
		$('.modal-body1').html('<div class="embed-responsive embed-responsive-16by9"><iframe  allowfullscreen="allowfullscreen" mozallowfullscreen="mozallowfullscreen"  msallowfullscreen="msallowfullscreen" oallowfullscreen="oallowfullscreen"  webkitallowfullscreen="webkitallowfullscreen" src="https://www.youtube.com/embed/'+yid+'?autoplay=1"></iframe><div>');
		});
		
		$(".youtubeModal").on("hidden.bs.modal", function(){
			$(".modal-body1").html("");
		});
	
	$(document).on('submit','.userComment', function(event){
		event.preventDefault();
		$('#submitComment').attr('disabled','disabled');
		$("#submitComment").val("Submitting Comment...");
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"action_user_comment.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('.userComment')[0].reset();
				$("#submitComment").val("Submit Comment");
				$('#submitComment').attr('disabled',false);
				$('.jQueryNewComment').html(data);
			}
		});
	});
	
	$(document).on('click','.show_more_newest_search',function(){
        var ID = $(this).attr('id');
        $('.show_more_new_search').hide();
        $('#loader-icon').show();
		var searchWord = $(this).attr('class');
		searchWord = searchWord.replace("show_more_newest_search",'');
		searchWord = searchWord.replace("btn",'');
		searchWord = searchWord.replace("btn-info",'');
		searchWord = searchWord.replace("btn-sm",'');
		searchWord = searchWord.replace("ann",'');
        $.ajax({
            type:'GET',
			url: base_url+'getLoadSearch.php?ID='+ID+'&searchWord='+searchWord,
            data:{ID:ID,searchWord:searchWord},
            success:function(html){
				$('#loader-icon').hide();
                $('#show_more_new_search'+ID).remove();
                $('.jQueryLoadSearchItem').append(html);
            }
        });
    });
	
	$(document).on('click','.show_more_newest_comment',function(){
        var ID = $(this).attr('id');
        $('.show_more_new_comment').hide();
        $('#loader-icon').show();
		var commentId = $(this).attr('class');
		commentId = commentId.replace("show_more_newest_comment",'');
		commentId = commentId.replace("btn",'');
		commentId = commentId.replace("btn-info",'');
		commentId = commentId.replace("btn-sm",'');
		commentId = commentId.replace("ann",'');
        $.ajax({
            type:'GET',
			url: base_url+'getOldComments.php?ID='+ID+'&commentId='+commentId,
            data:{ID:ID,commentId:commentId},
            success:function(html){
				$('#loader-icon').hide();
                $('#show_more_new_comment'+ID).remove();
                $('.jQueryOldComment').append(html);
            }
        });
    });
	
	$(document).on('click','.show_more_newest_rating',function(){
        var ID = $(this).attr('id');
        $('.show_more_new_rating').hide();
        $('#loader-icon').show();
		var ratingId = $(this).attr('class');
		ratingId = ratingId.replace("show_more_newest_rating",'');
		ratingId = ratingId.replace("btn",'');
		ratingId = ratingId.replace("btn-info",'');
		ratingId = ratingId.replace("btn-sm",'');
		ratingId = ratingId.replace("ann",'');
        $.ajax({
            type:'GET',
			url: base_url+'getNewRatings.php?ID='+ID+'&ratingId='+ratingId,
            data:{ID:ID,ratingId:ratingId},
            success:function(html){
				$('#loader-icon').hide();
                $('#show_more_new_rating'+ID).remove();
                $('.jQueryNewRating').append(html);
            }
        });
    });
	
	$(document).on('click', '.openRating', function(){
		var itemId = $(this).attr("id"); 
		var btn_action_view = 'fetch_data' ;
		$('.rating_form')[0].reset();
		$.ajax({
			url: base_url+"action_fetch_rating.php",
			method:"POST",
			data:{itemId:itemId, btn_action_view:btn_action_view},
			dataType:"json",
			success:function(data)
			{
				$('#ratingModal').modal('show');
				$('#itemId').val(data.itemId);
				$('#people').val(data.people);
				$('#rate').val(data.rate);
			}
		});
	});
	$(document).on('click', '.editRating', function(){
		var itemId = $(this).attr("id"); 
		var btn_action_view = 'fetch_rating' ;
		$.ajax({
			url: base_url+"action_fetch_rating.php",
			method:"POST",
			data:{itemId:itemId, btn_action_view:btn_action_view},
			dataType:"json",
			success:function(data)
			{
				$('#editratingModal').modal('show');
				$('.modal-title').html("<i class='fa fa-pencil-alt'></i> Edit Rating");
				$('.oldRating').html('<b>Old Rating : '+data.rating+'&ensp;</b>');
				$('#edititemId').val(data.itemId);
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
				manageDownloadTable.ajax.reload();
				
			}
		});
		return false;
	});
	
	$(document).on('submit','.rating_form', function(event){
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
				$('#ratingModal').modal('hide');
				$('#action_sb').attr('disabled',false);
				$('.remove-messages').fadeIn().html('<div class="alert alert-success">'+(data.form_message)+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
				manageDownloadTable.ajax.reload();
				
			}
		});
		return false;
	});
	
	$(document).on('change','.lic', function(){
        var lic_id = $('.lic').val();
		var item_id = $(this).attr('id');
        var btn_action = 'load_price';
		spinner.show();
        $.ajax({
            url:base_url+"action_load_cat_item.php",
            method:"POST",
            data:{item_id:item_id, lic_id:lic_id, btn_action:btn_action},
            success:function(data)
            {
				spinner.hide();
                $('.pri').html(data);
				$('.item_amount').val(data) ;
            }
        });
    });
	
	$(document).on('click','.show_more_newest_item',function(){
        var ID = $(this).attr('id');
        $('.show_more_new_item').hide();
        $('#loader-icon').show();
        $.ajax({
            type:'POST',
            url: base_url+'getNewItems.php?id='+ID,
            data:'id='+ID,
            success:function(html){
				$('#loader-icon').hide();
                $('#show_more_new_item'+ID).remove();
                $('.jQueryNewItem').append(html);
				$('.jQueryNewItemAppend').hide();
            }
        });
    });
	
	$(document).on('click','.show_more_newestfilter_item',function(){
        var ID = $(this).attr('id');
        $('.show_more_newestfilter_item').hide();
        $('#loader-icon').show();
		var catId = $(this).attr('class');
		catId = catId.replace("show_more_newestfilter_item",'');
		catId = catId.replace("btn",'');
		catId = catId.replace("btn-light",'');
		catId = catId.replace("btn-sm",'');
		catId = catId.replace("ann",'');
        $.ajax({
            type:'GET',
			cache: false,
            url: base_url+'getNewFilterItems.php?ID='+ID+'&catId='+catId,
            data:{ID:ID,catId:catId},
            success:function(html){
				$('#loader-icon').hide();
                $('#show_more_newfilter_item'+ID).remove();
				$('.jQueryNewItemAppend').empty();
				$('.jQueryNewItemAppend').show();
                $('.jQueryNewItemAppend').append(html);
            }
        });
    });
	
	$(document).on('change','.browsenewitems', function(){
        var category_id = $('.browsenewitems').val();
        var btn_action = 'load_category_item';
		spinner.show();
        $.ajax({
            url: base_url+"action_load_cat_item.php",
            method:"POST",
            data:{category_id:category_id, btn_action:btn_action},
            success:function(data)
            {
				spinner.hide();
				if(category_id != 0) {
					$('.newPro').hide() ;
					$('.fetchNewPro').html(data);
					$('.fetchNewPro').show() ;
					$('.jQueryNewItemAppend').empty();
				} else {
					$('.fetchNewPro').hide() ;
					$('.newPro').show() ;					
					$('#loader-icon').hide();
					$('.jQueryNewItemAppend').hide();
				}
            }
        });
    });
	
	$(document).on('change','.browsenewsubcatitems', function(){
        var subcategory_id = $('.browsenewsubcatitems').val();
        var btn_action = 'load_subcategory_item';
		spinner.show();
        $.ajax({
            url: base_url+"action_load_cat_item.php",
            method:"POST",
            data:{subcategory_id:subcategory_id, btn_action:btn_action},
            success:function(data)
            {
				spinner.hide();
				if(subcategory_id != '') {
					$('.newPro').hide() ;
					$('.fetchNewPro').html(data);
					$('.fetchNewPro').show() ;
					$('.jQueryNewItemAppend').empty();
				} 
            }
        });
    });
	
	$(document).on('click','.show_more_subcatfilter_item',function(){
        var ID = $(this).attr('id');
        $('.show_more_subcatfilter_item').hide();
        $('#loader-icon').show();
		var subcatId = $(this).attr('class');
		subcatId = subcatId.replace("show_more_subcatfilter_item",'');
		subcatId = subcatId.replace("btn",'');
		subcatId = subcatId.replace("btn-light",'');
		subcatId = subcatId.replace("btn-sm",'');
		subcatId = subcatId.replace("ann",'');
		subcatId = $.trim(subcatId);
        $.ajax({
            type:'GET',
			cache: false,
            url: base_url+'getNewFilterSubCatItems.php?ID='+ID+'&subcatId='+subcatId,
            data:{ID:ID,subcatId:subcatId},
            success:function(html){
				$('#loader-icon').hide();
                $('#show_more_newfilter_item'+ID).remove();
				$('.jQueryNewItemAppend').empty();
				$('.jQueryNewItemAppend').show();
                $('.jQueryNewItemAppend').append(html);
            }
        });
    });
	
	$(document).on('change','.browsenewchildcatitems', function(){
        var childcategory_id = $('.browsenewchildcatitems').val();
        var btn_action = 'load_childcategory_item';
		spinner.show();
        $.ajax({
            url: base_url+"action_load_cat_item.php",
            method:"POST",
            data:{childcategory_id:childcategory_id, btn_action:btn_action},
            success:function(data)
            {
				spinner.hide();
				if(childcategory_id != '') {
					$('.newPro').hide() ;
					$('.fetchNewPro').html(data);
					$('.fetchNewPro').show() ;
					$('.jQueryNewItemAppend').empty();
				} 
            }
        });
    });
	
	$(document).on('click','.show_more_childcatfilter_item',function(){
        var ID = $(this).attr('id');
        $('.show_more_childcatfilter_item').hide();
        $('#loader-icon').show();
		var childcatId = $(this).attr('class');
		childcatId = childcatId.replace("show_more_childcatfilter_item",'');
		childcatId = childcatId.replace("btn",'');
		childcatId = childcatId.replace("btn-light",'');
		childcatId = childcatId.replace("btn-sm",'');
		childcatId = childcatId.replace("ann",'');
		childcatId = $.trim(childcatId);
        $.ajax({
            type:'GET',
			cache: false,
            url: base_url+'getNewFilterChildCatItems.php?ID='+ID+'&childcatId='+childcatId,
            data:{ID:ID,childcatId:childcatId},
            success:function(html){
				$('#loader-icon').hide();
                $('#show_more_childcatfilter_item'+ID).remove();
				$('.jQueryNewItemAppend').empty();
				$('.jQueryNewItemAppend').show();
                $('.jQueryNewItemAppend').append(html);
            }
        });
    });
	
	$(document).on('click','.show_more_newfeatured_item',function(){
        var ID = $(this).attr('id');
        $('.show_more_featured_item').hide();
        $('#loader-icon').show();
        $.ajax({
            type:'POST',
            url: base_url+'getFeaturedItems.php?id='+ID,
            data:'id='+ID,
            success:function(html){
				$('#loader-icon').hide();
                $('#show_more_featured_item'+ID).remove();
                $('.jQueryNewItem').append(html);
				$('.jQueryNewItemAppend').hide();
            }
        });
    });
	
	$(document).on('change','.browsenewfeatureditems', function(){
        var category_id = $('.browsenewfeatureditems').val();
        var btn_action = 'load_featured_item';
		spinner.show();
        $.ajax({
            url: base_url+"action_load_cat_item.php",
            method:"POST",
            data:{category_id:category_id, btn_action:btn_action},
            success:function(data)
            {
				spinner.hide();
				if(category_id != 0) {
					$('.newPro').hide() ;
					$('.fetchNewPro').html(data);
					$('.fetchNewPro').show() ;
					$('.jQueryNewItemAppend').empty();
				} else {
					$('.fetchNewPro').hide() ;
					$('.newPro').show() ;					
					$('#loader-icon').hide();
					$('.jQueryNewItemAppend').hide();
				}
            }
        });
    });
	
	var newBaseUrl = window.location.href; 
	
	$(document).on('click','#action_resend', function(event){
		event.preventDefault();
		$.ajax({
			url: newBaseUrl+"resend_otp.php",
			method:"POST",
			data:$('form.resend_otpform').serialize(),
			success:function(data)
			{	
				data = JSON.parse(data);
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+(data.form_message)+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
			}
		})
	});
	
	$('#signupModal').modal('show');
	
	$(document).on('click','#action_sign', function(event){
		event.preventDefault();
		$.ajax({
			url: newBaseUrl+"verify_registration_otp.php",
			method:"POST",
			data:$('form.signup_otpform').serialize(),
			success:function(data)
			{	
				data = JSON.parse(data);
				if(data.err == 1) {
					alert("You missed your chances to verify and You are Permanently Blocked.") ;
					window.location.href = newBaseUrl+"logout.php";
				}
				if(data.err == 0) {
					alert("You've Successfully Verified. Thanks.") ;
					$('#signupModal').modal('hide');
				}
				if(data.err == 2) {
					if(data.chance == 0) {
						alert("You missed your chances to verify and You are Permanently Blocked.") ;
						window.location.href = newBaseUrl+"logout.php";
					} else {
						$('#otp').val('');
						$('.remove-messages').fadeIn().html('<div class="alert alert-danger">'+(data.form_message)+'</div>');
							setTimeout(function(){
								$(".remove-messages").fadeOut("slow");
							},3000);
					}
				}
				
			}
		})
	});
	
	$(document).on('submit','.password_validation', function(event){
		event.preventDefault();
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"action_password_detail.php",
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
			url: base_url+"action_email_detail.php",
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
	
	function activaTab(tab){
   		$('.nav-tabs a[href="#' + tab + '"]').tab('show');
	 };
	 
	function openSearch() {
	  document.getElementById("myOverlay").style.display = "block";
	}

	function closeSearch() {
	  document.getElementById("myOverlay").style.display = "none";
	}
	
});