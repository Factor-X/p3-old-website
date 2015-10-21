<?php
				wp_enqueue_script( 'wps_orders', plugins_url('templates/backend/js/wps_orders.js', __FILE__) );
			$letter_interface = '';
			$alphabet = array( __('ALL', 'wpshop' ), 'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
			foreach( $alphabet as $a ) {
				$letter_interface .= wpshop_display::display_template_element('wps_orders_letter', $tpl_component, array(), 'admin');
			}
			return $letter_interface;
		}
					$output .= wps_orders::get_letters_for_product_listing();
				$output .= self::wps_generate_products_list_table_by_letter();
				$output .= wps_orders::get_letters_for_product_listing();

			echo $output;
		}
					$order_items[$product_id]['product_id'] = $product_id;
					if( isset($order_meta['order_items']) && is_array($order_meta['order_items']) ) {
						foreach($order_meta['order_items'] as $product_in_order) {
							if(!isset($order_items[$product_in_order['item_id']])){
								$order_items[$product_in_order['item_id']]['product_id'] = $product_in_order['item_id'];
								$order_items[$product_in_order['item_id']]['product_qty'] = $product_in_order['item_qty'];
							}
							else{
								$order_items[$product_in_order['item_id']]['product_qty'] += $product_in_order['item_qty'];
							}
						}
					}

					$order_meta = wpshop_cart::calcul_cart_information($order_items);

					/*	Update order content	*/
					update_post_meta($order_id, '_order_postmeta', $order_meta);
					$result = wpshop_orders::order_content( get_post($order_id) );
					$status = true;