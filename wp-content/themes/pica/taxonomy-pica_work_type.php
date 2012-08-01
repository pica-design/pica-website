<?php 
	get_header();

	$taxonomy = 'pica_work_type';
	$queried_term = get_query_var($taxonomy);
	$term = get_term_by( 'slug', $queried_term, $taxonomy );
	
	$_SESSION['pica_work_category'] = $term;
?>
		
            <section class="sub-content-wrapper">
                <div class="page-masthead pica-work-taxonomy">
                    <div class="page-title"><?php if (strtolower($term->name) != "featured") : ?><h1><a href="<?php bloginfo('url') ?>/work-categories/featured/" title="Back to our featured work">work</a></h1><?php else : ?><h1>work</h1><?php endif ?></div>    
    
                    <div class="page-controller"><?php
                            $categories = get_categories(array('taxonomy' => 'pica_work_type', 'orderby' => 'name', 'show_count' => 1, 'exclude' => 8));
                            foreach ($categories as $category) :
                            
                                if ($category->name == $term->name) :
                                    $active_category = "active";
                                else :
                                    $active_category = "";
                                endif; ?>
                                
                        <div class="work-category-wrapper <?php echo $active_category ?>">
                            <div class="work-category-inner-wrapper">
                                <div class="work-category-trigger"><?php echo $category->name[0] ?></div>
                                <div class="work-category-link">
                                    <a href="<?php echo get_bloginfo('url') . "/work-categories/" . $category->slug?>" title="Browse Work Category <?php echo $category->name ?>"><?php echo $category->name ?></a>
                                </div>
                            </div>
                        </div><?php endforeach ?>
                        
                    </div>                
                </div>
            </section><!-- end .sub-content-wrapper -->
            
            <div class="page-horizontal-divider"><div class="inner-page-horizontal-divider"></div></div>
                
            <section class="sub-content-wrapper">   
                <!-- Display work posts for the selected taxonomy term -->
                <div class="content-gallery grid"><?php 
					//Prepare the arguments for our work post type selector
					$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
					
					$args = array( 	'post_type' => 'pica_work', 
									'pica_work_type' => $term->name, 
									'orderby' => 'menu_order', 
									'order' => 'ASC');
					$work_loop = new WP_Query($args); ?>
                    
					<script type="text/javascript">
						var gridImages = new Array(); 
						<?php
						$i = 0;
						while ( $work_loop->have_posts() ) : $work_loop->the_post();
							echo "gridImages[$i] = new Array(); gridImages[$i]['src'] = '" . get_permalink() . "'; gridImages[$i]['id'] = '" . $post->post_name . "';";
							$i++;
						endwhile; wp_reset_query(); ?>
					</script>                        

					<?php while ( $work_loop->have_posts() ) : $work_loop->the_post(); ?>
                    <div class="gallery-item in-grid" style="background-color: #<?php echo get_post_meta($post->ID, 'work_bg_color', true) ?>;">
                        <a href="<?php the_permalink() ?>" class="link-fill-container" title="<?php echo "Learn about our work with " . $post->post_title ?>">
                            <div class="work-item-title" style="color: #<?php echo get_post_meta($post->ID, 'work_text_color', true) ?> !important;"><?php the_title() ?></div>
                            <?php 
                                if (has_post_thumbnail()) :
                                    $args = array(
                                        'alt'	=> "Our Partner " . $post->post_title, 
                                        'title' => "Learn about our work with " . $post->post_title,
                                        'class' => "work-item-image",
										'id' 	=> $post->post_name
                                    );
                                    the_post_thumbnail('post-thumbnail', $args);
                                endif;
                            ?>
                            
                        </a>
                    </div><?php endwhile; wp_reset_query() ?>      
                </div> <!--end content gallery-->  
                <div class="clear"></div>    
            </section><!-- end .sub-content-wrapper -->
<?php get_footer(); ?>