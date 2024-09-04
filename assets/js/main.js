$.noConflict();

jQuery(document).ready(function($) {

	"use strict";

	[].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {
		new SelectFx(el);
	} );

	jQuery('.selectpicker').selectpicker;


	$('#menuToggle').on('click', function(event) {
		$('body').toggleClass('open');
	});

	$('.search-trigger').on('click', function(event) {
		event.preventDefault();
		event.stopPropagation();
		$('.search-trigger').parent('.header-left').addClass('open');  
	});

	$('.search-close').on('click', function(event) {
		event.preventDefault();
		event.stopPropagation();
		$('.search-trigger').parent('.header-left').removeClass('open');
	});
	// $('.menu-title').on('click', function() {
	// 	if($(this).find('span > i ').hasClass('fa-rotate-90')){ //if class already exist then its remove
	// 		$(this).find('span  > i ').removeClass('fa-rotate-90');
	// 	}else{
	// 		// $(this).find('span  > i ').addClass('fa-rotate-90').siblings().removeClass('fa-rotate-90');  //remove all current
	// 		$(this).find('span  > i ').addClass('fa-rotate-90');
	// 	}
	// });
	// $('.menu-title').on('click', function() {
	// 	$(this).find('span  > i ').toggleClass('fa-rotate-90');
	// });

	
// 	var el = document.getElementById("divID");
// // If active is set remove it, otherwise add it
//     el.classList.toggle("active");

	// $('.user-area> a').on('click', function(event) {
	// 	event.preventDefault();
	// 	event.stopPropagation();
	// 	$('.user-menu').parent().removeClass('open');
	// 	$('.user-menu').parent().toggleClass('open');
	// });


});