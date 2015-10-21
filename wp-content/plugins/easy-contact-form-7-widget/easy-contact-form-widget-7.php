<?php
   /*
   Plugin Name: Easy Contact Form 7 Widget
   Plugin URI: http://CustomWPNinjas.com/
   Description: Add Contact Form 7 in Widget
   Version: 1.0.0
   Author: CustomWPNinjas
   Author URI: http://www.CustomWPNinjas.com/
   */
   
   
/*  Copyright 2012, CustomWPNinjas.com.

Permission to use, copy, modify, and/or distribute this software for any purpose
with or without fee is strickly prohibited.

*/
/*
* Actions & Filters
*/
/* Add our function to the widgets_init hook. */
add_action( 'widgets_init', 'load_contact_form_7_widget' );

/* Function that registers our widget. */
function load_contact_form_7_widget() {
	register_widget( 'ContactFormWidget' );
}

class ContactFormWidget extends WP_Widget {
	function ContactFormWidget() {
		$widget_ops = array( 'classname' => 'Contact_Form', 'description' => 'Widget that displays a Contact Form 7.' );
		$control_ops = array( 'id_base' => 'contact-form' );
		$this->WP_Widget( 'contact-form', 'Contact Form 7', $widget_ops, $control_ops );
	}
	function widget( $args, $instance ) {
		extract( $args );

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$contact_form_id = $instance['contact_form'];
		
		/* Before widget (defined by themes). */
		echo $before_widget;
		if($contact_form_id) {
			$contact_form = get_post( $contact_form_id );
		}

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		/* Display Form Using shortcode*/
		if($contact_form_id) {
			echo do_shortcode('[contact-form-7 id="'.$contact_form->ID.'" title="'.$contact_form->post_title.'"]');
		}

		/* After widget (defined by themes). */
		echo $after_widget;
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['contact_form'] = strip_tags( $new_instance['contact_form'] );

		return $instance;
	}
	function form( $instance ) {
		if (! defined( 'WPCF7_PLUGIN_NAME' )) {
		?>
			<p>Please install and activate Contact Form 7</p>
		<?php
			return;
		}
		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Contact Form 7', 'contact_form' => 0 );
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		$post_args = array('post_type' => 'wpcf7_contact_form');
		$contact_forms = get_posts( $post_args );
?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'ContactForm' ); ?>">Select Form:</label> 
			<select id="<?php echo $this->get_field_id( 'ContactForm' ); ?>" name="<?php echo $this->get_field_name( 'contact_form' ); ?>" class="widefat" style="width:100%;">
<?php
foreach( $contact_forms as $contact_form) {
?>
			<option <?php echo $contact_form->ID==$instance['contact_form']?'selected="selected"':'' ?> value="<?php echo $contact_form->ID; ?>"><?php echo $contact_form->post_title; ?></option>
<?php
}
?>
			</select>
		</p>
<?php
	}
}

?>