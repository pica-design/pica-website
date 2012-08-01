<?php 
	get_header() ;
	
	$gallery = new Post_Gallery($post->ID);
?>

     <section class="sub-content-wrapper blog-header single">
        <div class="page-masthead">
            <div class="page-masthead-inner">
                <div class="page-title">
                    <div class="blog-post-date">
                        <span class="month"><?php the_time('M') ?></span>
                        <span class="year"><?php the_time('Y') ?></span>
                    </div>
                    <h1><?php echo $post->post_title ?></h1>
                </div>    
                <div class="page-controller">       
                	<div class="back-to">
                        <figure class="back-arrow"></figure>
                        <a href="<?php bloginfo('url') ?>/blog" title="Back to the blog" class="back-text">back to the blog </a>
                    </div>
                </div>                
            </div>
        </div>
    </section><!-- end .sub-content-wrapper -->

    <div class="page-horizontal-divider"><div class="inner-page-horizontal-divider"></div></div>
        
    <section class="sub-content-wrapper blog single">
    	<div class="blog-wrapper">
            <div class="blog-posts">
				<?php if ( have_posts() ) : ?> 
					<?php while ( have_posts() ) : the_post(); ?>           
                        <div class="blog-post">
                        	<?php
								//the_post_thumbnail()
								$image_id = get_post_thumbnail_id();
								$image_thumb = wp_get_attachment_image_src($image_id,'thumbnail', true);
								$image_large = wp_get_attachment_image_src($image_id,'large', true);
								if (!empty($image_thumb[0]) && $image_thumb[0] != get_bloginfo('url') . "/wp-includes/images/crystal/default.png") : 
							?>
                            	<a href="<?php echo $image_large[0] ?>" rel="lightbox" title="<?php echo $post->post_title ?> Image">
	                            	<img class="post-thumbnail" src="<?php echo $image_thumb[0] ?>" alt="<?php echo $post->post_title ?> Thumbnail Image" />
                                </a>
                            <?php endif ?>
	                        <?php the_content(); ?>
                            <?php if (count($gallery->attachments) > 1) : ?>
                            	<div class="blog-post-gallery">							
									<?php foreach ($gallery->attachments as $attachment) : ?>
    									<a href="<?php echo $attachment->guid ?>" title="<?php echo $attachment->post_title ?>" rel="lightbox-gallery">
                                            <img src="<?php echo get_bloginfo('url') . '/wp-content/uploads/' . $attachment->meta_data['_wp_attachment_metadata']['sizes']['thumbnail']['file'] ?>" alt="<?php echo $attachment->post_title ?>" />
                                        </a>
                                	<?php 	endforeach ?>
                                </div>
							<?php endif ?>
                        </div>
                    <?php endwhile ?>
                <?php endif; ?>
                <?php 
					if (get_post_meta($post->ID, '_post_allow_comments', true) == 1) :
						comments_template( '', true ); 
					endif;
				?>
            </div>
    		<div class="clear"></div>
            <br />        
            <div class="older-posts-link"><?php previous_post_link() ?></div>
            <div class="newer-posts-link"><?php next_post_link() ?></div>
         </div>
    </section><!-- end .sub-content-wrapper -->
        
<?php get_footer(); ?>