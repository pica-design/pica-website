<?php get_header() ?>
      
      	<div class="page-title">
            <h1><?php echo $post->post_title ?></h1>
        </div>
<!--CHLOE IS PLAYING HERE!-->
        <h4>browse by:</h4>
			<?php
echo wp_tag_cloud( array( 'taxonomy' => 'work-categories') );
            ?>
        
        
<!--CHLOE IS NOW DONE PLAYING. PROCEED.-->
        
        
        
        <div class="content-gallery">
			<?php 
                $work_loop = new WP_Query( array( 'post_type' => 'work', 'type' => 'featured', 'orderby' => 'menu_order', 'order' => 'ASC') );
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
<?php get_footer(); ?>