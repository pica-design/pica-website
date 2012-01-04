<?php get_header() ?>
      
      	<div class="page-title">
            <h1><?php echo $post->post_title ?></h1>
        </div>
		
        <div class="content-gallery">
			<?php 
                $work_loop = new WP_Query( array( 'post_type' => 'work') );
                while ( $work_loop->have_posts() ) : $work_loop->the_post(); 
			?>
            <div class="gallery-item in-grid" style="background-color: #<?php echo get_post_meta($post->ID, 'work_bg_color', true) ?>;">
	            <a href="<?php the_permalink() ?>" class="link-fill-container" title="<?php the_title() ?>" style="color: #<?php echo get_post_meta($post->ID, 'work_text_color', true) ?>;">
					<?php //the_post_thumbnail() ?>
                    <?php the_title() ?>
                </a>
            </div>
            <?php endwhile ?>      
		</div>        
<?php get_footer(); ?>