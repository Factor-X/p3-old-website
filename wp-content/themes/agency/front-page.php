<?php if ( 'posts' == get_option( 'show_on_front' ) ) {
    include( get_home_template() );
} else { ?>

<?php get_header(); ?>

	<!--welcome-->
	<div id="welcome_container">

	<div class="row">
		<div class="large-8 columns">

			<div id="welcome-box">
		
	<h1><?php if(esc_html(of_get_option('welcome_head')) != NULL){ echo esc_html(of_get_option('welcome_head'));} else echo "Your welcome headline here" ?></h1>
	<p><?php if(esc_textarea(of_get_option('welcome_text')) != NULL){ echo esc_textarea(of_get_option('welcome_text'));} else echo "Nullam posuere felis a lacus tempor eget dignissim arcu adipiscing. Donec est est, rutrum vitae bibendum vel, suscipit non metus. Nullam posuere felis a lacus tempor eget dignissim arcu adipiscing. Donec est est, rutrum vitae bibendum vel, suscipit non metus." ?></p>
		
	</div>
	
</div><!--col end-->
	
	<div class="large-4 columns">	
	
		<div id="quote-box">
		
	<div id="author-quote"><p><?php if(esc_textarea(of_get_option('quote_text')) != NULL){ echo esc_textarea(of_get_option('quote_text'));} else echo "Nullam posuere felis a lacus tempor eget dignissim arcu adipiscing. Donec est est, rutrum vitae bibendum vel, suscipit non metus." ?></p></div>
		<div id="author-name"><?php if(esc_html(of_get_option('author_text')) != NULL){ echo esc_html(of_get_option('author_text'));} else echo "- Manish G" ?></div>
	</div>	
	
</div><!--col end-->	
	
</div><!--row end-->	
</div><!--welcome end-->


<div class="clear"></div>
				
		<!--boxes-->
		<div id="box_container">
		
	<div class="row">		
				
		<?php get_template_part( 'element-boxes', 'index' ); ?>
		
</div><!--row end-->			
		
		</div><!--box-container end-->
			
			<div class="clear"></div>

<?php get_footer(); ?>

<?php } ?>