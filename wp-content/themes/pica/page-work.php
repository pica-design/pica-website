<?php get_header() ?>
      
      	<?php if (is_page('home')) : $body_class = " class='home'"; else: $body_class = "" ; endif ; ?>
        <section id="content-wrapper"<?php echo $body_class ?>>
      
      	<div id="page-title">
            <h1><?php echo $post->post_title ?></h1>
        </div>
            
		
		<?php 
            $loop = new WP_Query( array( 'post_type' => 'work') );
            while ( $loop->have_posts() ) : $loop->the_post(); ?>
                <a href="<?php the_permalink() ?>"><?php the_post_thumbnail() ?></a>
            <?php endwhile ?>      
            
                     
		</section>
        
<?php get_footer(); ?>