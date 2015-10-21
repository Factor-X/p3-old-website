<?php get_header(); ?>
		
	<div id="subhead_container">
		
		<div class="row">

		<div class="large-12 columns">
		
		<h1><?php if ( is_category() ) {
		single_cat_title();
	} elseif (is_archive() ) {
		echo (__( 'Archives for ', 'agency' )); single_month_title();
	} else {
		wp_title('',true);
	} ?></h1>
			
			</div>	
			
	</div></div>


<!--content-->
		<div class="row" id="content_container">
				
	<!--left col--><div class="large-8 columns">
	
		<div id="left-col">
        
<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>
          
            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <p><?php _e('&#8249; Return to', 'agency'); ?> <a href="<?php echo esc_url(get_permalink($post->post_parent)); ?>" rel="gallery"><?php echo get_the_title($post->post_parent); ?></a></p>

			<div class="meta-data">
			
			<?php agency_posted_on(); ?> | <?php comments_popup_link( __( 'Leave a comment', 'agency' ), __( '1 Comment', 'agency' ), __( '% Comments', 'agency' ) ); ?>
			
			</div><!--meta data end-->
			<div class="clear"></div>
                                
                <div class="attachment-entry">
                    <a href="<?php echo esc_url(wp_get_attachment_url($post->ID)); ?>"><?php echo wp_get_attachment_image( $post->ID, 'large' ); ?></a>
					<?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?>
                    <?php the_content(__('Read more &#8250;;', 'agency')); ?>
                    <?php wp_link_pages(array('before' => '<div class="pagination">' . __('Pages:', 'agency'), 'after' => '</div>')); ?>
                </div><!-- end of .post-entry -->

          <nav id="nav-single">
				<span class="nav-previous"><?php previous_image_link( false, __('&larr; Previous Image', 'agency' )); ?></span>
				<span class="nav-next"><?php next_image_link( false, __('Next Image &rarr;', 'agency' )); ?></span>
            </span> </nav>
                        
                <?php if ( comments_open() ) : ?>
                <div class="post-data">
				    <?php the_tags(__('Tagged with:', 'agency') . ' ', ', ', '<br />'); ?> 
                    <?php the_category(__('Posted in %s', 'agency') . ', '); ?> 
                </div><!-- end of .post-data -->
                <?php endif; ?>             

            <div class="post-edit"><?php edit_post_link(__('Edit', 'agency')); ?></div>             
            </div><!-- end of #post-<?php the_ID(); ?> -->
            
			<?php comments_template( '', true ); ?>
            
        <?php endwhile; ?>  

<?php endif; ?>  
      
	</div> <!--left-col end-->
</div> <!--column end-->

<?php get_sidebar(); ?>

</div>
<!--content end-->
		

<?php get_footer(); ?>