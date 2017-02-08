$(function(){
	$( "#nav-icon1" ).click(function() {
	  $( ".select_data" ).toggleClass( "open" );
	});	
});

$(document).ready(function(){
	$('#nav-icon1').click(function(){
		$(this).toggleClass('open');
	});
});