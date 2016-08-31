jQuery(function(){
	jQuery('.contactform').click(function(e) {

	 if (!e.isDefaultPrevented()) {
			var form=jQuery('.contact_form');
			
		var name = jQuery('#contact_name').val();
		var email = jQuery('#contact_email').val();
		var contactcomment = jQuery('#contactcomment').val();
		if(name =='') {
			jQuery('#contact_name').addClass('error');
		}else{ 
			jQuery('#contact_name').removeClass('error'); 
		}
		if(contactcomment ==''){
			jQuery('#contactcomment').addClass('error');
		}else{ 
			jQuery('#contactcomment').removeClass('error'); 
		}
		
		var filter = /^((\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*?)\s*;?\s*)+/;
		if(filter.test(email)){
			jQuery('#contact_email').removeClass('error'); 
		}else{
			jQuery('#contact_email').addClass('error');
		}			//Process Action
		jQuery.ajax({
			type: 'post',
			url: 'submitform.php',
			data: 'contact_name=' + name + '&contact_email=' + email + '&contactcomment=' + contactcomment,
			success: function(results) {
				jQuery('.response').html(results);
			}
		}); // end ajax
		// end ajax
		e.preventDefault();
 }
	});
});