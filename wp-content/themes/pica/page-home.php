<?php 
	//Include our theme header.php 
	get_header() ;
	
	//Gather this posts gallery items
	$gallery = new Post_Gallery ;
	//print_r($gallery);
	//Create a random number between 0 and the count of the attachments in our gallery
	$random_number = rand(0, (count($gallery->attachments) - 1));

	if (isset($gallery->attachments[$random_number]['meta_data']['_wp_attachment_metadata']['sizes']['extra-large'])) :
		$image_path = get_bloginfo('url') . '/wp-content/uploads/' . $gallery->attachments[$random_number]['meta_data']['_wp_attachment_metadata']['sizes']['extra-large']['file'];
	else :
		$image_path = $gallery->attachments[$random_number]['guid'];
	endif;
	
?>
        
                <div class="focal-point single">
                    <div class="focal-point-item">
                    	<div class="focal-point-text scalable-text">
   	                   		<?php echo $gallery->attachments[$random_number]['post_content'] ?>                        </div>
                    	<img src="<?php echo $image_path ?>" alt="<?php echo $gallery->attachments[$random_number]['post_title'] ?>" class="focal-point-image" />
                        <!--<embed src="<?php //echo $image_path ?>" class="focal-point-image" />-->
                	</div>
                </div>
                <br /><br />
                <div id="home-featured-wrapper">
                	<div id="renews">
                        <div class="renews-title"><h5 class="text-color-black intro">re:</h5><h5 class="text-color-lightgray">news</h5></div>
                        <br />
                            <?php					
                                global $post;
                                $args = array( 'numberposts' => 2, 'offset'=> 0, 'category' => 0 );
                                $myposts = get_posts( $args );
                                foreach( $myposts as $post ) :	setup_postdata($post); ?>
                                     <div class="blog-roll-container">
                                        <div class="blog-roll-preview">
                                            <div class="blog-roll-thumbnail">
                                                <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())) : ?>
                                                    <?php the_post_thumbnail('blogroll');?>
                                                <?php else :?>
                                                <img src="<?php echo get_bloginfo('template_directory');?>/images/placeholder.png" alt=""/> 
        
                                                <?php endif;?>
                                            </div><!--end blogrollthumbnail-->
                                            <div class="blog-roll-excerpt">
                                                    <?php the_title('<h1>', '</h1>'); ?>
                                                    <?php the_excerpt('<p>', '</p>'); ?>
                                                <br />
                                                    <a href="<?php the_permalink(); ?>" class="inactive"><h2 >tell me more</h2></a>
                                            </div><!--end blogrollexcerpt-->
                                        </div><!--end blogrollpreview-->   
                                        <div class="blog-roll-text">
                                        <br />
                                                <?php the_content(); ?>
                                        </div><!--end blogrolltext-->
                                     </div><!--end blogrollcontainer-->
                            <?php endforeach; ?>
                    </div><!--end renews-->
                   	<div id="resocial">
                        <h5 class="text-color-black intro">re:</h5><h5 class="text-color-lightgray">social</h5>
                        <br />
                        <div class="twitter-container">
                        
                        </div>
                    </div><!--end social-->
                        
                </div><!--end homfeaturedwrapper-->  
                <div class="clear"></div>   
<?php 
	//Include our theme footer.php
	get_footer() 
?>