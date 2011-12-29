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
								<?php foreach ($gallery['images'] as $image) : ?>				

                            <img src="<?php bloginfo('url') ?>/<?php echo $gallery['path'] ?>/<?php echo $image['filename'] ?>" alt="<?php echo $image['alttext'] ?>" class="contentblock shadow">
                        <?php endforeach ?>
                 			</div>		
                <?php
					if (have_posts()) :
						while (have_posts()) : the_post();
							the_content();
						endwhile;
					endif;
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