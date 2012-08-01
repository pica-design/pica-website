<?php get_header() ?>

		<section class="sub-content-wrapper">
        
            <!-- Display page header --> 
            <div class="page-masthead brandnew-single">
                <!-- Display page title and sub title ex 'work . featured' -->
                <div class="page-title">
                    <h1>Brand New</h1>
                </div>    
                <div class="page-controller">
                    <!--<div class="older-posts-link"><?php previous_post_link() ?></div>
		            <div class="newer-posts-link"><?php next_post_link() ?></div>-->
                </div>                
            </div>
        </section><!-- end .sub-content-wrapper -->
        
        <div class="page-horizontal-divider"><div class="inner-page-horizontal-divider"></div></div>
            
        <section class="sub-content-wrapper">
        	<?php
				$gallery = new Post_Gallery;
				foreach ($gallery->attachments as $key => $attachment) : ?>
					<figure class="brandnew-attachment">
						<img class="attachment-image" src="<?php echo $attachment->guid ?>" alt="<?php echo $attachment->post_title ?>" />
                        <figcaption class="attachment-description">
                        	<?php if ($key == 0) : ?>
                            <h1><strong><?php echo $post->post_title ?></strong></h1>
							<?php endif ?>
                            <strong><?php echo $attachment->post_title ?></strong>
                        	<p><?php echo $attachment->post_content ?></p>
                        </figcaption>
                        <div class="clear"></div>
					</figure>
				<?php endforeach ?>
		</section><!-- end .sub-content-wrapper -->

<?php get_footer() ?>