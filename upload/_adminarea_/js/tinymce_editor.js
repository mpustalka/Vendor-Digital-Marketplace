tinymce.init({
	selector: "#item_message",
	setup : function(ed) {
                  ed.on('change', function(e) {
                     // This will print out all your content in the tinyMce box
                     console.log('the content '+ed.getContent());
                     // Your text from the tinyMce box will now be passed to your  text area ... 
                     $("#item_message").text(ed.getContent()); 
                  });
            },
	plugins: "textcolor paste advlist autolink lists link image charmap print preview anchor",
	toolbar: 'forecolor  | paste | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link',
	menubar:false,
    statusbar: false,
	content_style: ".mce-content-body {font-size:15px;font-family:Arial,sans-serif;}",
	height: 400,
	width: "100%"
});

tinymce.init({
	selector: ".new_txtarea",
	setup : function(eds) {
                  eds.on('change', function(e) {
                     // This will print out all your content in the tinyMce box
                     console.log('the content '+eds.getContent());
                     // Your text from the tinyMce box will now be passed to your  text area ... 
                     $(".new_txtarea").text(eds.getContent()); 
                  });
            },
	plugins: "textcolor paste advlist autolink lists link image charmap print preview anchor",
	toolbar: 'forecolor  | paste | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link',
	menubar:false,
    statusbar: false,
	content_style: ".mce-content-body {font-size:15px;font-family:Arial,sans-serif;}",
	height: 400,
	width: "100%"
});


/*$( document ).ready(function() {	
	$(document).on('submit','#posts', function(event){
		var formData = $(this).serialize();
		$.ajax({
                url: "action.php",
                method: "POST",              
                data: formData,
				dataType:"json",
                success: function(data) {     
					var html = $("#postHtml").html();					
					html = html.replace(/USERNAME/g, data.user);
					html = html.replace(/POSTDATE/g, data.post_date);
					html = html.replace(/POSTMESSAGE/g, data.message);
					$("#postLsit").append(html).fadeIn('slow');
					tinymce.get('message').setContent('');
                }
        });		
		return false;
	});
});*/