// JavaScript Document
jQuery(function ($) {
	
	"use strict";
	
	var base_url = location.protocol + '//' + location.host + location.pathname ;
	base_url = base_url.substring(0, base_url.lastIndexOf("/") + 1);
	
	
	$(document).on("click","#hide", function() {
		$(".errorMessage").hide();
	});
	$(document).on("click","#logreg-forms #forgot_pswd", function() {
		$('#logreg-forms .form-signin').toggle(); 
   		$('#logreg-forms .form-reset').toggle();											 
	});
  	$(document).on("click","#logreg-forms #cancel_reset", function() {
		$('#logreg-forms .form-signin').toggle(); 
   		$('#logreg-forms .form-reset').toggle();											 
	});
	 $(document).on("click","#logreg-forms #btn-signup ", function() {
		$('#logreg-forms .form-signup').toggle();
		$('#logreg-forms .form-signin').toggle();
	});
 	$(document).on("click","#logreg-forms #cancel_signup ", function() {
		$('#logreg-forms .form-signup').toggle();
		$('#logreg-forms .form-signin').toggle();
	});
	$(document).on('submit','.forgot_form', function(event){
		event.preventDefault();
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"verify_email.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('.forgot_form')[0].reset();
				if(data == 0) {
					$('.remove-messages').fadeIn().html('<div  class="alert alert-danger errorMessage">Sorry, This Email is not Registered. Try Again.<button type="button" class="close float-right" aria-label="Close" > <span aria-hidden="true" id="hide">&times;</span></button></div>');
				} else {
					$('#forgotModal').modal('show');
					$('#forgotemail').val(data);
				}
			}
		})
	});
	$(document).on('submit','#forgot_otpform', function(event){
		event.preventDefault();
		$('#action_fp').attr('disabled','disabled');
		$("#action_fp").html("Checking...");
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"verify_password_otp.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#forgot_otpform')[0].reset();
				$('#forgotModal').modal('hide');
				$('#action_fp').attr('disabled',false);
				if(data == 0) {
					$('.remove-messages').fadeIn().html('<div  class="alert alert-danger errorMessage">Wrong OTP Entered. Try Again.<button type="button" class="close float-right" aria-label="Close" > <span aria-hidden="true" id="hide">&times;</span></button></div>');
				} else {
					$('#forgotpasswordModal').modal('show');
					$('#forgotpasswordemail').val(data) ;
				}
			}
		})
	});
	$(document).on('submit','#forgotpassword_otpform', function(event){
		event.preventDefault();
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"change_forgot_password.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#forgotpassword_otpform')[0].reset();
				$('#forgotpasswordModal').modal('hide');
				if(data == 0) {
					$('.remove-messages').fadeIn().html('<div  class="alert alert-danger errorMessage">Password must contain 8 characters, an uppercase character, a lowercase character & atleast 1 number. Try Again.<button type="button" class="close float-right" aria-label="Close" > <span aria-hidden="true" id="hide">&times;</span></button></div>');
				}
				if(data == 1) {
					$('.remove-messages').fadeIn().html('<div  class="alert alert-danger errorMessage">New Password & Confirm New Password are not same. Try Again.<button type="button" class="close float-right" aria-label="Close" > <span aria-hidden="true" id="hide">&times;</span></button></div>');
				}
				if(data == 2) {
					$('.remove-messages').fadeIn().html('<div  class="alert alert-success errorMessage">Password changed successfully. Login Now.<button type="button" class="close float-right" aria-label="Close" > <span aria-hidden="true" id="hide">&times;</span></button></div>');
				}
			}
		})
	});
	
	$(document).on('submit','.signup_form', function(event){
		event.preventDefault();
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"verify_registration.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('.signup_form')[0].reset();
				if(data == 1) {
					$('.remove-messages').fadeIn().html('<div  class="alert alert-danger errorMessage">Password must contain minimum 8 characters, 1 Uppercase character, 1 Lowercase character & 1 number.<button type="button" class="close float-right" aria-label="Close" > <span aria-hidden="true" id="hide">&times;</span></button></div>');
				} 
				if(data == 2) {
					$('.remove-messages').fadeIn().html('<div  class="alert alert-danger errorMessage">Password & Confirm Password is not same.<button type="button" class="close float-right" aria-label="Close" > <span aria-hidden="true" id="hide">&times;</span></button></div>');
				}
				if(data == 3) {
					$('.remove-messages').fadeIn().html('<div  class="alert alert-danger errorMessage">Email is already Registered.<button type="button" class="close float-right" aria-label="Close" > <span aria-hidden="true" id="hide">&times;</span></button></div>');
				}
				data = JSON.parse(data);
				if(data.error == 0){
					window.location.href = base_url ;
				}
			}
		})
	});
	$(document).on('submit','#login_form', function(event){
		event.preventDefault();
		$('#action_log').attr('disabled','disabled');
		$("#action_log").html("Checking...");
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"verify_login.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#login_form')[0].reset();
				
				if(data == 0) {
					$('#action_log').attr('disabled',false);
					$("#action_log").html('<i class="fas fa-sign-in"></i> Sign in');
					$('.remove-messages').fadeIn().html('<div  class="alert alert-danger errorMessage">Email or Password Wrong/Deactivated. Try Again.<button type="button" class="close float-right" aria-label="Close" > <span aria-hidden="true" id="hide">&times;</span></button></div>');
				} else {
					window.location.href = base_url;
				}
			}
		})
	});
});