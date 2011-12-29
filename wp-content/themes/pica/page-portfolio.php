<?php 
	get_header();

	//Select our gallery
	global $siteUrl;
	$gallery = getGallery(1);
?>
                   <div id="contentwrapper">
                    	<h1>Page Title</h1>
                        <hr>
                        	<div id="portfoliowrapper">
								<!--<?php //foreach ($gallery['images'] as $image) : ?>				

                            <img src="<?php //bloginfo('url') ?>/<?php //echo $gallery['path'] ?>/<?php //echo $image['filename'] ?>" alt="<?php //echo $image['alttext'] ?>" class="contentblock shadow">
                        <?php //endforeach ?>-->
                 			</div>		

				<br />
				<?php 
					$loop = new WP_Query( array( 'post_type' => 'portfolio') );
					while ( $loop->have_posts() ) : $loop->the_post();
						//the_title();
						the_content();
						the_post_thumbnail();
					
					endwhile;
                ?>
                            <!--<div id="portfoliowrapper">
                            
                            		<div class="contentblock"></div>
                                    <div class="contentblock"></div>
                                    <div class="contentblock"></div>
                                    <div class="contentblock"></div>
                                    <div class="contentblock"></div>
                                    <div class="contentblock"></div>
                                    <div class="contentblock"></div>
                                    <div class="contentblock"></div>
                                    <div class="contentblock"></div>
                            </div><!--end portfoliowrapper-->
                    </div><!--end contentwrapper--> 
<?php get_footer(); ?>