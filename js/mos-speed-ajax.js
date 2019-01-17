jQuery(document).ready(function($) {
	$('body').find('img').each(function( atts ) {
		var img = $(this);
		var src = $(this).attr("src");
		var width = $(this).attr("width");
		var height = $(this).attr("height");
		if (!width) {
	        $.ajax({
	            type: "POST",
	            url: speed_ajax_url,
	            data: {
	                action  : 'get_width',
	                src    :  src,
	            },
	            success:function( result ) {
	                console.log( result );  
	                img.attr("width", result);       
	            },
	            error: function(){
	                console.log('error'); // error
	            }
	        }); 			
			
		}
		if (!height) {
	        $.ajax({
	            type: "POST",
	            url: speed_ajax_url,
	            data: {
	                action  : 'get_height',
	                src    :  src,
	            },
	            success:function( result ) {
	                console.log( result );  
	                img.attr("height", result);       
	            },
	            error: function(){
	                console.log('error'); // error
	            }
	        }); 			
			
		}

	});
});