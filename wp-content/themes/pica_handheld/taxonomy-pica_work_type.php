<?php 
	get_header();

	$taxonomy = 'pica_work_type';
	$queried_term = get_query_var($taxonomy);
	$term = get_term_by( 'slug', $queried_term, $taxonomy );
	
	$_SESSION['pica_work_category'] = $term;
	
	
	//print_r($wp_query);
?>
		<div id="content-wrapper">  
            <section class="back-controller">
            	<a href="<?php bloginfo('url') ?>" class="link-fill-container"><div class="back-arrow"></div><span>work</span></a>
            </section>                
            <section class="sub-content-wrapper">   
                <!-- Display work posts for the selected taxonomy term -->
                <div class="content-gallery in-list"><?php 
					//Prepare the arguments for our work post type selector
					$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
					
					$args = array( 	'post_type' => 'pica_work', 
									'pica_work_type' => $term->name, 
									'orderby' => 'menu_order', 
									'order' => 'ASC');
					$work_loop = new WP_Query($args); ?>
					                        
					<?php while ( $work_loop->have_posts() ) : $work_loop->the_post(); ?>
                    <div class="gallery-item in-list" style="background-color: #<?php echo get_post_meta($post->ID, 'work_bg_color', true) ?>;">
                        <a href="<?php the_permalink() ?>" class="link-fill-container" title="<?php echo "Learn about our work with " . $post->post_title ?>">
                            <div class="work-item-title" style="color: #<?php echo get_post_meta($post->ID, 'work_text_color', true) ?> !important;">
								<?php 
									$work_name = get_post_meta($post->ID, '_work_short_name', true);
									
									if (empty($work_name)) :
										$work_name = get_the_title($post->ID);
									endif;
									
									echo $work_name;
								?>
                            </div>
                        </a>
                    </div><?php endwhile; wp_reset_query(); wp_reset_postdata() ;?>      
                    
                </div> <!--end content gallery-->  
                <div class="clear"></div>    
            </section><!-- end .sub-content-wrapper -->
        </div>
        
<?php get_footer(); ?>