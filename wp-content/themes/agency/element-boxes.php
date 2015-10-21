		<?php for ($i = 1; $i <= 3; $i++) { ?>
		
		<div class="large-4 columns">		
		
				<div class="boxes <?php if ($i == 1) {echo "box1";} ?><?php if($i == 2) {echo "box2";} ?> <?php if($i == 3) {echo "box3";} ?>">
						<div class="box-head">
								
	<a href="<?php echo esc_url(of_get_option('box_link' . $i)); ?>"><img src="<?php if(esc_url(of_get_option('box_image' . $i)) != NULL){ echo esc_url(of_get_option('box_image' . $i));} else echo get_template_directory_uri() . '/images/box' .$i. '.png' ?>" alt="<?php echo esc_html(of_get_option('box_head' . $i)); ?>" /></a>

					
					</div> <!--box-head close-->
					
				<div class="title-box">						
						
				<div class="title-head"><?php if(esc_html(of_get_option('box_head' . $i)) != NULL){ echo esc_html(of_get_option('box_head' . $i));} else echo "Box heading" ?></div></div>
					
					<div class="box-content">

				<p><?php if(esc_textarea(of_get_option('box_text' . $i)) != NULL){ echo esc_textarea(of_get_option('box_text' . $i));} else echo "Nullam posuere felis a lacus tempor eget dignissim arcu adipiscing. Donec est est, rutrum vitae bibendum vel, suscipit non metus." ?></p>
					
					</div> <!--box-content close-->

				
				</div><!--boxes  end-->
				
</div><!--col end-->				

		<?php } ?>