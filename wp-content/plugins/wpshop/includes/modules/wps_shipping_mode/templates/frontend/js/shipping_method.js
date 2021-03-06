jQuery( document ).ready( function() {

	jQuery( document ).on( 'change', '#shipping_address_address_list', function() {
		var selected_address = jQuery( '#shipping_address_address_list' ).val();
		reload_shipping_methods( selected_address );
	});
	
	jQuery( document ).on( 'click' , 'input[name=wps-shipping-method]', function() {
		recalculate_shipping_cost( jQuery( this ).attr( 'id') );
	});
	
	function reload_shipping_methods( shipping_address_id ) {
		if( shipping_address_id != '' ) {
		var data = {
				action: "wps_load_shipping_methods",
				shipping_address : shipping_address_id
			
			};
			jQuery.post(ajaxurl, data, function(response) {
				if ( response['status'] ) {
					jQuery( '#wps-shipping-method-list-container' ).animate({'opacity' : 0.1}, 350, function() {
						jQuery( '#wps-shipping-method-list-container' ).html( response['response'] );
						jQuery( '#wps-shipping-method-list-container' ).animate({'opacity' : 1}, 350 );
					});
				}	
			}, 'json');
		}
	}
	
	function recalculate_shipping_cost( chosen_method ) {
		var data = {
				action: "wps_calculate_shipping_cost",
				chosen_method : chosen_method
			};
			jQuery.post(ajaxurl, data, function(response){
				if ( response['status'] )  {
					reload_wps_cart();
					reload_mini_cart();
					reload_summary_cart();
				}
			}, 'json');
	}
	
});