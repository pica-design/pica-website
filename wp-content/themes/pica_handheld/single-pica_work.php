<?php 
	//Include our theme header.php 
	get_header() ;

	//Gather this posts gallery items
	$gallery = new Post_Gallery ;
	
	//Grab our testimonial if there is one
	$work_testimonial = get_post_meta($post->ID, '_work_testimonial', true);
?>
		
        
        
        <div id="content-wrapper">  
            <section class="back-controller">
                <a href="<?php bloginfo('url') ?>/work-categories/featured/" class="link-fill-container"><div class="back-arrow"></div><span><?php echo get_post_meta($post->ID, '_work_short_name', true) ?></span></a>
            </section>
            
            <section class="sub-content-wrapper single-work">
                <section class="content-gallery in-list">
                    <div class="gallery">
                        <?php if (isset($post->post_content)) : ?>
                        <article class="gallery-item in-list text-slide" style="background-color: #<?php echo get_post_meta($post->ID, 'work_bg_color', true) ?>; color: #<?php echo get_post_meta($post->ID, 'work_text_color', true) ?>;">
                            <div><?php echo $post->post_content ?></div>
                        </article><!--end .intro-slide-->
                        <?php endif ?>
                        <?php 
                            //Iterate through each attachment in this post's gallery and display them
                            if (count($gallery->attachments) > 0) :
                                foreach ($gallery->attachments as $attachment) : 
                                    ?>
                                    <figure class="gallery-item in-list image-slide">
                                        <img src="<?php echo get_bloginfo('url') . '/wp-content/uploads/' . $attachment->meta_data['_wp_attachment_metadata']['sizes']['post-thumbnail']['file'] ?>" alt="<?php echo $attachment->post_title ?>" />
                                    </figure>
                                    <?php 
                                endforeach; 
                            endif;
                        ?>
                    </div><!-- end .gallery -->
                    <div class="gallery-nav">
                        <a class="gallery-prev" href="#" title="Previous"></a> 
                        <a class="gallery-next" href="#" title="Next"></a>
                    </div><!-- end .gallery-nav -->
                </section><!-- end .content-gallery -->	
           </section><!-- end .sub-content-wrapper -->
       </div>
<?php 
	//Include our theme footer.php
	get_footer() 
?>