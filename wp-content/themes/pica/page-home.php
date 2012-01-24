<?php 
	//Include our theme header.php 
	get_header() ;
	
	//Gather this posts gallery items
	$gallery = new Post_Gallery ;

	//Create a random number between 0 and the count of the attachments in our gallery
	$random_number = rand(0, (count($gallery->attachments) - 1));
	
	//echo $random_number ;
	
	//Check MIME types of attachments and output accordingly
		//Image - display with the html <img> tag
			//Patterns? 
		//Video - HTML5? YouTube? <embed> flv?
		
	//Generate our random attachment image path for display
	//Try to use the 'homepage' filesize if there is one of that size available
	if (isset($gallery->attachments[$random_number]['meta_data']['_wp_attachment_metadata']['sizes']['homepage'])) :
		$image_path = get_bloginfo('url') . '/wp-content/uploads/' . $gallery->attachments[$random_number]['meta_data']['_wp_attachment_metadata']['sizes']['homepage']['file'];
	else :
		$image_path = $gallery->attachments[$random_number]['guid'];
	endif;
	
?>
                <section class="focal-point single">
                    <div class="focal-point-item">
                    	<div class="focal-point-text scalable-text">
   	                   		<?php echo $gallery->attachments[$random_number]['post_content'] ?>                        
                        </div>
                    	<img src="<?php echo $image_path ?>" alt="<?php echo $gallery->attachments[$random_number]['post_title'] ?>" class="focal-point-image" />
                        <!--<embed src="<?php //echo $image_path ?>" class="focal-point-image" />-->
                	</div>
                </section>
                <br /><br />
                <section class="sub-content-wrapper">
                	<div id="renews">
                    	<a name="renews"></a>
                        <div class="renews-title"><h5 class="text-color-black intro">re:</h5><h5 class="text-color-lightgray">news</h5></div>
                        <br />
                            <?php					
                                global $post;
                                $args = array( 'numberposts' => 3, 'offset'=> 0, 'category' => 0 );
                                $myposts = get_posts( $args );
                                foreach( $myposts as $key => $post ) : setup_postdata($post) ?>
                                     <div class="blog-roll-container">
                                     	<a name="post-toggle-<?php echo $post->ID ?>"></a>
                                        <div class="blog-roll-preview">
                                            <div class="blog-roll-thumbnail">
                                                <?php 
													if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())) : 
														the_post_thumbnail('blogroll');
													else :
												?>
                                                <img src="<?php bloginfo('template_directory') ?>/images/placeholder.png" alt="<?php echo $post->post_title ?>" /> 
                                                <?php endif ?>
                                            </div><!--end blogrollthumbnail-->
                                            <div class="blog-roll-excerpt">
												<?php the_title('<h1>', '</h1>') ?>
                                                <?php the_excerpt('<p>', '</p>') ?>
                                                <br />
                                                <div class="blog-roll-toggle inactive post-<?php echo $key ?>" id="post-toggle-<?php echo $post->ID ?>">
                                                	<div class="arrow"></div>
                                                	<div class="text">tell me more</div>
                                                </div>
                                            </div><!--end blogrollexcerpt-->
                                        </div><!--end blogrollpreview-->   
                                        <div class="blog-roll-text">
                                        	<br />
                                        	<?php the_content() ?>
                                        </div><!--end blogrolltext-->
                                     </div><!--end blogrollcontainer-->
                            <?php endforeach; ?>
                    </div><!--end renews-->
                   	<div id="resocial">
                        <h5 class="text-color-black intro">re:</h5><h5 class="text-color-lightgray">social</h5>
                        <br />
                        <div class="twitter-container">
							<!--START TWITTERFEED-->
                        	<div class="tweet"></div>
							<!--END TWITTERFEED-->
                        </div><!--END .twitter-container-->
                    </div><!--END .social-->
                </section><!--END .sub-content-wrapper -->  
                <div class="clear"></div>   
<?php 
	//Include our theme footer.php
	get_footer() 
?>