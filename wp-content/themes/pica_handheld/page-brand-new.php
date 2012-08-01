<?php 
	get_header();
?>
		
        <div id="content-wrapper">  
            <section class="back-controller">
                <a href="<?php bloginfo('url') ?>" class="link-fill-container"><div class="back-arrow"></div><span>brandnew</span></a>
            </section>
            <section class="sub-content-wrapper brandnew">   
                    <?php 
                        //Prepare the arguments for our work post type selector
                        //$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                        
                        $args = array( 	'post_type' => 'pica_brandnew',
                                        'orderby' => 'menu_order', 
                                        'order' => 'ASC');
                        $brandnew_loop = new WP_Query($args);
                        while ( $brandnew_loop->have_posts() ) : $brandnew_loop->the_post(); ?>
                            <div class="brandnew-post">
                                <h1><strong><?php echo $post->post_title ?></strong></h1>
                                <br />
                                <?php $gallery = new Post_Gallery($post->ID);
                                
								foreach ($gallery->attachments as $key => $attachment) : ?>
                                	<strong><?php echo $attachment->post_title ?></strong>
                                    <figure class="brandnew-attachment">
                                        <img class="attachment-image" src="<?php echo get_bloginfo('url') . '/wp-content/uploads/' . $attachment->meta_data['_wp_attachment_metadata']['sizes']['post-thumbnail']['file'] ?>" alt="<?php echo $attachment->post_title ?>" />
                                        <br />
                                        
                                        <p><?php echo $attachment->post_content ?></p>
                                        
                                    </figure>
                                <?php endforeach ?>
                                
                            </div>
                    <?php endwhile ?>      
                
            </section><!-- end .sub-content-wrapper -->
        </div>
        
<?php get_footer(); ?>