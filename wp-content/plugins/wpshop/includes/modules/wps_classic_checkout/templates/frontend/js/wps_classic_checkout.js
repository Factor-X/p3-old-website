jQuery( document ).ready( function() {
	jQuery( '#wps-checkout-step-errors').hide();
	
	
	jQuery( document ).on( 'click', '#wps-checkout-valid-step-three', function() {
		jQuery( this ).addClass( 'wps-bton-loading' );
		var data = {
				action: "wps-checkout_valid_step_three", 
				billing_address_id : jQuery( '#billing_address_address_list' ).val(),
				shipping_address_id : jQuery( '#shipping_address_address_list' ).val()
			};
			jQuery.post(ajaxurl, data, function(response){
				if( response['status'] ) {
					window.location.replace( response['response'] );
				}
				else {
					jQuery( '#wps-checkout-valid-step-three' ).removeClass( 'wps-bton-loading' );
					jQuery( '#wps-checkout-step-errors').html( response['response'] ).slideDown( 'slow' ).delay( 5000 ).slideUp( 'slow' ); 
				}
			}, 'json');	
	});
	
	jQuery( document ).on( 'click', '#wps-checkout-valid-step-four', function() {
		jQuery( this ).addClass( 'wps-bton-loading' );
		var data = {
				action: "wps-checkout_valid_step_four", 
				shipping_mode : jQuery( 'input[name=wps-shipping-method]:checked').val()
				
			};
			jQuery.post(ajaxurl, data, function(response){
				if( response['status'] ) {
					window.location.replace( response['response'] );
				}
				else {
					jQuery( '#wps-checkout-valid-step-four' ).removeClass( 'wps-bton-loading' );
					jQuery( '#wps-checkout-step-errors').html( response['response'] ).slideDown( 'slow' ).delay( 5000 ).slideUp( 'slow' ); 
				}
			}, 'json');	
	});
	
	
	jQuery( document ).on( 'click', '#wps-checkout-valid-step-five', function() {
		jQuery( this ).addClass( 'wps-bton-loading' );
		
		var terms_of_sale_checked = true;
		
		if ( jQuery( '#terms_of_sale' ).length> 0 ) {
			if ( jQuery( '#terms_of_sale' ).is( ':checked') ) {
			}
			else {
				terms_of_sale_checked = false;
			}
		}
		var data = {
				action: "wps-checkout_valid_step_five", 
				billing_address_id : jQuery( '#billing_address_address_list' ).val(),
				shipping_address_id : jQuery( '#shipping_address_address_list' ).val(),
				payment_method : jQuery( '#wps-selected-payment-method').val(), 
				terms_of_sale_checking : terms_of_sale_checked
				
			};
			jQuery.post(ajaxurl, data, function(response){
				if( response['status'] ) {
					window.location.replace( response['response'] );
				}
				else {
					jQuery( '#wps-checkout-valid-step-five' ).removeClass( 'wps-bton-loading' );
					jQuery( '#wps-checkout-step-errors').html( response['response'] ).slideDown( 'slow' ).delay( 5000 ).slideUp( 'slow' ); 
				}
			}, 'json');	
			
	});
	
});