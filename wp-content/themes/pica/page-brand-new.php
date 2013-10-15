<?php 
	get_header();
?>
		
                <section class="sub-content-wrapper">
                    <div class="page-masthead pica-work-taxonomy">
                        <div class="page-title">
                            <h1>Brand New Work</h1>
                        </div>    
                        <div class="page-controller"></div>                
                    </div>
                </section><!-- .sub-content-wrapper -->
                <div class="page-horizontal-divider"><div class="inner-page-horizontal-divider"></div></div>
                <section class="sub-content-wrapper brandnew"><?php 
                    //Prepare the arguments for our work post type selector
                    $args = array( 	'post_type' => 'pica_brandnew',
                                    'orderby' => 'menu_order', 
                                    'order' => 'ASC');
                    $brandnew_loop = new WP_Query($args);
                    while ( $brandnew_loop->have_posts() ) : $brandnew_loop->the_post(); ?>
        				
                    <div class="brandnew-post">
                        <a name="#!<?php echo $post->post_name ?>"></a><?php 
                        foreach ($post->attachments as $key => $attachment) : ?>
                        <figure class="brandnew-attachment">
                            <img class="attachment-image" src="<?php echo $attachment->guid ?>" alt="<?php echo $attachment->post_title ?>" />
                            <figcaption class="attachment-description"><?php if ($key == 0) : ?>

                                <h1><strong><?php echo $post->post_title ?></strong></h1><?php endif ?>

                                <strong><?php echo $attachment->post_title ?></strong>
                                <p><?php echo $attachment->post_content ?></p>
                            </figcaption>
                            <div class="clear"></div>
                        </figure><?php endforeach ?>
                            
                    </div><?php endwhile ?>      
                </section><!-- .sub-content-wrapper -->
<?php get_footer(); ?>