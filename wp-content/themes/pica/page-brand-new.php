<?php 
	get_header();
?>
		
        <section class="sub-content-wrapper">
        
            <!-- Display page header --> 
            <div class="page-masthead pica-work-taxonomy">
                <!-- Display page title and sub title ex 'work . featured' -->
                <div class="page-title">
                    <h1>Brand New Work</h1>
                </div>    

                <div class="page-controller">
                    
                </div>                
            </div>
        </section><!-- end .sub-content-wrapper -->
        
        <div class="page-horizontal-divider"><div class="inner-page-horizontal-divider"></div></div>
            
        <section class="sub-content-wrapper brandnew">   
                <?php 
                    //Prepare the arguments for our work post type selector
                    $args = array( 	'post_type' => 'pica_brandnew',
                                    'orderby' => 'menu_order', 
                                    'order' => 'ASC');
                    $brandnew_loop = new WP_Query($args);
                    while ( $brandnew_loop->have_posts() ) : $brandnew_loop->the_post(); ?>
						<div class="brandnew-post">
							<?php $gallery = new Post_Gallery($post->ID);
                            foreach ($gallery->attachments as $key => $attachment) : ?>
                                <figure class="brandnew-attachment">
                                	<a name="#!<?php echo $post->post_name ?>"></a>
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
                        </div>
                <?php endwhile ?>      
            
		</section><!-- end .sub-content-wrapper -->
<?php get_footer(); ?>