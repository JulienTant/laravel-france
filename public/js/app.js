
$(document).ready(function() {

	/* Nav */
	$('.menu li').mouseenter(function(){
		$(this).find('ul').stop(true,false).slideDown(200);
	}).mouseleave(function(){
		$(this).find('ul').stop(true,false).slideUp(200);
	});

});