<?php 
	get_header();

	
?>
                   <div id="contentwrapper">
                    	<h1>work</h1>
                        <hr>
                        	<div id="portfoliowrapper">
								
                 			</div>		

				<br />
				<?php 
					$loop = new WP_Query( array( 'post_type' => 'work') );
					while ( $loop->have_posts() ) : $loop->the_post();
						?>
						<a href="<?php the_permalink() ?>">
							<?php the_post_thumbnail() ?>
						</a>
                        <?php
					endwhile;
                ?>
                            
                    </div><!--end contentwrapper--> 
<?php get_footer(); ?>