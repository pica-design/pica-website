<?php 
	//Include our theme header.php 
	get_header() ;
	echo "FOO BAR YO!";
	//Grab the gallery attached to this page
	$gallery = getGallery(get_post_meta($post->ID, 'gallery', true)) ;
?>
			<?php //while ( have_posts() ) : the_content();  ?>

				<?php //endwhile; // end of the loop. ?>
            <img src="<?php echo get_bloginfo('url') . '/' . $gallery['path'] . '/' . $gallery['images'][0]['filename'] ?>" alt="foo" />
<?php 
	//Include our theme footer.php
	get_footer() 
?>