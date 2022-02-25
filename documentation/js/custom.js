// JavaScript Document
jQuery(function ($) {
	
	"use strict";
	$(document).on("scroll", function(){
			if
		  ($(document).scrollTop() > 86){
			  $("#banner").addClass("shrink");
			}
			else
			{
				$("#banner").removeClass("shrink");
			}
	});
	
});