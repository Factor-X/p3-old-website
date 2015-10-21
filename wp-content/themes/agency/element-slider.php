<div class="flex-container">

	<!--slideshow-->
	
	<div class="flexslider">
	 	<ul class="slides">

<?php for ($i = 1; $i <= 2; $i++) { ?>
			<li>
			  <a href="<?php echo esc_url(of_get_option('slider_link'.$i)); ?>"><img src="<?php if(esc_url(of_get_option('slider_image'.$i)) != NULL){ echo esc_url(of_get_option('slider_image'.$i));} else echo get_template_directory_uri() . '/images/slide'.$i.'.png' ?>" alt="<?php echo esc_html(of_get_option('slider_head'.$i)); ?>" /></a>

			<p class="flex-caption"><?php if(esc_html(of_get_option('slider_head'.$i)) != NULL){ echo esc_html(of_get_option('slider_head'.$i));} else echo "Nullam posuere felis a lacus tempor eget dignissim arcu adipiscing." ?><p>

			</li>
			
			<?php } ?>
		
		</ul>
</div> <!--slideshow end-->

  </div><!--flex container end-->
  
  <div class="clear"></div>	