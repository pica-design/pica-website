<?php 
	get_header();

	$taxonomy = 'type';
	$queried_term = get_query_var($taxonomy);
	$term = get_term_by( 'slug', $queried_term, $taxonomy );
?>
		
        <section class="sub-content-wrapper">
        
            <!-- Display page header --> 
            <div class="page-masthead">
            	<div class="page-masthead-inner">
                    <!-- Display page title and sub title ex 'work . featured' -->
                    <div class="page-title">
                    	<?php if (strtolower($term->name) != "featured") : ?>
                        <h1><a href="<?php bloginfo('url') ?>/work-categories/featured/" title="Back to our work">work</a></h1>
                        <figure class="dot-seperator"></figure>
                        <h2><?php echo $term->name ?></h2>
                        <?php else : ?>
                        <h2>work</h2>
						<?php endif ?>
                    </div>    
                    <!-- Display taxonomy filtering dropdown -->
                    <div class="page-controller">
                        <form id="work-filter">
                            <select name="work-type-filter-options" id="work-type-filter-options">
                                <option value="none" >Browse by..</option>
                                <?php
                                    $categories = get_categories(array('taxonomy' => 'type', 'orderby' => 'name', 'show_count' => 1, 'exclude' => 8));
                                    foreach ($categories as $category) :
                                ?>
                                <option value="<?php echo get_bloginfo('url') . "/work-categories/" . $category->slug?>" <?php selected( $term->name, $category->name ); ?>><?php echo $category->name ?></option>
                                <?php
                                    endforeach;
                                    //Grab the currently viewed taconomy term
                                    $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                                ?>
                            </select>
                        </form>
                    </div>                
            	</div>
            </div>
            
            <!-- Display work posts for the selected taxonomy term -->
            <div class="content-gallery grid">
                <?php 
                    //Prepare the arguments for our work post type selector
                    $args = array( 	'post_type' => 'work', 
                                    'type' => $term->name, 
                                    'orderby' => 'menu_order', 
                                    'order' => 'ASC');
                    $work_loop = new WP_Query($args);
                    while ( $work_loop->have_posts() ) : $work_loop->the_post(); 
                ?>
                <div class="gallery-item in-grid" style="background-color: #<?php echo get_post_meta($post->ID, 'work_bg_color', true) ?>;">
                    <a href="<?php the_permalink() ?>" class="link-fill-container" title="<?php echo "Learn about our work with " . $post->post_title ?>">
                        <?php the_title('<div class="work-item-title" style="color: #' . get_post_meta($post->ID, 'work_text_color', true) . ' !important;">', '</div>') ?>
                        <?php 
                            if (has_post_thumbnail()) :
                                $args = array(
                                    'alt'	=> "Our Partner " . $post->post_title, 
                                    'title' => "Learn about our work with " . $post->post_title
                                );
                                the_post_thumbnail('post-thumbnail', $args);
                            endif;
                        ?>
                    </a>
                </div><!--end gallery-item in-grid-->
                <?php endwhile ?>      
            </div> <!--end content gallery-->  
            <div class="clear"></div>    
		</section><!-- end .sub-content-wrapper -->
<?php get_footer(); ?>