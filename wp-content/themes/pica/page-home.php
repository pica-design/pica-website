<?php 
	//Include our theme header.php 
	get_header() ;
	
	//Grab the gallery attached to this page
	$gallery = getGallery(get_post_meta($post->ID, 'gallery', true)) ;
?>

            <img src="<?php echo get_bloginfo('url') . '/' . $gallery['path'] . '/' . $gallery['images'][0]['filename'] ?>" alt="foo" />
<?php 
	//Include our theme footer.php
	get_footer() 
?>