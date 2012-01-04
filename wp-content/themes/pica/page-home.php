<?php 
	//Include our theme header.php 
	get_header() ;
	
	//Gather this posts gallery items
	$gallery = new Post_Gallery ;
	//print_r($gallery);
	//Create a random number between 0 and the count of the attachments in our gallery
	$random_number = rand(0, (count($gallery->attachments) - 1));
?>
        
                <div class="focal-point">
                    <div class="focal-point-item scalable-text">
                    	<div class="focal-point-text">
   	                   		<?php echo $gallery->attachments[$random_number]['post_content'] ?>
                        </div>
                    	<img src="<?php echo get_bloginfo('url') . '/wp-content/uploads/' . $gallery->attachments[$random_number]['meta_data']['_wp_attachment_metadata']['sizes']['extra-large']['file'] ?>" alt="<?php echo $gallery->attachments[$random_number]['post_content'] ?>" class="focal-point-image" />
                	</div>
                <div id="homepage-features"></div>         
<?php 
	//Include our theme footer.php
	get_footer() 
?>