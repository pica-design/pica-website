<?php
	/*********************************************************
	WORDPRESS CORE MODIFICATIONS
	*********************************************************/
	remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
	remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
	remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
	remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
	remove_action( 'wp_head', 'index_rel_link' ); // index link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); // Display relational links for the posts adjacent to the current post.
	remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version
	remove_action( 'wp_head', 'rel_canonical'); //Remove the wp canonical url
	add_filter( 'next_post_rel_link', 'disable_stuff' );
	add_filter( 'excerpt_length', 'excerpt_length', 140 );	
	add_filter('excerpt_more', 'excerpt_more');
	function disable_stuff( $data ) { return false; }
	function excerpt_length( $length ) { return 140; }
	function excerpt_more($more) { return '...'; }

	add_filter('the_content', 'addlightboxrel_replace');
	function addlightboxrel_replace ($content){	
		global $post;
		$pattern = "/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
	  	$replacement = '<a$1href=$2$3.$4$5 rel="lightbox[%LIGHTID%]"$6>';
	    $content = preg_replace($pattern, $replacement, $content);
		$content = str_replace("%LIGHTID%", $post->ID, $content);
	    return $content;
	}
?>