<?php 
	//Include our theme header.php 
	get_header() ;

    the_post();

	//Grab our testimonial if there is one
	$work_testimonial = get_post_meta($post->ID, '_work_testimonial', true);
?>
		<section class="sub-content-wrapper">
            <div class="page-masthead single-work">
            	<div class="page-masthead-inner">
                    <div class="page-title">
                        <h1><a href="<?php bloginfo('url') ?>/work-categories/featured/" title="Back to our featured work">work</a></h1>
                        <figure class="dot-seperator"><div class="dot-image"></div></figure>
                        <h2><?php echo $post->post_title ?></h2>
                    </div>    
                    
                    <div class="page-controller"><?php if ($work_testimonial != "") : ?>

                        <div id="work-testimonial">
                        	<div id="work-testimonial-trigger"><a href="#" title="View <?php echo $post->post_title ?> Testimonial" class="link-fill-container">+</a></div>
                            <div id="work-testimonial-copy"><?php echo $work_testimonial ?></div>
                        </div><?php endif ?>

                    </div>                
                </div>
            </div>
        </section><!-- end .sub-content-wrapper -->
        <div class="page-horizontal-divider"><div class="inner-page-horizontal-divider"></div></div>
        <section class="sub-content-wrapper single-work"><?php 
			//Iterate through each attachment in this post's gallery and display them
			if (count($post->attachments) > 0) : 
				foreach ($post->attachments as $attachment) : 
                    $large_size = wp_get_attachment_image_src($attachment->ID, 'Large Uncropped');
                    $lightbox_size = wp_get_attachment_image_src($attachment->ID, 'Lightbox');
                ?>

    		<figure class="brandnew-attachment">
                <a href="<?php echo $lightbox_size[0] ?>" rel="lightbox[<?php echo $post->ID ?>]" title="<?php echo $attachment->post_title ?>">
                    <img class="attachment-image" src="<?php echo $large_size[0] ?>" alt="<?php echo $attachment->post_title ?>" />
                </a>
                <figcaption class="attachment-description">
                    <strong><?php echo $attachment->post_title ?></strong>
                    <p><?php echo $attachment->post_content ?></p>
                </figcaption>
                <div class="clear"></div>
            </figure><?php 
				endforeach; 
			endif; ?>
	
       </section><!-- end .sub-content-wrapper -->
<?php 
	//Include our theme footer.php
	get_footer() 
?>